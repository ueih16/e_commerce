<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class CheckoutController extends Controller
{

    public function checkout(Request $request)
    {
        $user = $request->user();
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        [$products, $cartItems] = Cart::getProductsAndCartItems();

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
        }

        $session = $stripe->checkout->sessions->create([
            'line_items'        => $lineItems,
            'mode'              => 'payment',
            'customer_creation' => 'always',
            'success_url'       => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'        => route('checkout.failure', [], true),
        ]);

        $orderData = [
            'total_price'   => $totalPrice,
            'status'        => OrderStatus::Unpaid,
            'created_by'    => $user->id,
            'updated_by'    => $user->id,
        ];
        $order = Order::create($orderData);

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

            $payment = Payment::where(['session_id' => $session->id, 'status' => PaymentStatus::Pending->value])->first();
            if(!$payment) {
                return view('checkout.failure', ['message' => 'Your payment does not exist !']);
            }
            $payment->status = PaymentStatus::Paid->value;
            $payment->update();

            $order = $payment->order()->first();
            $order->status = OrderStatus::Paid->value;
            $order->save();

            CartItem::where('user_id', $user->id)->delete();

            $customer = $stripe->customers->retrieve($session->customer);
            return view('checkout.success', compact('customer'));

        } catch(\Exception $e) {
            return view('checkout.failure');
        }

    }

    public function failure(Request $request)
    {
        dd($request);
    }
}
