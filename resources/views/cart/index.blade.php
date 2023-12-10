<x-app-layout>
    <div class="container mx-auto lg:w-2/3 xl:w-2/3">
        <h1 class="mb-6 text-3xl font-bold">Your Cart Items</h1>

        <div
            x-data="{
                cartItems: {{ json_encode(
                    $products->map(
                        fn($product) => [
                            'id' => $product->id,
                            'slug' => $product->slug,
                            'image' => $product->image,
                            'title' => $product->title,
                            'price' => $product->price,
                            'quantity' => $cartItems[$product->id]['quantity'],
                            'href' => route('product.view', $product->slug),
                            'removeUrl' => route('cart.remove', $product),
                            'updateQuantityUrl' => route('cart.update-quantity', $product),
                        ],
                    ),
                ) }},
                get cartTotal() {
                    return this.cartItems.reduce((accum, next) => accum + next.price * next.quantity, 0).toFixed(2)
                },
            }"
            class="p-4 bg-white rounded-lg shadow"
        >
            <!-- Product Items -->
            <template x-if="cartItems.length">
                <div>
                    <!-- Product Item -->
                    <template
                        x-for="product of cartItems"
                        :key="product.id"
                    >
                        <div x-data="productItem(product)">
                            <div class="flex flex-col items-center flex-1 w-full gap-4 sm:flex-row">
                                <a
                                    :href="product.href"
                                    class="flex items-center justify-center h-32 overflow-hidden w-36"
                                >
                                    <img
                                        :src="product.image"
                                        class="object-cover"
                                        alt=""
                                    />
                                </a>
                                <div class="flex flex-col justify-between flex-1">
                                    <div class="flex justify-between mb-3">
                                        <h3 x-text="product.title"></h3>
                                        <span class="text-lg font-semibold">
                                            $<span x-text="product.price"></span>
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            Qty:
                                            <input
                                                type="number"
                                                min="1"
                                                x-model="product.quantity"
                                                @change="changeQuantity()"
                                                class="w-16 py-1 ml-3 border-gray-200 focus:border-purple-600 focus:ring-purple-600"
                                            />
                                        </div>
                                        <button
                                            @click.prevent="removeItemFromCart()"
                                            class="text-purple-600 hover:text-purple-500"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!--/ Product Item -->
                            <hr class="my-5"/>
                        </div>
                    </template>
                    <!-- Product Item -->

                    <div class="pt-4 border-t border-gray-300">
                        <div class="flex justify-between">
                            <span class="font-semibold">Subtotal</span>
                            <span
                                id="cartTotal"
                                class="text-xl"
                                x-text="`$${cartTotal}`"
                            ></span>
                        </div>
                        <p class="mb-6 text-gray-500">
                            Shipping and taxes calculated at checkout.
                        </p>

                        <form method="post" action="{{ route('checkout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full py-3 text-lg btn-primary"
                            >
                                Proceed to Checkout
                            </button>
                        </form>
                    </div>
                </div>
                <!--/ Product Items -->
            </template>
            <template x-if="!cartItems.length">
                <div class="py-8 text-center text-gray-500">
                    You don't have any items in cart
                </div>
            </template>
        </div>
    </div>
</x-app-layout>
