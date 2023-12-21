<?php

namespace App\Http\Controllers\Api;

use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
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
}
