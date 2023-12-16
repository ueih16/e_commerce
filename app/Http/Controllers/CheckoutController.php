<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Helpers\Cart;
use App\Mail\NewOrderEmail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{

    public function checkout(Request $request)
    {
        $user = $request->user();
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        [$products, $cartItems] = Cart::getProductsAndCartItems();

        $orderItems = [];
        $lineItems = [];
        $totalPrice = 0;
        foreach($products as $product) {
            $quantity = $cartItems[$product->id]['quantity'];
            $totalPrice += $product->price * $quantity;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        'images' => [$product->image],
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $quantity,
            ];
            $orderItems[] = [
                'product_id'    => $product->id,
                'quantity'      => $quantity,
                'unit_price'    => $product->price,
            ];
        }

        $session = $stripe->checkout->sessions->create([
            'line_items'        => $lineItems,
            'mode'              => 'payment',
            'customer_creation' => 'always',
            'success_url'       => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'        => route('checkout.failure', [], true),
        ]);

        // Create Order
        $orderData = [
            'total_price'   => $totalPrice,
            'status'        => OrderStatus::Unpaid,
            'created_by'    => $user->id,
            'updated_by'    => $user->id,
        ];
        $order = Order::create($orderData);

        // Create Order Items
        foreach($orderItems as $orderItem) {
            $orderItem['order_id'] = $order->id;
            OrderItem::create($orderItem);
        }



        // Create Payment
        $paymentData = [
            'order_id'      => $order->id,
            'amount'        => $totalPrice,
            'status'        => PaymentStatus::Pending,
            'type'          => 'cc',
            'session_id'    => $session->id,
            'created_by'    => $user->id,
            'updated_by'    => $user->id,
        ];
        $payment = Payment::create($paymentData);

        CartItem::where('user_id', $user->id)->delete();

        return redirect($session->url);
    }
    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
        $user = $request->user();

        try{
            $session_id = $request->get('session_id');
            $session = $stripe->checkout->sessions->retrieve($session_id);
            if(!$session) {
                return view('checkout.failure', ['message' => 'Invalid SessionID !']);
            }

            $payment = Payment::where(['session_id' => $session_id])
                ->whereIn('status', [PaymentStatus::Pending->value, PaymentStatus::Paid->value])
                ->first();

            if(!$payment) {
                throw new NotFoundHttpException();
            }

            if($payment->status === PaymentStatus::Pending->value) {
                $this->updateOrderAndSession($payment);
            }


            $customer = $stripe->customers->retrieve($session->customer);

            return view('checkout.success', compact('customer'));

        } catch(NotFoundHttpException $e) {
            throw $e;
        } catch(\Exception $e) {
            return view('checkout.failure', ['message' => $e->getMessage()]);
        }

    }

    public function failure(Request $request)
    {
        return view('checkout.failure', ['message' => 'Your payment was not successful !']);
    }

    public function checkoutOrder(Order $order)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        foreach($order->orderItem as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name'   => $item->product->title,
                        'images' => [$item->product->image],
                    ],
                    'unit_amount' => $item->unit_price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = $stripe->checkout->sessions->create([
            'line_items'        => $lineItems,
            'mode'              => 'payment',
            'customer_creation' => 'always',
            'success_url'       => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'        => route('checkout.failure', [], true),
        ]);

        $order->payment->session_id = $session->id;
        $order->payment->save();

        return redirect($session->url);
    }

    public function webhook()
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        // whsec_ddcbc1d15d18c2587b4b1ab2e771947c1100f2697bb1a5d208a09b88e493bb94

        $endpoint_secret = 'whsec_ddcbc1d15d18c2587b4b1ab2e771947c1100f2697bb1a5d208a09b88e493bb94';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 401);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 402);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $paymentIntent = $event->data->object;
                $sessionId = $paymentIntent['id'];
                $payment = Payment::where(['session_id' => $sessionId])
                    ->whereIn('status', [PaymentStatus::Pending->value, PaymentStatus::Paid->value])
                    ->first();

                if($payment) {
                    $this->updateOrderAndSession($payment);
                }
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('', 200);
    }

    public function updateOrderAndSession(Payment $payment)
    {
//        $payment->status = PaymentStatus::Paid->value;
//        $payment->update();
//
//        $order = $payment->order()->first();
//        $order->status = OrderStatus::Paid->value;
//        $order->save();

        DB::beginTransaction();
        try {
            $payment->status = PaymentStatus::Paid->value;
            $payment->update();

            $order = $payment->order;

            $order->status = OrderStatus::Paid->value;
            $order->update();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical(__METHOD__ . ' method does not work. '. $e->getMessage());
            throw $e;
        }

        DB::commit();

        try {
            $adminUsers = User::where('is_admin', 1)->get();

            foreach ([...$adminUsers, $order->user] as $user) {
                Mail::to($user)->send(new NewOrderEmail($order, (bool)$user->is_admin));
            }
        } catch (\Exception $e) {
            Log::critical('Email sending does not work. '. $e->getMessage());
        }
    }
}
