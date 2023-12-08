<x-app-layout>
    <div
        x-data="{
            flashMessage: '{{ \Illuminate\Support\Facades\Session::get('flash_message') }}',
            init() {
                if(this.flashMessage) {
                    setTimeOut(() => this.$dispatch('notify', {message: flashMessage}), 200)
                }
            }
        }"
        class="container p-5 mx-auto lg:w-2/3"
    >
        <div class="grid items-end grid-cols-1 gap-6 md:grid-cols-3">
            <div class="p-3 bg-white rounded-lg shadow md:col-span-2">
                <form
                    method="post"
                    action="{{ route('profile.update') }}"
                    x-data="{
                        countries: {{ json_encode($countries) }},
                        billingAddress: {{ json_encode([
                            'address1' => old('billing.address1', $billingAddress->address1),
                            'address2' => old('billing.address2', $billingAddress->address2),
                            'city' => old('billing.city', $billingAddress->city),
                            'state' => old('billing.state', $billingAddress->state),
                            'country_code' => old('billing.country_code', $billingAddress->country_code),
                            'zipcode' => old('billing.zipcode', $billingAddress->zipcode),
                        ]) }},
                        shippingAddress: {{ json_encode([
                            'address1' => old('shipping.address1', $shippingAddress->address1),
                            'address2' => old('shipping.address2', $shippingAddress->address2),
                            'city' => old('shipping.city', $shippingAddress->city),
                            'state' => old('shipping.state', $shippingAddress->state),
                            'country_code' => old('shipping.country_code', $shippingAddress->country_code),
                            'zipcode' => old('shipping.zipcode', $shippingAddress->zipcode),
                        ]) }},
                        get billingCountryStates() {
                            const country = this.countries.find(c => c.code === this.billingAddress.country_code)
                            if (country && country.states) {
                                return JSON.parse(country.states);
                            }
                            return null;
                        },
                        get shippingCountryStates() {
                            const country = this.countries.find(c => c.code === this.shippingAddress.country_code)
                            if (country && country.states) {
                                return JSON.parse(country.states);
                            }
                            return null;
                        }
                    }"
                >

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
