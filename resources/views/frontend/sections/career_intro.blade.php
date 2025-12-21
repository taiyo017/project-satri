@props(['section'])

@php
    use Carbon\Carbon;
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();

    $heading = $fields['title'] ?? 'Open Career Opportunities';
    $subtitle = $fields['subtitle'] ?? 'Join Our Team';
    $contents =
        $fields['content'] ??
        '<p>We are a growing company always looking for passionate and talented individuals to join our mission. Explore our open roles below.</p>';

    $jobs = \App\Models\Career::where('is_open', 1)
        ->whereDate('deadline', '>=', Carbon::today())
        ->with('jobCategory')
        ->orderBy('created_at', 'desc')
        ->get();

    $categories = $jobs->pluck('jobCategory.name')->unique()->filter()->values();
@endphp

<section
    class="relative py-8 lg:py-12 px-6 sm:px-10 lg:px-14 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-950 overflow-hidden">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl animate-career-bg-1"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl animate-career-bg-2">
        </div>
    </div>

    <div class="max-w-7xl mx-auto relative">

        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-4">
            @if ($subtitle)
                <span
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs sm:text-xs md:text-sm lg:text-sm tracking-wide font-semibold
                    bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                    border border-[#1363C6]/20 dark:border-[#1363C6]/30
                    shadow-sm shadow-[#1363C6]/10 animate-career-subtitle">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                            clip-rule="evenodd" />
                        <path
                            d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                    </svg>
                    {{ strtoupper($subtitle) }}
                </span>
            @endif
        </div>

        @if ($contents)
            <div class="max-w-7xl mx-auto mb-8 animate-career-content">
                <div class="text-[16px] leading-[26px] text-gray-600 dark:text-gray-400 text-justify">
                    {!! $contents !!}
                </div>
            </div>
        @endif

        <div class="text-center max-w-3xl mx-auto">
            @if ($heading)
                <h2
                    class="text-[24px] sm:text-[24px] md:text-[40px] lg:text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight animate-career-heading">
                    {{ $heading }}
                </h2>
            @endif
        </div>



        <div x-data="{ activeTab: 'All' }">

            {{-- Category Filter Tabs --}}
            @if ($categories->count() > 0)
                <div
                    class="w-full sticky top-0 z-20 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md py-4 mb-10 border-y border-gray-100 dark:border-gray-800 animate-career-tabs">
                    <div class="flex flex-wrap justify-center gap-3">
                        {{-- All Jobs Tab --}}
                        <button @click="activeTab = 'All'"
                            class="px-4 py-2 rounded-lg font-semibold text-[15px] transition-all duration-300 animate-career-tab"
                            data-tab-index="0"
                            :class="activeTab === 'All' ?
                                'bg-[#1363C6] text-white shadow-md' :
                                'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-[#1363C6]/40'">
                            All Jobs
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-bold"
                                :class="activeTab === 'All' ? 'bg-white/20' :
                                    'bg-[#1363C6]/10 text-[#1363C6] dark:text-[#4a8dd8]'">
                                {{ $jobs->count() }}
                            </span>
                        </button>

                        {{-- Dynamic Category Tabs --}}
                        @foreach ($categories as $index => $cat)
                            <button @click="activeTab = '{{ $cat }}'"
                                class="px-4 py-2 rounded-lg font-semibold text-[15px] transition-all duration-300 capitalize animate-career-tab"
                                data-tab-index="{{ $index + 1 }}"
                                :class="activeTab === '{{ $cat }}' ?
                                    'bg-[#1363C6] text-white shadow-md' :
                                    'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-[#1363C6]/40'">
                                {{ $cat }}
                                <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-bold"
                                    :class="activeTab === '{{ $cat }}' ? 'bg-white/20' :
                                        'bg-[#1363C6]/10 text-[#1363C6] dark:text-[#4a8dd8]'">
                                    {{ $jobs->where('jobCategory.name', $cat)->count() }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Job Listings Grid --}}
            <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
                @forelse ($jobs as $index => $job)
                    <div x-show="activeTab === 'All' || activeTab === '{{ $job->jobCategory?->name }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100" class="group animate-career-card"
                        data-job-index="{{ $index }}">

                        {{-- Job Card --}}
                        <div
                            class="relative h-full border border-gray-100 dark:border-gray-800 
                            bg-white dark:bg-gray-900 rounded-xl p-5 
                            hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50
                            hover:shadow-lg hover:shadow-[#1363C6]/5
                            transition-all duration-300 hover:-translate-y-0.5
                            flex flex-col overflow-hidden">

                            {{-- Blue highlight on hover --}}
                            <div
                                class="absolute inset-0 bg-[#1363C6]/5 dark:bg-[#4a8dd8]/5 
                                opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>

                            {{-- Job Type Badge --}}
                            <div class="absolute top-3 right-3 z-10">
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider 
                                    bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]">
                                    {{ $job->jobCategory?->name ?? 'Uncategorized' }}
                                </span>
                            </div>

                            {{-- Job Icon --}}
                            <div
                                class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#1363C6] to-[#0d4a94]
                                flex items-center justify-center mb-3 
                                group-hover:scale-110 transition-transform duration-300 shadow-md relative z-10">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>

                            {{-- Job Title --}}
                            <h3
                                class="text-[18px] font-semibold text-gray-900 dark:text-white mb-2 pr-10 line-clamp-2 
                                group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] 
                                transition-colors relative z-10">
                                {{ $job->title }}
                            </h3>

                            {{-- Job Description --}}
                            <p
                                class="text-[15px] leading-[24px] text-gray-600 dark:text-gray-400 mb-3 line-clamp-2 flex-grow relative z-10">
                                {{ Str::limit(strip_tags($job->description), 80) }}
                            </p>

                            {{-- Job Meta --}}
                            <div class="space-y-2 mb-5 mt-auto relative z-10">
                                {{-- Location --}}
                                <div class="flex items-center gap-2 text-[15px] text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-[#1363C6] dark:text-[#4a8dd8] flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="font-medium">{{ $job->location }}</span>
                                </div>

                                {{-- Deadline --}}
                                @if ($job->deadline)
                                    @php
                                        $isExpiringSoon =
                                            $job->deadline->diffInDays(now()) <= 7 && $job->deadline->isFuture();
                                    @endphp
                                    <div
                                        class="flex items-center gap-2 text-[15px] 
                                        {{ $isExpiringSoon ? 'text-orange-600 dark:text-orange-400' : 'text-gray-700 dark:text-gray-300' }}">
                                        <svg class="w-4 h-4 flex-shrink-0 
                                            {{ $isExpiringSoon ? 'text-orange-500' : 'text-[#1363C6] dark:text-[#4a8dd8]' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-medium">{{ $job->deadline->format('M d, Y') }}</span>
                                        @if ($isExpiringSoon)
                                            <span
                                                class="ml-auto px-1.5 py-0.5 bg-orange-100 dark:bg-orange-900/30 
                                                rounded-full text-xs font-bold">
                                                Urgent
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Apply Button --}}
                            <a href="{{ route('career.show', $job->slug) }}"
                                class="group/btn relative w-full px-4 py-2.5 
                                bg-gradient-to-r from-[#1363C6] to-[#0d4a94]
                                text-white font-semibold text-[15px] rounded-lg shadow-md 
                                hover:shadow-lg hover:shadow-[#1363C6]/30
                                transition-all duration-300 
                                inline-flex items-center justify-center gap-2 z-10">
                                <span>View Details</span>
                                <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>

                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full text-center py-20 bg-white dark:bg-gray-900 rounded-xl 
                        border border-gray-100 dark:border-gray-800 animate-career-empty">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full 
                            bg-gradient-to-br from-[#1363C6] to-[#0d4a94] mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-[20px] font-bold text-gray-900 dark:text-white mb-2">No Open Positions</h3>
                        <p class="text-[16px] text-gray-600 dark:text-gray-400 max-w-sm mx-auto">
                            We don't have any open positions at the moment. Check back soon!
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            // Set initial states
            gsap.set(
                '.animate-career-subtitle, .animate-career-content, .animate-career-heading, .animate-career-tabs, .animate-career-tab, .animate-career-card, .animate-career-empty', {
                    opacity: 0,
                    y: 40
                });

            // Background animations (subtle floating)
            gsap.to('.animate-career-bg-1', {
                y: -20,
                x: -15,
                duration: 8,
                repeat: -1,
                yoyo: true,
                ease: 'power1.inOut'
            });

            gsap.to('.animate-career-bg-2', {
                y: 20,
                x: 15,
                duration: 7,
                repeat: -1,
                yoyo: true,
                ease: 'power1.inOut'
            });

            // Section Subtitle Badge
            gsap.to('.animate-career-subtitle', {
                opacity: 1,
                y: 0,
                duration: 0.7,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.animate-career-subtitle',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                }
            });

            // Section Content
            gsap.to('.animate-career-content', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.animate-career-content',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                }
            });

            // Section Heading
            gsap.to('.animate-career-heading', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.2,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.animate-career-heading',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                }
            });

            // Category Tabs Container
            gsap.to('.animate-career-tabs', {
                opacity: 1,
                y: 0,
                duration: 0.7,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.animate-career-tabs',
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Individual Tab Buttons (stagger)
            document.querySelectorAll('.animate-career-tab').forEach((tab, index) => {
                gsap.to(tab, {
                    opacity: 1,
                    y: 0,
                    duration: 0.5,
                    delay: 0.3 + (index * 0.05),
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: '.animate-career-tabs',
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });
            });

            // Job Cards (stagger animation)
            document.querySelectorAll('.animate-career-card').forEach((card, index) => {
                gsap.to(card, {
                    opacity: 1,
                    y: 0,
                    duration: 0.7,
                    delay: index * 0.08,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });
            });

            // Empty State
            gsap.to('.animate-career-empty', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.animate-career-empty',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                }
            });
        });
    </script>
@endpush
