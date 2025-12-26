@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    $title = $fields['title'] ?? 'Find Us';
    $subtitle = $fields['subtitle'] ?? 'Visit Our Location';
    $description = $fields['description'] ?? '';
    $mapIframe = $fields['map_iframe'] ?? '';
    $address = $fields['address'] ?? '';
    $phone = $fields['phone'] ?? '';
    $email = $fields['email'] ?? '';
    $workingHours = $fields['working_hours'] ?? '';
    $mapHeight = $fields['map_height'] ?? '400';
    $showContactInfo = isset($fields['show_contact_info'])
        ? filter_var($fields['show_contact_info'], FILTER_VALIDATE_BOOLEAN)
        : true;
    $layout = $section->layout ?? 'map_with_info';
    $sectionId = 'map-section-' . uniqid();
@endphp

@if ($layout === 'map_default')
    <section class="py-8 lg:py-12 px-6 sm:px-8 lg:px-12 bg-white dark:bg-gray-950" id="{{ $sectionId }}">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-8">
                @if ($subtitle)
                    <p
                        class="text-xs sm:text-xs md:text-[20px] lg:text-[20px] leading-[28px] mt-4 mb-4 font-bold tracking-wider uppercase text-[#1363C6] dark:text-[#4a8dd8]">
                        {{ $subtitle }}
                    </p>
                @endif
                @if ($title)
                    <h2
                        class="text-[24px] sm:text-[24px] md:text-[40px] lg:text-[40px] leading-[48px] mt-6 mb-6 font-extrabold text-gray-900 dark:text-white">
                        {{ $title }}</h2>
                @endif
                @if ($description)
                    <div class="text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                        {!! $description !!}</div>
                @endif
            </div>
            @if ($mapIframe)
                <div class="relative rounded-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-800"
                    style="height: {{ $mapHeight }}px;">
                    {!! $mapIframe !!}
                </div>
            @endif
        </div>
    </section>
@elseif($layout === 'map_with_info')
    <section
        class="py-8 lg:py-12 px-6 sm:px-8 lg:px-12 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900"
        id="{{ $sectionId }}">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-8">
                @if ($subtitle)
                    <p
                        class="text-xs sm:text-xs md:text-[20px] lg:text-[20px] leading-[28px] mt-4 mb-4 font-bold tracking-wider uppercase text-[#1363C6] dark:text-[#4a8dd8]">
                        {{ $subtitle }}
                    </p>
                @endif
                @if ($title)
                    <h2
                        class="text-[24px] sm:text-[24px] md:text-[40px] lg:text-[40px] leading-[48px] mt-6 mb-6 font-extrabold text-gray-900 dark:text-white">
                        {{ $title }}</h2>
                @endif
                @if ($description)
                    <div class="text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                        {!! $description !!}</div>
                @endif
            </div>
            <div class="grid lg:grid-cols-3 gap-6">
                @if ($showContactInfo && ($address || $phone || $email || $workingHours))
                    <div class="lg:col-span-1">
                        <div
                            class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-800 space-y-6 sticky top-8">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                            @if ($address)
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-[#1363C6]/10 dark:bg-[#1363C6]/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-[#1363C6] dark:text-[#4a8dd8]" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Address
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                            {{ $address }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($phone)
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-[#1363C6]/10 dark:bg-[#1363C6]/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-[#1363C6] dark:text-[#4a8dd8]" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Phone</h4>
                                        <a href="tel:{{ $phone }}"
                                            class="text-sm text-[#1363C6] dark:text-[#4a8dd8] hover:underline">{{ $phone }}</a>
                                    </div>
                                </div>
                            @endif
                            @if ($email)
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-[#1363C6]/10 dark:bg-[#1363C6]/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-[#1363C6] dark:text-[#4a8dd8]" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Email</h4>
                                        <a href="mailto:{{ $email }}"
                                            class="text-sm text-[#1363C6] dark:text-[#4a8dd8] hover:underline">{{ $email }}</a>
                                    </div>
                                </div>
                            @endif
                            @if ($workingHours)
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-[#1363C6]/10 dark:bg-[#1363C6]/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-[#1363C6] dark:text-[#4a8dd8]" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Working
                                            Hours</h4>
                                        <p
                                            class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed whitespace-pre-line">
                                            {{ $workingHours }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                <div
                    class="{{ $showContactInfo && ($address || $phone || $email || $workingHours) ? 'lg:col-span-2' : 'lg:col-span-3' }}">
                    @if ($mapIframe)
                        <div class="relative rounded-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-800"
                            style="height: {{ $mapHeight }}px;">
                            {!! $mapIframe !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif

<style>
    #{{ $sectionId }} iframe {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
    }
</style>
