@props(['section', 'index' => 0])

@php
    // Determine layout and styling based on section properties
    $hasImage = !empty($section->image);
    $imagePosition = $section->image_position ?? 'right';
    $alignment = $section->alignment ?? 'center';
    $bgColor = 'gray';
    $isAlternate = $index % 2 !== 0;

    // Background classes
    $bgClasses = match ($bgColor) {
        'gray' => 'bg-gray-50 dark:bg-gray-900',
        'blue' => 'bg-blue-50 dark:bg-blue-900/20',
        'transparent' => 'bg-transparent',
        default => 'bg-white dark:bg-gray-800',
    };

    // Text alignment classes
    $textAlignClasses = match ($alignment) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };
@endphp

<section class="relative py-10 lg:py-16 {{ $bgClasses }} overflow-hidden ">

    @if ($hasImage && $imagePosition === 'background')
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title ?? 'Section Background' }}"
                class="w-full h-full object-cover opacity-10 dark:opacity-5" loading="lazy" decoding="async">
        </div>
    @endif

    <div class="relative z-10 w-full px-4 lg:px-8">

        {{-- Top Image Layout --}}
        @if ($hasImage && $imagePosition === 'top')
            <div class="mb-12">
                <div class="rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title ?? 'Section Image' }}"
                        class="w-full h-auto max-h-96 object-cover" loading="lazy" decoding="async">
                </div>
            </div>
        @endif

        {{-- Main Content Area --}}
        <div
            class="grid grid-cols-1 {{ $hasImage && in_array($imagePosition, ['left', 'right']) ? 'lg:grid-cols-2' : '' }} gap-12 lg:gap-16 items-center">

            {{-- Image Left --}}
            @if ($hasImage && $imagePosition === 'left')
                <div class="order-1 lg:order-1" data-aos="fade-right">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl group">
                        <img src="{{ asset('storage/' . $section->image) }}"
                            alt="{{ $section->title ?? 'Section Image' }}"
                            class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-700"
                            loading="lazy" decoding="async">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>
                </div>
            @endif

            {{-- Content --}}
            <div class="order-2 {{ $hasImage && $imagePosition === 'left' ? 'lg:order-2' : '' }} {{ $hasImage && $imagePosition === 'right' ? 'lg:order-1' : '' }} {{ $textAlignClasses }}"
                data-aos="fade-up">

                {{-- Subtitle/Badge --}}
                @if ($section->title)
                    <div
                        class="mb-4 {{ $alignment === 'center' ? 'flex justify-center' : ($alignment === 'right' ? 'flex justify-end' : '') }}">
                        <span
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 ring-1 ring-blue-700/10 dark:ring-blue-300/10">
                            {{ $section->title }}
                        </span>
                    </div>
                @endif

                {{-- Title --}}
                @if ($section->subtitle)
                    <h2
                        class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                        {{ $section->subtitle }}
                    </h2>
                @endif

                {{-- Content --}}
                @if ($section->content)
                    <div
                        class="prose prose-lg dark:prose-invert max-w-none mb-8 text-gray-600 dark:text-gray-300 {{ $alignment === 'center' ? 'mx-auto' : '' }}">
                        {!! $section->content !!}
                    </div>
                @endif

                {{-- Buttons --}}
                @if ($section->button_text && $section->button_link)
                    <div
                        class="flex flex-wrap gap-4 {{ $alignment === 'center' ? 'justify-center' : ($alignment === 'right' ? 'justify-end' : '') }}">
                        {{-- Primary Button --}}
                        <x-primary-button :href="$section->button_link"
                            class="group inline-flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            {{ $section->button_text }}
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </x-primary-button>

                        {{-- Secondary Button (Optional) --}}
                        @if ($section->secondary_button_text && $section->secondary_button_link)
                            <a href="{{ $section->secondary_button_link }}"
                                class="group inline-flex items-center justify-center px-6 py-3 text-base font-semibold rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                                {{ $section->secondary_button_text }}
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Image Right --}}
            @if ($hasImage && $imagePosition === 'right')
                <div class="order-1 lg:order-2" data-aos="fade-left">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl group">
                        <img src="{{ asset('storage/' . $section->image) }}"
                            alt="{{ $section->title ?? 'Section Image' }}"
                            class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-700"
                            loading="lazy" decoding="async">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Bottom Image Layout --}}
        @if ($hasImage && $imagePosition === 'bottom')
            <div class="mt-12">
                <div class="rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ asset('storage/' . $section->image) }}"
                        alt="{{ $section->title ?? 'Section Image' }}" class="w-full h-auto max-h-96 object-cover"
                        loading="lazy" decoding="async">
                </div>
            </div>
        @endif
    </div>

    {{-- Decorative Elements --}}
    @if ($isAlternate)
        <div
            class="absolute top-0 right-0 -mt-20 -mr-20 w-72 h-72 bg-blue-100 dark:bg-blue-900/20 rounded-full filter blur-3xl opacity-30 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 -mb-20 -ml-20 w-72 h-72 bg-purple-100 dark:bg-purple-900/20 rounded-full filter blur-3xl opacity-30 pointer-events-none">
        </div>
    @endif
</section>
