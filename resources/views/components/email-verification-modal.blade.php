@if (Auth::check() && !Auth::user()->hasVerifiedEmail())
    <div x-data="{ showVerificationModal: true }" x-show="showVerificationModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">

        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" x-show="showVerificationModal"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        {{-- Modal Container --}}
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                x-show="showVerificationModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                {{-- Header with Icon --}}
                <div class="bg-gradient-to-br from-amber-500 to-orange-500 px-6 pt-8 pb-6">
                    <div class="flex items-center justify-center">
                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm">
                            <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-4 text-center text-2xl font-bold text-white" id="modal-title">
                        Verify Your Email Address
                    </h3>
                </div>

                {{-- Content --}}
                <div class="px-6 py-6">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Thanks for signing up! Before getting started, please verify your email address by clicking
                            on the link we just emailed to:
                        </p>
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg mb-4">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                            <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">
                                {{ Auth::user()->email }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            If you didn't receive the email, we will gladly send you another.
                        </p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div
                            class="mt-4 rounded-lg bg-green-50 dark:bg-green-900/30 p-4 border border-green-200 dark:border-green-800">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm font-medium text-green-800 dark:text-green-300">
                                    A new verification link has been sent to your email address!
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="mt-6 flex flex-col sm:flex-row gap-3">
                        <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Resend Verification Email
                            </button>
                        </form>

                        <button @click="showVerificationModal = false" type="button"
                            class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Close
                        </button>
                    </div>

                    {{-- Logout Link --}}
                    <div class="mt-4 text-center">
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 underline transition-colors">
                                Log out instead
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endif
