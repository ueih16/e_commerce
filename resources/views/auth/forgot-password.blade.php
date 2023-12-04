<x-app-layout>
    <div class="flex items-center justify-center">
        <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">

            <form method="POST" action="{{ route('password.email') }}" class="w-[400px] mx-auto p-6 my-16">
                @csrf

                <h2 class="mb-5 text-2xl font-semibold text-center">
                    Enter your Email to reset password
                </h2>
                <p class="mb-6 text-center text-gray-500">
                    or
                    <a href="{{ route('login')  }}" class="text-purple-600 hover:text-purple-500">
                        login with existing account
                    </a>
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mt-2" :status="session('status')" />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <div class="mb-3">
                    <x-text-input
                        required
                        id="loginEmail"
                        type="email"
                        name="email"
                        placeholder="Your email address"
                        class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500"
                    />
                </div>
                <button class="w-full btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700">
                    Submit
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
