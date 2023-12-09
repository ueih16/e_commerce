<x-app-layout>
    <div
        x-data="{
            flashMessage: '{{\Illuminate\Support\Facades\Session::get('flash_message')}}',
            init() {
                if (this.flashMessage) {
                    setTimeout(() => this.$dispatch('notify', {message: this.flashMessage}), 200)
                }
            }
        }"
        class="container p-5 mx-auto lg:w-2/3"
    >
        @if (session('error'))
            <div class="px-3 py-2 mb-2 text-white bg-red-500 rounded">
                {{ session('error') }}
            </div>
        @endif
        <div class="grid items-start grid-cols-1 gap-6 md:grid-cols-3">
            <div class="p-3 bg-white rounded-lg shadow md:col-span-2">
                <form
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
                            const country = this.countries.find(country => country.code === this.billingAddress.country_code)
                            if (country && country.states) {
                                return JSON.parse(country.states);
                            }
                            return null;
                        },
                        get shippingCountryStates() {
                            const country = this.countries.find(country => country.code === this.shippingAddress.country_code)
                            if (country && country.states) {
                                return JSON.parse(country.states);
                            }
                            return null;
                        }
                    }"
                    action="{{ route('profile.update') }}"
                    method="post"
                >
                    @csrf
                    <h2 class="mb-2 text-xl font-semibold">Profile Details</h2>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <x-input
                            type="text"
                            name="first_name"
                            value="{{old('first_name', $customer->first_name)}}"
                            placeholder="First Name"
                            class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                        />
                        <x-input
                            type="text"
                            name="last_name"
                            value="{{old('last_name', $customer->last_name)}}"
                            placeholder="Last Name"
                            class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="text"
                            name="email"
                            value="{{old('email', $user->email)}}"
                            placeholder="Your Email"
                            class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="text"
                            name="phone"
                            value="{{old('phone', $customer->phone)}}"
                            placeholder="Your Phone"
                            class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                        />
                    </div>

                    <h2 class="mt-6 mb-2 text-xl font-semibold">Billing Address</h2>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-input
                                type="text"
                                name="billing[address1]"
                                x-model="billingAddress.address1"
                                placeholder="Address 1"
                                class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                            />
                        </div>
                        <div>
                            <x-input
                                type="text"
                                name="billing[address2]"
                                x-model="billingAddress.address2"
                                placeholder="Address 2"
                                class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-input
                                type="text"
                                name="billing[city]"
                                x-model="billingAddress.city"
                                placeholder="City"
                                class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                            />
                        </div>
                        <div>
                            <x-input
                                type="text"
                                name="billing[zipcode]"
                                x-model="billingAddress.zipcode"
                                placeholder="ZipCode"
                                class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-input
                                type="select"
                                name="billing[country_code]"
                                x-model="billingAddress.country_code"
                                class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                            >
                                <option value="">Select Country</option>
                                <template x-for="country of countries" :key="country.code">
                                    <option
                                        :selected="country.code === billingAddress.country_code"
                                        :value="country.code"
                                        x-text="country.name"
                                    ></option>
                                </template>
                            </x-input>
                        </div>
                        <div>
                            <template x-if="billingCountryStates">
                                <x-input
                                    type="select"
                                    name="billing[state]"
                                    x-model="billingAddress.state"
                                    class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                                >
                                    <option value="">Select State</option>
                                    <template x-for="[code, state] of Object.entries(billingCountryStates)" :key="code">
                                        <option
                                            :selected="code === billingAddress.state"
                                            :value="code"
                                            x-text="state"
                                        ></option>
                                    </template>
                                </x-input>
                            </template>
                            <template x-if="!billingCountryStates">
                                <x-input
                                    type="text"
                                    name="billing[state]"
                                    x-model="billingAddress.state"
                                    placeholder="State"
                                    class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                                />
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6 mb-2">
                        <h2 class="text-xl font-semibold">Shipping Address</h2>
                        <label for="sameAsBillingAddress" class="text-gray-700">
                            <input
                                @change="$event.target.checked ? shippingAddress = {...billingAddress} : ''"
                                id="sameAsBillingAddress"
                                type="checkbox"
                                class="mr-2 text-purple-600 focus:ring-purple-600"
                            />
                            Same as Billing
                        </label>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-input
                                type="text"
                                name="shipping[address1]"
                                x-model="shippingAddress.address1"
                                placeholder="Address 1"
                                class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                            />
                        </div>
                        <div>
                            <x-input
                                type="text"
                                name="shipping[address2]"
                                x-model="shippingAddress.address2"
                                placeholder="Address 2"
                                class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-input
                                type="text"
                                name="shipping[city]"
                                x-model="shippingAddress.city"
                                placeholder="City"
                                class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                            />
                        </div>
                        <div>
                            <x-input
                                name="shipping[zipcode]"
                                x-model="shippingAddress.zipcode"
                                type="text"
                                placeholder="ZipCode"
                                class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-input
                                type="select"
                                name="shipping[country_code]"
                                x-model="shippingAddress.country_code"
                                class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                            >
                                <option value="">Select Country</option>
                                <template x-for="country of countries" :key="country.code">
                                    <option
                                        :selected="country.code === shippingAddress.country_code"
                                        :value="country.code"
                                        x-text="country.name"
                                    ></option>
                                </template>
                            </x-input>
                        </div>
                        <div>
                            <template x-if="shippingCountryStates">
                                <x-input
                                    type="select"
                                    name="shipping[state]"
                                    x-model="shippingAddress.state"
                                    class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                                >
                                    <option value="">Select State</option>
                                    <template
                                        x-for="[code, state] of Object.entries(shippingCountryStates)"
                                        :key="code"
                                    >
                                        <option
                                            :selected="code === shippingAddress.state"
                                            :value="code"
                                            x-text="state"
                                        ></option>
                                    </template>
                                </x-input>
                            </template>
                            <template x-if="!shippingCountryStates">
                                <x-input
                                    type="text"
                                    name="shipping[state]"
                                    x-model="shippingAddress.state"
                                    placeholder="State"
                                    class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                                />
                            </template>
                        </div>
                    </div>

                    <button
                        class="bg-green-500 px-4 py-2 text-white text-base rounded-md hover:opacity-[85%]"
                        type="submit"
                    >
                        Update
                    </button>
                </form>
            </div>
            <div class="p-3 bg-white rounded-lg shadow">
                <form action="{{ route('profile_password.update') }}" method="post">
                    @csrf
                    <h2 class="mb-2 text-xl font-semibold">Update Password</h2>
                    <div class="mb-3">
                        <x-input
                            type="password"
                            name="old_password"
                            placeholder="Your Current Password"
                            class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="password"
                            name="new_password"
                            placeholder="New Password"
                            class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="password"
                            name="new_password_confirmation"
                            placeholder="Repeat New Password"
                            class="w-full border-gray-300 rounded focus:border-purple-600 focus:ring-purple-600"
                        />
                    </div>
                    <button
                        class="bg-green-500 px-4 py-2 text-white text-base rounded-md hover:opacity-[85%]"
                        type="submit"
                    >
                        Update password
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
