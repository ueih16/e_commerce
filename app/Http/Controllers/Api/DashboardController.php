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
use App\Traits\ReportTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ReportTrait;
    public function activeCustomers(Request $request): int
    {
        $fromDate = $this->getFromDate();
        $query = Customer::query()->where('status', CustomerStatus::Active->value);
        if($fromDate) {
            $query->where('created_at', '>', $fromDate);
        }
        return $query->count();
    }

    public function activeProducts(): int
    {
        $fromDate = $this->getFromDate();
        $query = Product::query()
            ->where('published', '=', 1);
        if($fromDate) {
            $query->where('created_at', '>', $fromDate);
        }
        return $query->count();
    }

    public function paidOrders(): int
    {
        $fromDate = $this->getFromDate();
        $query = Order::query()->where('status', OrderStatus::Paid->value);
        if($fromDate) {
            $query->where('created_at', '>', $fromDate);
        }
        return $query->count();
    }

    public function totalIncome()
    {
        $fromDate = $this->getFromDate();
        $query = Order::query()->where('status', OrderStatus::Paid->value);
        if($fromDate) {
            $query->where('created_at', '>', $fromDate);
        }
        return $query->sum('total_price');
    }

    public function ordersByCountry()
    {
        $fromDate = $this->getFromDate();
        $query = Order::query()
            ->select(['c.name', DB::raw('count(orders.id) as count')])
            ->join('users', 'created_by', '=', 'users.id')
            ->join('customer_addresses AS a', 'users.id', '=', 'a.customer_id')
            ->join('countries AS c', 'a.country_code', '=', 'c.code')
            ->where('status', OrderStatus::Paid->value)
            ->where('a.type', AddressType::Billing->value)
            ->groupBy('c.name');

        if ($fromDate) {
            $query->where('orders.created_at', '>', $fromDate);
        }

        return $query->get();
    }

    public function latestCustomers()
    {
        $fromDate = $this->getFromDate();
        $customers = Customer::query()
            ->from('customers AS c')
            ->select('c.first_name', 'c.last_name', 'u.email', 'u.id')
            ->where('status', CustomerStatus::Active->value)
            ->join('users AS u', 'c.user_id', '=', 'id')
            ->orderBy('c.created_at', 'desc')
            ->limit(5);
        if($fromDate) {
            $customers->where('c.created_at', '>', $fromDate);
        }
        return $customers->get();
    }

    public function latestOrders()
    {
        $fromDate = $this->getFromDate();
        $latestOrders = Order::query()
            ->from('orders AS o')
            ->select('o.id', 'o.created_at', 'o.total_price', DB::raw('count(oi.id) as items'), 'c.user_id', 'c.first_name', 'c.last_name')
            ->where('o.status', OrderStatus::Paid->value)
            ->join('order_items AS oi', 'o.id', '=', 'oi.order_id')
            ->join('customers AS c', 'o.created_by', '=', 'c.user_id')
            ->limit(10)
            ->orderBy('o.created_at', 'desc')
            ->groupBy('o.id', 'o.created_at', 'o.total_price', 'c.user_id', 'c.first_name', 'c.last_name');
        if($fromDate) {
            $latestOrders->where('o.created_at', '>', $fromDate);
        }
        return OrderResource::collection($latestOrders->get());
    }
}
