<x-guest-layout>
    <div class="max-w-md mx-auto bg-white/90 backdrop-blur-xl p-8 rounded-2xl shadow-xl border border-gray-200" 
         x-data="{
            countdown: 0,
            canResend: false,
            resending: false,
            successMessage: '',
            errorMessage: '',
            
            init() {
                this.startCountdown(30);
            },
            
            startCountdown(seconds) {
                this.countdown = seconds;
                this.canResend = false;
                
                const timer = setInterval(() => {
                    this.countdown--;
                    
                    if (this.countdown <= 0) {
                        clearInterval(timer);
                        this.canResend = true;
                    }
                }, 1000);
            },
            
            async resendCode() {
                if (!this.canResend || this.resending) return;
                
                this.resending = true;
                this.successMessage = '';
                this.errorMessage = '';
                
                try {
                    const response = await fetch('{{ route('two-factor.resend') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        this.successMessage = data.message;
                        this.startCountdown(30);
                    } else {
                        this.errorMessage = data.message || 'Failed to resend code. Please try again.';
                    }
                } catch (error) {
                    this.errorMessage = 'An error occurred. Please try again.';
                } finally {
                    this.resending = false;
                }
            },
            
            formatTime(seconds) {
                return seconds < 10 ? '0' + seconds : seconds;
            }
         }">

        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Two-Factor Authentication') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Please enter the 6-digit code sent to your email address.') }}
            </p>
            @if (isset($email) && $email)
                <div class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-lg">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">
                        {{ $email }}
                    </span>
                </div>
            @endif
        </div>

        {{-- Success Message --}}
        <div x-show="successMessage" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium text-green-800" x-text="successMessage"></p>
            </div>
        </div>

        {{-- Error Message --}}
        <div x-show="errorMessage" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium text-red-800" x-text="errorMessage"></p>
            </div>
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
        </form>

        {{-- Resend Code Section --}}
        <div class="mt-6 text-center">
            <div class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ __("Didn't receive the code?") }}</span>
            </div>
            
            <button @click="resendCode()" 
                    :disabled="!canResend || resending"
                    :class="canResend && !resending ? 'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white shadow-md hover:shadow-lg transform hover:scale-[1.02]' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-semibold text-sm transition-all duration-200 active:scale-95">
                
                <template x-if="resending">
                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </template>
                
                <template x-if="!resending">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </template>
                
                <span x-show="!canResend && !resending">
                    {{ __('Resend Code') }} (<span x-text="formatTime(countdown)">00</span>s)
                </span>
                <span x-show="canResend && !resending">
                    {{ __('Resend Code Now') }}
                </span>
                <span x-show="resending">
                    {{ __('Sending...') }}
                </span>
            </button>
            
            <p class="mt-3 text-xs text-gray-500">
                {{ __('Code expires in 10 minutes') }}
            </p>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-400 hover:text-gray-600 underline transition">
                    {{ __('Cancel and return to login') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
