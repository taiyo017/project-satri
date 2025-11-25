@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    $title = $fields['title'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $content = $fields['content'] ?? '';
    $image = $fields['image'] ?? null;

    $buttons = isset($fields['buttons']) ? json_decode($fields['buttons'], true) : [];
@endphp

<section class="py-16 lg:py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto">
        <div
            class="grid {{ $image ? 'lg:grid-cols-2' : 'grid-cols-1' }} gap-12 lg:gap-16 items-center {{ !$image ? 'max-w-4xl mx-auto text-center' : '' }}">

            {{-- Content Section --}}
            <div class="{{ !$image ? 'text-center' : 'text-left' }}">

                @if ($subtitle)
                    <p
                        class="text-[20px] leading-[28px] mt-4 mb-4 font-bold tracking-wider uppercase text-[#1363C6] dark:text-[#4a8dd8]">
                        {{ $subtitle }}
                    </p>
                @endif

                @if ($title)
                    <h2 class="text-[40px] leading-[48px] mt-8 mb-6 font-extrabold text-gray-900 dark:text-white">
                        {{ $title }}
                    </h2>
                @endif

                @if ($content)
                    <div
                        class="text-[16px] leading-[26px] mt-0 mb-4 text-gray-600 dark:text-gray-400 {{ !$image ? 'max-w-3xl mx-auto' : '' }}">
                        {!! $content !!}
                    </div>
                @endif

                @if (!empty($buttons))
                    <div class="flex flex-wrap gap-4 mt-8 {{ !$image ? 'justify-center' : 'justify-start' }}">
                        @foreach ($buttons as $index => $btn)
                            @if ($index === 0)
                                {{-- Primary Button --}}
                                <a href="{{ $btn['url'] ?? '#' }}"
                                    class="inline-flex items-center px-5 py-2.5 text-[14px] leading-[20px] font-semibold text-white bg-[#1363C6] rounded-full shadow-md shadow-[#1363C6]/25 hover:bg-[#0e54ad] hover:-translate-y-0.5 transition-all duration-200">
                                    {{ $btn['text'] ?? 'Learn More' }}
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                {{-- Secondary Button --}}
                                <a href="{{ $btn['url'] ?? '#' }}"
                                    class="inline-flex items-center px-5 py-2.5 text-[14px] leading-[20px] font-semibold text-gray-700 dark:text-gray-300 bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-full hover:border-[#1363C6] hover:text-[#1363C6] dark:hover:border-[#4a8dd8] dark:hover:text-[#4a8dd8] hover:-translate-y-0.5 transition-all duration-200">
                                    {{ $btn['text'] ?? 'Learn More' }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Image Section --}}
            @if ($image)
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden shadow-lg shadow-gray-200 dark:shadow-gray-900/50">
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $title }}"
                            class="w-full h-auto object-cover">
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>
