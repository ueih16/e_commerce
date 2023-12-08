<?php

namespace App\Http\Controllers;

use App\Enums\AddressType;
use App\Models\Country;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function view(Request $request): View
    {
        $user = $request->user();
        $customer = $user->customer;

        $shippingAddress = $customer->shippingAddress ?: new CustomerAddress(['type' => AddressType::Shipping]);
        $billingAddress = $customer->billingAddress ?: new CustomerAddress(['type' => AddressType::Billing]);

//        dd($customer, $shippingAddress->attributesToArray(), $billingAddress, $billingAddress->customer);

        $countries = Country::query()->orderBy('name')->get();

        return view('profile.view', compact('user', 'customer', 'shippingAddress', 'billingAddress', 'countries'));
    }
}
