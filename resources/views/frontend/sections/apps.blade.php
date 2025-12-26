@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    
    $title = $fields['title'] ?? 'Our Apps';
    $subtitle = $fields['subtitle'] ?? 'Download Center';
    $description = $fields['description'] ?? '';
    $showCategories = ($fields['show_categories'] ?? '1') === '1';
    $showFeaturedOnly = ($fields['show_featured_only'] ?? '0') === '1';
    $appsLimit = (int) ($fields['apps_limit'] ?? 8);
    $buttons = isset($fields['buttons']) ? json_decode($fields['buttons'], true) : [];
    
    // Fetch apps
    $appsQuery = \App\Models\App::with(['category', 'latestVersion'])
        ->where('status', 'active')
        ->orderBy('is_featured', 'desc')
        ->orderBy('download_count', 'desc');
    
    if ($showFeaturedOnly) {
        $appsQuery->where('is_featured', true);
    }
    
    $apps = $appsQuery->limit($appsLimit)->get();
    
    // Fetch categories
    $categories = \App\Models\AppCategory::where('is_active', true)
        ->withCount('apps')
        ->orderBy('order')
        ->get();
    
    $sectionId = 'apps-section-' . uniqid();
@endphp

<section class="relative py-8 lg:py-12 px-6 sm:px-8 lg:px-14 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900 overflow-hidden"
    id="{{ $sectionId }}">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="apps-bg-blur-1 absolute top-20 right-10 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="apps-bg-blur-2 absolute bottom-20 left-10 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative">

        {{-- Section Header --}}
        @if ($title || $subtitle || $description)
            <div class="text-center max-w-3xl mx-auto mb-4">

                @if ($subtitle)
                    <span class="apps-badge opacity-0 inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs sm:text-xs md:text-sm lg:text-sm tracking-wide font-semibold
                        bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                        border border-[#1363C6]/20 dark:border-[#1363C6]/30
                        shadow-sm shadow-[#1363C6]/10">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                        {{ $subtitle }}
                    </span>
                @endif
            </div>

            @if ($description)
                <div class="apps-content max-w-7xl mx-auto mb-4 opacity-0">
                    <div class="text-[16px] sm:text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                        {!! $description !!}
                    </div>
                </div>
            @endif

            <div class="text-center max-w-3xl mx-auto mb-4">
                @if ($title)
                    <h2 class="apps-title opacity-0 text-[24px] sm:text-[24px] md:text-[40px] lg:text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight">
                        {{ $title }}
                    </h2>
                @endif
            </div>
        @endif

        {{-- Category Filter --}}
        @if ($showCategories && $categories->count() > 0)
            <div class="apps-categories opacity-0 flex flex-wrap items-center justify-center gap-3 mb-8" x-data="{ activeCategory: 'all' }">
                <button @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-[#1363C6] text-white shadow-lg shadow-[#1363C6]/30' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 hover:scale-105">
                    All Apps
                </button>
                @foreach ($categories as $category)
                    <button @click="activeCategory = '{{ $category->id }}'"
                        :class="activeCategory === '{{ $category->id }}' ? 'text-white shadow-lg' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        :style="activeCategory === '{{ $category->id }}' ? 'background-color: {{ $category->color }}' : ''"
                        class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 hover:scale-105">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Apps Grid --}}
        @if ($apps->count())
            <div class="apps-grid grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-8" x-data="{ activeCategory: 'all' }">
                @foreach ($apps as $index => $app)
                    <div x-show="activeCategory === 'all' || activeCategory === '{{ $app->app_category_id }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        class="app-card opacity-0 group" data-index="{{ $index }}">
                        <a href="{{ route('frontend.apps.show', $app->slug) }}"
                            class="block bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 transition-all duration-300 hover:shadow-2xl hover:shadow-[#1363C6]/20 p-6 transform hover:-translate-y-2">
                            
                            {{-- App Icon --}}
                            <div class="mb-4">
                                @if ($app->icon)
                                    <img src="{{ asset('storage/' . $app->icon) }}" alt="{{ $app->name }}"
                                        class="w-20 h-20 rounded-2xl object-cover border-2 border-gray-100 dark:border-gray-700 group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 bg-gradient-to-br from-[#1363C6]/10 to-[#0d4a94]/10 group-hover:from-[#1363C6]/20 group-hover:to-[#0d4a94]/20">
                                        <svg class="w-10 h-10 text-[#1363C6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- App Info --}}
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors">
                                {{ $app->name }}
                            </h3>

                            @if ($app->category)
                                <span class="inline-block px-3 py-1 rounded-lg text-xs font-semibold mb-3"
                                    style="background-color: {{ $app->category->color }}20; color: {{ $app->category->color }};">
                                    {{ $app->category->name }}
                                </span>
                            @endif

                            @if ($app->short_description)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2 leading-relaxed">
                                    {{ $app->short_description }}
                                </p>
                            @endif

                            {{-- Stats --}}
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-100 dark:border-gray-700">
                                @if ($app->latestVersion)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        v{{ $app->latestVersion->version_number }}
                                    </span>
                                @endif
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    {{ number_format($app->average_rating, 1) }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    {{ number_format($app->download_count) }}
                                </span>
                            </div>

                            @if ($app->is_featured)
                                <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-yellow-600 dark:text-yellow-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Featured
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Buttons --}}
            @if (count($buttons))
                <div class="apps-view-btn opacity-0 text-center mt-10">
                    @foreach ($buttons as $i => $btn)
                        <a href="{{ $btn['url'] ?? '#' }}"
                            class="group inline-flex items-center gap-3 px-8 py-3.5 
                            bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                            text-white font-semibold rounded-xl 
                            hover:shadow-xl hover:shadow-[#1363C6]/30 
                            transition-all duration-300">
                            <span>{{ $btn['text'] ?? 'View All Apps' }}</span>
                            <svg class="view-arrow w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @endforeach
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="empty-state opacity-0 text-center py-20">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 rounded-2xl mb-6 shadow-lg">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Apps Yet</h3>
                <p class="text-lg text-gray-600 dark:text-gray-400">Check back soon for our apps!</p>
            </div>
        @endif

    </div>
</section>

{{-- GSAP Animation Script --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            const sectionId = '#{{ $sectionId }}';

            // Floating background blurs
            gsap.to(`${sectionId} .apps-bg-blur-1`, {
                y: -30,
                x: 20,
                duration: 7,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            gsap.to(`${sectionId} .apps-bg-blur-2`, {
                y: 30,
                x: -20,
                duration: 9,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            // Badge animation
            gsap.fromTo(`${sectionId} .apps-badge`, {
                opacity: 0,
                y: -30,
                scale: 0.8
            }, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.8,
                ease: 'back.out(1.5)',
                scrollTrigger: {
                    trigger: `${sectionId} .apps-badge`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Title animation
            gsap.fromTo(`${sectionId} .apps-title`, {
                opacity: 0,
                y: 50
            }, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .apps-title`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Content animation
            gsap.fromTo(`${sectionId} .apps-content`, {
                opacity: 0,
                y: 40
            }, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .apps-content`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Categories animation
            gsap.fromTo(`${sectionId} .apps-categories`, {
                opacity: 0,
                y: 30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .apps-categories`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // App cards stagger animation
            gsap.fromTo(`${sectionId} .app-card`, {
                opacity: 0,
                y: 80,
                scale: 0.9
            }, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .apps-grid`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // View All button animation
            gsap.fromTo(`${sectionId} .apps-view-btn`, {
                opacity: 0,
                y: 40,
                scale: 0.9
            }, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.8,
                ease: 'back.out(1.5)',
                scrollTrigger: {
                    trigger: `${sectionId} .apps-view-btn`,
                    start: 'top 90%',
                    toggleActions: 'play none none none'
                }
            });

            // Empty state animation
            gsap.fromTo(`${sectionId} .empty-state`, {
                opacity: 0,
                y: 50
            }, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .empty-state`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // View All button hover effect
            const viewBtn = document.querySelector(`${sectionId} .apps-view-btn a`);
            if (viewBtn) {
                const arrow = viewBtn.querySelector('.view-arrow');

                viewBtn.addEventListener('mouseenter', () => {
                    gsap.to(viewBtn, {
                        scale: 1.05,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                    gsap.to(arrow, {
                        x: 5,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });

                viewBtn.addEventListener('mouseleave', () => {
                    gsap.to(viewBtn, {
                        scale: 1,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                    gsap.to(arrow, {
                        x: 0,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });
            }
        });
    </script>
@endpush

<style>
    .app-card {
        will-change: opacity, transform;
    }
</style>
