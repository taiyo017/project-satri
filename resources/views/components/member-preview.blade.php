<div id="teamMemberModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/80 backdrop-blur-sm">

    {{-- Modal Container --}}
    <div class="relative w-full max-w-4xl max-h-[90vh] modal-content">

        {{-- Close Button - TOP RIGHT --}}
        <button id="closeModal"
            class="absolute -top-4 -right-4 z-50 w-10 h-10 flex items-center justify-center
            bg-white dark:bg-gray-800 rounded-full shadow-lg
            text-gray-700 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-400
            hover:scale-110 hover:rotate-90 transition-all duration-300
            border-2 border-gray-200 dark:border-gray-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Modal Content Card --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl overflow-hidden">
            <div class="flex flex-col md:flex-row max-h-[85vh]">

                {{-- Left: Photo & Social Section --}}
                <div
                    class="md:w-2/5 bg-gradient-to-br from-[#1363C6]/10 via-[#1363C6]/5 to-transparent 
                    dark:from-[#1363C6]/20 dark:via-[#1363C6]/10 dark:to-transparent 
                    p-8 flex flex-col items-center justify-center relative">

                    {{-- Decorative circles --}}
                    <div class="absolute top-4 right-4 w-24 h-24 bg-[#1363C6]/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-4 left-4 w-32 h-32 bg-[#0d4a94]/10 rounded-full blur-2xl"></div>

                    <div class="relative z-10 flex flex-col items-center w-full">
                        {{-- Photo --}}
                        <div class="relative mb-6">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-full opacity-20 blur-xl">
                            </div>
                            <div id="modalPhoto"
                                class="relative w-40 h-40 rounded-full shadow-2xl border-4 border-white dark:border-gray-800 
                                overflow-hidden bg-gradient-to-br from-[#1363C6] to-[#0d4a94] 
                                flex items-center justify-center">
                            </div>
                        </div>

                        {{-- Name & Designation (Mobile Only) --}}
                        <div class="md:hidden text-center mb-6 w-full">
                            <h2 id="modalNameMobile" class="text-2xl font-extrabold text-gray-900 dark:text-white mb-2">
                            </h2>
                            <p id="modalDesignationMobile"
                                class="text-sm text-[#1363C6] dark:text-[#4a8dd8] font-semibold"></p>
                        </div>

                        {{-- Social Links --}}
                        <div class="w-full">
                            <p
                                class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide text-center mb-3">
                                Connect
                            </p>
                            <div id="modalSocialLinks" class="flex items-center justify-center flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                {{-- Right: Info Section --}}
                <div class="md:w-3/5 p-8 flex flex-col overflow-hidden">
                    {{-- Name & Designation (Desktop) --}}
                    <div class="hidden md:block mb-6">
                        <h2 id="modalName" class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2"></h2>
                        <p id="modalDesignation" class="text-lg text-[#1363C6] dark:text-[#4a8dd8] font-semibold"></p>
                        <div class="w-16 h-0.5 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] rounded-full mt-2"></div>
                    </div>

                    {{-- Bio Section (Scrollable) --}}
                    <div class="flex-1 overflow-y-auto pr-2">
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 mb-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-[#1363C6]/10 dark:bg-[#1363C6]/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-[#1363C6] dark:text-[#4a8dd8]" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">About</h3>
                            </div>
                            <div id="modalBio"
                                class="text-[15px] leading-[26px] text-gray-600 dark:text-gray-400 space-y-3"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
