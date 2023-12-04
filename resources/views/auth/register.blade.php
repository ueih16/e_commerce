<x-app-layout>
    <div class="flex items-center justify-center">
        <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
            <form method="POST" action="{{ route('register') }}" class="w-[400px] mx-auto p-6 my-16">
                @csrf

                <h2 class="mb-4 text-2xl font-semibold text-center">Create an account</h2>
                <p class="mb-6 text-center text-gray-500">
                    or
                    <a href="{{ route('login') }}" class="text-sm text-purple-700 hover:text-purple-600">
                        login with existing account
                    </a>
                </p>

                <!-- Name -->
                <div class="mb-4">
                    <x-text-input
                        id="name"
                        class="w-full border-gray-300 rounded-md focus:outline-none"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        placeholder="Your name"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

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
                    Signup
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
