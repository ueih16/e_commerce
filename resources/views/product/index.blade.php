<x-app-layout>
    <div class="p-5">
        <div class="grid gap-8 p-5 grig-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <!-- Product Item -->
            @foreach ($products as $product)
                <div x-data="productItem({{ json_encode([
                    'id' => $product->id,
                    'image' => $product->image,
                    'title' => $product->title,
                    'price' => $product->price,
                    'addToCartUrl' => route('cart.add', $product),
                ]) }})"
                    class="transition-colors bg-white border border-gray-200 rounded-md border-1 hover:border-purple-600">
                    <a href="{{ route('product.view', $product->slug) }}"
                        class="block overflow-hidden aspect-w-3 aspect-h-2">
                        <img src="{{ $product->image }}" alt=""
                            class="object-cover transition-transform rounded-lg hover:scale-105 hover:rotate-1" />
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg">
                            <a href="{{ route('product.view', $product->slug) }}">
                                {{ $product->title }}
                            </a>
                        </h3>
                        <h5 class="font-bold">${{ $product->price }}</h5>
                    </div>
                    <div class="flex justify-between px-4 py-3">
                        <button class="btn-primary" @click="addToCart()">
                            Add to Cart
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{ $products->links() }}
</x-app-layout>
