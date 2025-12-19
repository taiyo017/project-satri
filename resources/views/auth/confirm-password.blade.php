<x-guest-layout>
    <!-- Card Wrapper -->
    <div class="max-w-md mx-auto bg-white/90 backdrop-blur-xl p-8 rounded-2xl shadow-xl border border-gray-200">
        
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Secure Area') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" class="text-gray-800 font-semibold" :value="__('Password')" />

                <x-text-input id="password" 
                    class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition py-2"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" 
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow-md transition text-lg">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
            
             <div class="mt-4 text-center">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-400 hover:text-gray-600 underline transition">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
