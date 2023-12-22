<?php

namespace App\Http\Controllers\Api;

use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\OrderResource;
use App\Models\Api\Customer;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function activeCustomers(): int
    {
        return Customer::query()->where('status', CustomerStatus::Active->value)->count();
    }

    public function activeProducts(): int
    {
        return Product::query()->count();
    }

    public function paidOrders(): int
    {
        return Order::query()->where('status', OrderStatus::Paid->value)->count();
    }

    public function totalIncome()
    {
        return Order::query()->where('status', OrderStatus::Paid->value)->sum('total_price');
    }

    public function ordersByCountry()
    {
        $order = Order::query()
            ->from('Orders AS o')
            ->where('o.status', OrderStatus::Paid->value)
            ->join('users AS u', 'o.created_by', '=', 'u.id')
            ->join('customer_addresses AS ca', 'u.id', '=', 'ca.customer_id')
            ->where('ca.type', AddressType::Billing->value)
            ->join('countries AS c', 'ca.country_code', '=', 'c.code')
            ->select('c.name', DB::raw('count(o.id) AS count'))
            ->groupBy('c.name')
            ->get();
        return $order;
    }

    public function latestCustomers()
    {
        $customers = Customer::query()
            ->from('Customers AS c')
            ->select('c.first_name', 'c.last_name', 'u.email', 'u.id')
            ->where('status', CustomerStatus::Active->value)
            ->join('users AS u', 'c.user_id', '=', 'id')
            ->orderBy('c.created_at', 'desc')
            ->limit(5)
            ->get();
        return $customers;
    }

    public function latestOrders()
    {
        $latestOrders = Order::query()
            ->from('Orders AS o')
            ->select('o.id', 'o.created_at', 'o.total_price', DB::raw('count(oi.id) as items'), 'c.user_id', 'c.first_name', 'c.last_name')
            ->where('o.status', OrderStatus::Paid->value)
            ->join('Order_items AS oi', 'o.id', '=', 'oi.order_id')
            ->join('Customers AS c', 'o.created_by', '=', 'c.user_id')
            ->limit(10)
            ->orderBy('o.created_at', 'desc')
            ->groupBy('o.id', 'o.created_at', 'o.total_price', 'c.user_id', 'c.first_name', 'c.last_name')
            ->get();
        return OrderResource::collection($latestOrders);
    }
}
