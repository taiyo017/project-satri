<x-guest-layout>
    <!-- Card Wrapper -->
    <div class="max-w-md mx-auto bg-white/90 backdrop-blur-xl p-8 rounded-2xl shadow-xl border border-gray-200">
        
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Reset Password') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" class="text-gray-800 font-semibold" :value="__('Email')" />
                <x-text-input id="email" 
                    class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition py-2" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    placeholder="name@example.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow-md transition text-lg">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-gray-600 underline transition">
                    {{ __('Back to Login') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
