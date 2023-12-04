<x-app-layout>
    <div class="flex items-center justify-center">
        <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
            <form
                method="POST"
                action="{{ route('password.store') }}"
                class="w-[400px] mx-auto p-6 my-16"
            >
                <h2 class="mb-4 text-2xl font-semibold text-center">Reset password</h2>
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}" />

                <!-- Email Address -->
                <div class="mb-4">
                    <x-text-input
                        id="email"
                        class="w-full border-gray-300 rounded-md focus:outline-none"
                        type="email"
                        name="email"
                        required
                        placeholder="Your email"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-text-input
                        id="password"
                        class="w-full border-gray-300 rounded-md focus:outline-none"
                        type="password"
                        name="password"
                        required
                        placeholder="Your password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-text-input
                        id="password-confirmation"
                        class="w-full border-gray-300 rounded-md focus:outline-none"
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="Your password confirmation"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <button class="w-full btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700">
                    Submit
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
