<x-guest-layout>
    <div class="max-w-md mx-auto bg-white/90 backdrop-blur-xl p-8 rounded-2xl shadow-xl border border-gray-200">

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Two-Factor Authentication') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Please enter the 6-digit code sent to your email address.') }}
            </p>
            @if (isset($email) && $email)
                <p class="mt-1 text-xs font-medium text-blue-600">
                    {{ $email }}
                </p>
            @endif
        </div>

        <form method="POST" action="{{ route('two-factor.login.submit') }}">
            @csrf

            <div>
                <x-input-label for="code" class="text-gray-800 font-semibold" :value="__('Verification Code')" />

                <x-text-input id="code"
                    class="block mt-1 w-full text-center text-2xl tracking-[0.5em] font-bold rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition py-3"
                    type="text" name="code" required autofocus maxlength="6" placeholder="123456"
                    autocomplete="one-time-code" />

                <x-input-error :messages="$errors->get('code')" class="mt-2 text-center" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-center" />
            </div>

            <div class="mt-6">
                <x-primary-button
                    class="w-full justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow-md transition text-lg">
                    {{ __('Verify & Login') }}
                </x-primary-button>
            </div>

            <div class="mt-4 text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-400 hover:text-gray-600 underline transition">
                        {{ __('Cancel and return to login') }}
                    </button>
                </form>
            </div>
        </form>
    </div>
</x-guest-layout>
