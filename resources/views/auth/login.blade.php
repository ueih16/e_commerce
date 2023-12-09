<x-app-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex items-center justify-center">
        <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
            <form action="{{ route('login')  }}" method="post" class="w-[400px] mx-auto p-6 my-16">
                @csrf
                <h2 class="mb-5 text-2xl font-semibold text-center">
                    Login to your account
                </h2>
                <p class="mb-6 text-center text-gray-500">
                    or
                    <a href="{{ route('register')  }}" class="text-sm text-purple-700 hover:text-purple-600">
                        create new account
                    </a>
                </p>

                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <div class="mb-4">
                    <x-input
                        :value="old('email')"
                        id="loginEmail"
                        type="email"
                        name="email"
                        placeholder="Your email address"
                        required
                    />
                    <label for="loginEmail" class="hidden">Email</label>
                </div>
                <div class="mb-4">
                    <x-input
                        id="loginPassword"
                        type="password"
                        name="password"
                        placeholder="Your password"
                        required
                    />
                    <label for="loginPassword" class="hidden">Password</label>
                </div>

                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center">
                        <input
                            id="loginRememberMe"
                            name="remember"
                            type="checkbox"
                            class="mr-3 text-purple-500 border-gray-300 rounded focus:ring-purple-500"
                        />
                        <label for="loginRememberMe">Remember Me</label>
                    </div>
                    <a href="{{ route('password.request')  }}" class="text-sm text-purple-700 hover:text-purple-600">
                        Forgot Password?
                    </a>
                </div>
                <button class="w-full btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700">
                    Login
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
