@php
    use Carbon\Carbon
@endphp

<x-app-layout>
    <div class="container mx-auto lg:w-2/3 xl:w-2/3">
        <h1 class="mb-6 text-3xl font-bold">My Orders</h1>

        <div class="p-3 bg-white rounded-md shadow-md">
            <table class="table w-full table-auto">
                <thead class="border-b-2">
                <tr class="text-left">
                    <th>Order</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th class="w-64">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="border-b">
                        <td>
                            <a
                                href="{{ route('order.view', $order) }}"
                                class="text-purple-600 hover:text-purple-500"
                            >
                                #{{$order->id}}
                            </a>
                        </td>
                        <td>{{ Carbon::parse($order->created_at)->format('jS M, Y G:iA') }}</td>
                        <td>
                            <span
                                class="text-white p-1 rounded {{ $order->isPaid() ? 'bg-emerald-500' : 'bg-gray-500' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-2 py-1 whitespace-nowrap">
                            {{ $order->order_item_count }} item(s)
                        </td>
                        </td>
                        <td>${{ $order->total_price }}</td>
                        <td class="flex gap-3">
                            @if($order->isUnpaid())
                                <form method="post" action="{{ route('checkout-order', $order) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="flex items-center px-2 py-1 btn-primary"
                                    >
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
                                        Pay
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
