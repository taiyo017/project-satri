<x-guest-layout>

    <!-- Card Wrapper -->
    <div class="max-w-md mx-auto bg-white/90 backdrop-blur-xl p-8 rounded-2xl shadow-xl border border-gray-200">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" class="text-gray-800 font-semibold" :value="__('Email')" />
                <x-text-input id="email"
                    class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" class="text-gray-800 font-semibold" :value="__('Password')" />

                <x-text-input id="password"
                    class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition"
                    type="password" name="password" required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ms-2 text-sm text-gray-700">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-blue-600 hover:text-blue-800 transition"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button
                    class="ms-3 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md transition">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

    </div>

</x-guest-layout>
