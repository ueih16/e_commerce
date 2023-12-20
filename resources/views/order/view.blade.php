@php use Carbon\Carbon @endphp

<x-app-layout>
    <div class="container mx-auto lg:w-2/3 xl:w-2/3">
        <h1 class="mb-6 text-3xl font-bold">Order #{{ $order->id }} Details</h1>

        <div class="p-3 bg-white rounded-md shadow-md">
            <div>
                <table class="table-sm">
                    <tbody>
                        <tr>
                            <td class="font-bold">Order #</td>
                            <td>{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Order Date</td>
                            <td>{{ Carbon::parse($order->created_at)->format('jS M, Y G:iA') }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Status</td>
                            <td>
                                <span
                                    class="text-white p-1 rounded {{ $order->isPaid() ? 'bg-emerald-500' : 'bg-gray-500' }}"
                                >
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold">SubTotal</td>
                            <td>${{ $order->total_price }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr class="my-5" />

            <!-- Order Items -->
            <div>
                @foreach($order->orderItem as $item)
                <!-- Product Item -->
                <div class="flex gap-6">
                    <div class="flex items-center w-16 h-16 border border-gray-300">
                        <img src="{{ $item->product->image }}" alt="" />
                    </div>
                    <div class="flex flex-col justify-between flex-1">
                        <h3 class="mb-4 text-ellipsis">
                            {{ $item->product->title }}
                        </h3>
                        <h3 class="flex justify-between mb-4 text-ellipsis">
                            Quantity: {{ $item->quantity }}
                            <div class="mb-4 text-lg font-bold">${{ $item->unit_price }}</div>
                        </h3>
                    </div>
                </div>
                <!--/ Product Item -->
                <hr class="my-2" />
                @endforeach
            </div>
            <!--/ Order Items -->

            @if($order->isUnpaid())
            <form method="post" action="{{ route('checkout-order', $order) }}" class="pt-4 border-t border-gray-300">
                @csrf
                <button type="submit" class="flex items-center justify-center w-full py-3 text-lg btn-primary">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 mr-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                        />
                    </svg>
                    Proceed to Pay
                </button>
            </form>
            @else
            <a
                href="{{ route('order.index') }}"
                type="button"
                class="flex items-center justify-center w-full py-3 text-lg text-white bg-gray-600 rounded hover:bg-gray-700"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 mx-4"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to my orders
            </a>
            @endif
        </div>
    </div>
</x-app-layout>
