@props(['section'])

@php
    // Extract main fields
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    $title = $fields['title'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $contentParagraphs = json_decode($fields['content_paragraphs'] ?? '[]', true) ?? [];
    $image = $fields['image'] ?? null;

    // Mission & Vision
    $mission = json_decode($fields['mission'] ?? '{}', true);
    $vision = json_decode($fields['vision'] ?? '{}', true);

    // Features
    $features = json_decode($fields['features'] ?? '[]', true) ?? [];
    // Buttons
    $buttons = isset($fields['buttons']) ? json_decode($fields['buttons'], true) : [];

    // Split paragraphs: first 3-4 for grid, rest for full width
    $initialParagraphs = array_slice($contentParagraphs, 0, 3);
    $remainingParagraphs = array_slice($contentParagraphs, 3);
@endphp

<section
    class="relative py-20 lg:py-28 px-6 sm:px-10 lg:px-14 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-950 overflow-hidden">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative space-y-16">

        {{-- Hero Section: Image + Initial Paragraphs --}}
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            {{-- Image Section --}}
            @if (!empty($image))
                <div class="relative group">
                    <div class="relative rounded-2xl overflow-hidden shadow-xl shadow-gray-900/10 dark:shadow-black/30">
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $title }}"
                            class="w-full h-[420px] object-cover group-hover:scale-105 transition-transform duration-700">

                        {{-- Overlay gradient --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#1363C6]/10 to-transparent 
                            opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                    </div>
                </div>
            @endif

            {{-- Text Content --}}
            <div class="space-y-5">
                @if ($title)
                    <h1 class="text-[40px] font-extrabold text-gray-900 dark:text-white leading-tight">
                        {{ $title }}
                    </h1>
                @endif

                @if ($subtitle)
                    <p class="text-[20px] text-gray-600 dark:text-gray-400 font-medium">
                        {{ $subtitle }}
                    </p>
                @endif

                @if (!empty($initialParagraphs))
                    <div class="space-y-4 text-[16px] leading-[26px] text-gray-600 dark:text-gray-400">
                        @foreach ($initialParagraphs as $para)
                            <p>{!! $para['paragraph'] !!}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Buttons --}}
                @if (!empty($buttons))
                    <div class="flex flex-wrap gap-4 pt-2">
                        @foreach ($buttons as $button)
                            <a href="{{ $button['url'] ?? '#' }}"
                                class="inline-flex items-center gap-2 px-6 py-3 
                                bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                                text-white font-semibold rounded-lg 
                                hover:shadow-lg hover:shadow-[#1363C6]/30 
                                transition-all duration-300 hover:scale-105">
                                <span>{{ $button['text'] }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Remaining Paragraphs - Full Width --}}
        @if (!empty($remainingParagraphs))
            <div class="bg-white dark:bg-gray-900 rounded-xl p-8 border border-gray-100 dark:border-gray-800">
                <div class="space-y-4 text-[16px] leading-[26px] text-gray-600 dark:text-gray-400">
                    @foreach ($remainingParagraphs as $para)
                        <p>{!! $para['paragraph'] !!}</p>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Features Section (Icon + Title Only) --}}
        @if (!empty($features))
            <div>
                <div class="text-center mb-8 ">
                    <span
                        class="inline-flex items-center gap-2 px-5 py-2 mt-3 rounded-full text-sm tracking-wide font-semibold
                        bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                        border border-[#1363C6]/20 dark:border-[#1363C6]/30
                        shadow-sm shadow-[#1363C6]/10">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                        WHY CHOOSE US
                    </span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    @foreach ($features as $feature)
                        <div
                            class="group relative bg-white dark:bg-gray-900 rounded-xl p-5 
                            border border-gray-100 dark:border-gray-800 
                            hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 
                            hover:shadow-lg hover:shadow-[#1363C6]/5 
                            transition-all duration-300 hover:-translate-y-0.5
                            text-center">
                            @if (!empty($feature['icon']))
                                <div
                                    class="w-12 h-12 flex items-center justify-center rounded-lg 
                                    bg-gradient-to-br from-[#1363C6] to-[#0d4a94] 
                                    text-white text-[20px] mx-auto mb-3 
                                    group-hover:scale-110 transition-transform duration-300">
                                    <i class="{{ $feature['icon'] }}"></i>
                                </div>
                            @endif
                            @if (!empty($feature['title']))
                                <h3
                                    class="text-[18px] font-semibold text-gray-900 dark:text-white
                                    group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors duration-300">
                                    {{ $feature['title'] }}
                                </h3>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Mission & Vision Section --}}
        <div class="grid lg:grid-cols-2 gap-6 mt-2">

            {{-- Mission --}}
            @if (!empty($mission))
                <div
                    class="group relative bg-white dark:bg-gray-900 rounded-xl p-6 
                    border border-gray-100 dark:border-gray-800 
                    hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 
                    hover:shadow-lg hover:shadow-[#1363C6]/5 
                    transition-all duration-300">

                    <div class="flex items-start gap-4 mb-4">
                        <div
                            class="w-11 h-11 flex items-center justify-center rounded-lg 
                            bg-gradient-to-br from-[#1363C6] to-[#0d4a94] 
                            flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            @if (!empty($mission['title']))
                                <h3
                                    class="text-[20px] font-bold text-gray-900 dark:text-white mb-1
                                    group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors duration-300">
                                    {{ $mission['title'] }}
                                </h3>
                            @endif
                            @if (!empty($mission['subtitle']))
                                <p class="text-[15px] text-[#1363C6] dark:text-[#4a8dd8] font-medium">
                                    {{ $mission['subtitle'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                    @if (!empty($mission['content']))
                        <p class="text-[16px] leading-[26px] text-gray-600 dark:text-gray-400">
                            {!! $mission['content'] !!}
                        </p>
                    @endif
                </div>
            @endif

            {{-- Vision --}}
            @if (!empty($vision))
                <div
                    class="group relative bg-white dark:bg-gray-900 rounded-xl p-6 
                    border border-gray-100 dark:border-gray-800 
                    hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 
                    hover:shadow-lg hover:shadow-[#1363C6]/5 
                    transition-all duration-300">

                    <div class="flex items-start gap-4 mb-4">
                        <div
                            class="w-11 h-11 flex items-center justify-center rounded-lg 
                            bg-gradient-to-br from-[#1363C6] to-[#0d4a94] 
                            flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd"
                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            @if (!empty($vision['title']))
                                <h3
                                    class="text-[20px] font-bold text-gray-900 dark:text-white mb-1
                                    group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors duration-300">
                                    {{ $vision['title'] }}
                                </h3>
                            @endif
                            @if (!empty($vision['subtitle']))
                                <p class="text-[15px] text-[#1363C6] dark:text-[#4a8dd8] font-medium">
                                    {{ $vision['subtitle'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                    @if (!empty($vision['content']))
                        <p class="text-[16px] leading-[26px] text-gray-600 dark:text-gray-400">
                            {!! $vision['content'] !!}
                        </p>
                    @endif
                </div>
            @endif
        </div>

    </div>
</section>
