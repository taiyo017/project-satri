@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();

    $heading = $fields['heading'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $content = $fields['content'] ?? '';
    $layout = $fields['layout'] ?? 'grid'; // grid / list

    $features = isset($fields['features']) ? json_decode($fields['features'], true) : [];
@endphp

<section class="py-8 lg:py-12 px-6 sm:px-8 lg:px-12 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto">

        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto">
            @if ($subtitle)
                <p
                    class="text-[20px] leading-[28px] mt-4 mb-4 font-bold tracking-wider uppercase text-[#1363C6] dark:text-[#4a8dd8]">
                    {{ $subtitle }}
                </p>
            @endif

            @if ($heading)
                <h2 class="text-[40px] leading-[48px] mt-8 mb-6 font-extrabold text-gray-900 dark:text-white">
                    {{ $heading }}
                </h2>
            @endif
        </div>
        <div class="px-6 sm:px-10 md:px-16 py-2">
            @if ($content)
                <div class="text-[16px] sm:text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                    {!! $content !!}
                </div>
            @endif
        </div>
        {{-- GRID LAYOUT --}}
        @if ($layout === 'grid')
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 ">
                @foreach ($features as $index => $item)
                    <div
                        class="group relative p-6 rounded-xl bg-white dark:bg-gray-900 
                border border-gray-200 dark:border-gray-800 
                hover:border-[#1363C6]/30 dark:hover:border-[#1363C6]/40 
                shadow-sm hover:shadow-lg hover:shadow-[#1363C6]/5 dark:hover:shadow-[#1363C6]/10 
                hover:-translate-y-0.5 transition-all duration-300">

                        <div class="flex items-center gap-3 mb-3">

                            @if (!empty($item['icon']))
                                <div
                                    class="w-8 h-8 flex items-center justify-center rounded-lg
                            bg-[#1363C6]/10 dark:bg-[#1363C6]/20 
                            text-[#1363C6] dark:text-[#4a8dd8]
                            flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                                    <i class="{{ $item['icon'] }} text-[16px]"></i>
                                </div>
                            @endif

                            @if (!empty($item['title']))
                                <h3 class="text-[16px] font-semibold text-gray-900 dark:text-white">
                                    {{ $item['title'] }}
                                </h3>
                            @endif
                        </div>

                        {{-- DESCRIPTION --}}
                        @if (!empty($item['description']))
                            <p class="text-[14px] leading-[22px] text-gray-600 dark:text-gray-400 mt-1">
                                {{ $item['description'] }}
                            </p>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif


        {{-- LIST LAYOUT --}}
        @if ($layout === 'list')
            <div class="space-y-4 max-w-4xl mx-auto">
                @foreach ($features as $index => $item)
                    <div
                        class="group relative flex gap-5 p-5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 hover:border-[#1363C6]/30 dark:hover:border-[#1363C6]/40 shadow-sm hover:shadow-lg hover:shadow-[#1363C6]/5 dark:hover:shadow-[#1363C6]/10 hover:-translate-y-0.5 transition-all duration-300">

                        {{-- Icon --}}
                        @if (!empty($item['icon']))
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center bg-[#1363C6]/10 dark:bg-[#1363C6]/20 text-[#1363C6] dark:text-[#4a8dd8] group-hover:scale-105 transition-transform duration-300">
                                <i class="{{ $item['icon'] }} text-xl"></i>
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            {{-- Title --}}
                            @if (!empty($item['title']))
                                <h3
                                    class="text-[18px] leading-[24px] mt-2 mb-2 font-bold text-gray-900 dark:text-white">
                                    {{ $item['title'] }}
                                </h3>
                            @endif

                            {{-- Description --}}
                            @if (!empty($item['description']))
                                <p class="text-[15px] leading-[24px] mt-0 mb-0 text-gray-600 dark:text-gray-400">
                                    {{ $item['description'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>
