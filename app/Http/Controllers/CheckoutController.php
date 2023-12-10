<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function checkout(Request $request)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        list($products, $cartItems) = Cart::getProductsAndCartItems();

        foreach($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        'images' => [$product->image],
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $cartItems[$product->id]['quantity'],
            ];
        }

        $session = $stripe->checkout->sessions->create([
            'line_items'        => $lineItems,
            'mode'              => 'payment',
            'customer_creation' => 'always',
            'success_url'       => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'        => route('checkout.failure', [], true),
        ]);

        return redirect($session->url);
    }
    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);
        $customer = $stripe->customers->retrieve($session->customer);
    }

    public function failure(Request $request)
    {
        dd($request);
    }
}
