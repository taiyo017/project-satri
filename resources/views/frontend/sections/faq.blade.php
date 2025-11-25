@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();

    $heading = $fields['heading'] ?? '';
    $contents = $fields['content'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $layout = $fields['layout'] ?? 'accordion'; // accordion / list

    $faqs = \App\Models\FAQ::all();
@endphp

<section
    class="relative py-20 lg:py-28 px-6 sm:px-10 lg:px-14 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900 overflow-hidden">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-4xl mx-auto relative">

        {{-- Section Header --}}
        <div class="text-center mb-16">
            @if ($subtitle)
                <span
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm tracking-wide font-semibold
                    bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                    border border-[#1363C6]/20 dark:border-[#1363C6]/30
                    shadow-sm shadow-[#1363C6]/10">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ strtoupper($subtitle) }}
                </span>
            @endif

            @if ($heading)
                <h2 class="text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight">
                    {{ $heading }}
                </h2>
            @endif

            @if ($contents)
                <p class="text-[16px] leading-[26px] text-gray-600 dark:text-gray-400">
                    {{ $contents }}
                </p>
            @endif
        </div>

        {{-- ACCORDION LAYOUT --}}
        @if ($layout === 'accordion')
            <div class="space-y-4">
                @foreach ($faqs as $index => $faq)
                    <div x-data="{ open: false }"
                        class="group rounded-xl overflow-hidden 
                        border border-gray-100 dark:border-gray-800 
                        bg-white dark:bg-gray-900 
                        hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50
                        hover:shadow-lg hover:shadow-[#1363C6]/5
                        transition-all duration-300">

                        {{-- Question Button --}}
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center gap-4 p-5 text-left cursor-pointer
                            group-hover:bg-gray-50 dark:group-hover:bg-gray-800/50 transition-colors duration-300">

                            <span
                                class="text-[18px] font-semibold text-gray-900 dark:text-white 
                                group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors duration-300">
                                {{ $faq['question'] ?? '' }}
                            </span>

                            {{-- Plus/Minus Icon --}}
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-lg 
                                bg-[#1363C6]/10 dark:bg-[#1363C6]/20 
                                flex items-center justify-center
                                group-hover:bg-[#1363C6] dark:group-hover:bg-[#1363C6]
                                transition-all duration-300">
                                <svg x-show="!open"
                                    class="w-5 h-5 text-[#1363C6] dark:text-[#4a8dd8]
                                    group-hover:text-white transition-colors duration-300"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>

                                <svg x-show="open"
                                    class="w-5 h-5 text-[#1363C6] dark:text-[#4a8dd8]
                                    group-hover:text-white transition-colors duration-300"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                </svg>
                            </div>
                        </button>

                        {{-- Answer --}}
                        <div x-show="open" x-collapse class="border-t border-gray-100 dark:border-gray-800">
                            <div
                                class="p-5 pt-4 text-[16px] leading-[26px] text-gray-600 dark:text-gray-400 bg-gray-50/50 dark:bg-gray-800/50">
                                {{ $faq['answer'] ?? '' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- LIST LAYOUT --}}
        @if ($layout === 'list')
            <div class="space-y-5">
                @foreach ($faqs as $index => $faq)
                    <div
                        class="group p-5 rounded-xl 
                        bg-white dark:bg-gray-900 
                        border border-gray-100 dark:border-gray-800 
                        hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50
                        hover:shadow-lg hover:shadow-[#1363C6]/5
                        transition-all duration-300">

                        <div class="flex items-start gap-4">
                            {{-- Question Icon --}}
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-lg 
                                bg-gradient-to-br from-[#1363C6] to-[#0d4a94]
                                flex items-center justify-center
                                group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>

                            <div class="flex-1">
                                {{-- Question --}}
                                <h3
                                    class="text-[18px] font-semibold text-gray-900 dark:text-white mb-2
                                    group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors duration-300">
                                    {{ $faq['question'] ?? '' }}
                                </h3>

                                {{-- Answer --}}
                                <p class="text-[16px] leading-[26px] text-gray-600 dark:text-gray-400">
                                    {{ $faq['answer'] ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Empty State --}}
        @if ($faqs->isEmpty())
            <div
                class="text-center py-20 bg-white dark:bg-gray-900 rounded-xl 
                border border-gray-100 dark:border-gray-800">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-full 
                    bg-gradient-to-br from-[#1363C6] to-[#0d4a94] mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-[20px] font-bold text-gray-900 dark:text-white mb-2">No FAQs Available</h3>
                <p class="text-[16px] text-gray-600 dark:text-gray-400">
                    Check back soon for frequently asked questions!
                </p>
            </div>
        @endif

    </div>
</section>
