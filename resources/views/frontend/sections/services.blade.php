@props(['section', 'services' => null])

@php
    $currentSlug = request()->route()?->parameter('slug') ?? '';
    $fullPage = $currentSlug === 'service';

    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    $title = $fields['heading'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $content = $fields['content'] ?? '';

    if ($fullPage) {
        // On services page, use paginated services from controller
        $displayServices = $services ?? \App\Models\Service::where('status', 'published')->paginate(12);
    } else {
        // On other pages, show featured services in marquee
        $displayServices = \App\Models\Service::where('status', 'published')->latest()->take(12)->get();
    }

    $totalServicesCount = \App\Models\Service::where('status', 'published')->count();
    $allServicesJson = \App\Models\Service::where('status', 'published')->get()->toJson();

    $sectionId = 'services-section-' . uniqid();
@endphp

<section
    class="relative py-8 lg:py-12 px-6 sm:px-8 lg:px-14 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900 overflow-hidden"
    id="{{ $sectionId }}">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="services-bg-blur-1 absolute top-20 right-10 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="services-bg-blur-2 absolute bottom-20 left-10 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative">

        {{-- Section Header --}}
        @if ($title || $subtitle || $content)
            <div class="text-center max-w-3xl mx-auto mb-4">

                @if ($subtitle)
                    <span
                        class="services-badge opacity-0 inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs sm:text-xs md:text-sm lg:text-sm tracking-wide font-semibold
                        bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                        border border-[#1363C6]/20 dark:border-[#1363C6]/30
                        shadow-sm shadow-[#1363C6]/10">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $subtitle }}
                    </span>
                @endif
            </div>

            @if ($content)
                <div class="services-content max-w-7xl mx-auto mb-4 opacity-0">
                    <div
                        class="text-[16px] sm:text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                        {!! $content !!}
                    </div>
                </div>
            @endif

            <div class="text-center max-w-3xl mx-auto mb-4">
                @if ($title)
                    <h2
                        class="services-title opacity-0 text-[24px] sm:text-[24px] md:text-[40px] lg:text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight">
                        {{ $title }}
                    </h2>
                @endif
            </div>
        @endif

        {{-- Services Display --}}
        @if ($displayServices->count())

            @if ($fullPage)
                {{-- Grid Layout for Full Services Page --}}
                <div class="services-grid grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mb-1">
                    @foreach ($displayServices as $index => $service)
                        <div class="service-card opacity-0 group relative bg-white dark:bg-gray-900 rounded-2xl overflow-hidden 
                            border border-gray-200 dark:border-gray-800 
                            hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 
                            transition-all duration-300 
                            hover:shadow-2xl hover:shadow-[#1363C6]/20 p-6 cursor-pointer
                            transform hover:-translate-y-2"
                            data-index="{{ $index }}" data-service-id="{{ $service->id }}">

                            {{-- Icon/Image --}}
                            <div class="mb-6">
                                @if ($service->image)
                                    <div class="service-image w-full h-48 rounded-xl overflow-hidden">
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                            loading="lazy" decoding="async">
                                    </div>
                                @elseif ($service->icon)
                                    <div
                                        class="w-16 h-16 rounded-xl flex items-center justify-center bg-gradient-to-br from-[#1363C6]/10 to-[#0d4a94]/10 group-hover:from-[#1363C6]/20 group-hover:to-[#0d4a94]/20 transition-all duration-300">
                                        <i class="{{ $service->icon }} text-3xl text-[#1363C6]"></i>
                                    </div>
                                @else
                                    <div
                                        class="w-16 h-16 rounded-xl flex items-center justify-center bg-gradient-to-br from-[#1363C6]/10 to-[#0d4a94]/10 group-hover:from-[#1363C6]/20 group-hover:to-[#0d4a94]/20 transition-all duration-300">
                                        <svg class="w-8 h-8 text-[#1363C6]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Service Title --}}
                            <h3
                                class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors">
                                {{ $service->title }}
                            </h3>

                            {{-- Short Description --}}
                            @if ($service->short_description)
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed line-clamp-3 mb-4">
                                    {{ $service->short_description }}
                                </p>
                            @endif

                            {{-- Learn More Link --}}
                            <div
                                class="flex items-center gap-2 text-[#1363C6] dark:text-[#4a8dd8] font-semibold text-sm group-hover:gap-3 transition-all">
                                <span>Learn More</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>

                            {{-- Featured Badge --}}
                            @if ($service->is_featured)
                                <div class="absolute top-4 right-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-bold rounded-full">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Featured
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Slider for Homepage/Other Pages --}}
                <div class="services-slider-wrapper opacity-0 relative max-w-[1100px] pt-2">
                    {{-- Slider Container - overflow visible to allow hover effect --}}
                    <div
                        class="services-slider-container overflow-hidden relative cursor-grab active:cursor-grabbing py-2">
                        <div class="services-slider flex gap-6 will-change-transform">
                            @foreach ($displayServices as $service)
                                <div class="service-slide flex-shrink-0 w-[340px] group relative bg-white dark:bg-gray-900 rounded-2xl overflow-hidden 
                                    border border-gray-200 dark:border-gray-800 
                                    hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 
                                    transition-all duration-300 
                                    hover:shadow-2xl hover:shadow-[#1363C6]/20 p-6 cursor-pointer
                                    hover:-translate-y-2"
                                    data-service-id="{{ $service->id }}">

                                    {{-- Icon/Image --}}
                                    <div class="mb-5">
                                        @if ($service->image)
                                            <div class="service-image w-full h-40 rounded-xl overflow-hidden">
                                                <img src="{{ asset('storage/' . $service->image) }}"
                                                    alt="{{ $service->title }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                    loading="lazy" decoding="async">
                                            </div>
                                        @elseif ($service->icon)
                                            <div
                                                class="w-14 h-14 rounded-xl flex items-center justify-center bg-gradient-to-br from-[#1363C6]/10 to-[#0d4a94]/10 group-hover:from-[#1363C6]/20 group-hover:to-[#0d4a94]/20 transition-all duration-300">
                                                <i class="{{ $service->icon }} text-2xl text-[#1363C6]"></i>
                                            </div>
                                        @else
                                            <div
                                                class="w-14 h-14 rounded-xl flex items-center justify-center bg-gradient-to-br from-[#1363C6]/10 to-[#0d4a94]/10 group-hover:from-[#1363C6]/20 group-hover:to-[#0d4a94]/20 transition-all duration-300">
                                                <svg class="w-7 h-7 text-[#1363C6]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Service Title --}}
                                    <h3
                                        class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors">
                                        {{ $service->title }}
                                    </h3>

                                    {{-- Short Description --}}
                                    @if ($service->short_description)
                                        <p
                                            class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed line-clamp-3 mb-3">
                                            {{ $service->short_description }}
                                        </p>
                                    @endif

                                    {{-- Learn More Link --}}
                                    <div
                                        class="flex items-center gap-2 text-[#1363C6] dark:text-[#4a8dd8] font-semibold text-sm group-hover:gap-3 transition-all">
                                        <span>Learn More</span>
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>

                                    {{-- Featured Badge --}}
                                    @if ($service->is_featured)
                                        <div class="absolute top-4 right-4">
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-bold rounded-full">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                Featured
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Rectangle Indicators (Progress Bars) - Only show if more than 3 services --}}
                    @if ($displayServices->count() > 3)
                        <div class="services-indicators flex justify-center gap-2 mt-8">
                            @php
                                $totalPages = ceil($displayServices->count() / 3);
                            @endphp
                            @for ($i = 0; $i < $totalPages; $i++)
                                <button
                                    class="services-indicator h-1.5 rounded-full bg-gray-300 dark:bg-gray-700 hover:bg-[#1363C6]/50 dark:hover:bg-[#4a8dd8]/50 transition-all duration-300 opacity-0 cursor-pointer"
                                    data-index="{{ $i }}" aria-label="Go to slide {{ $i + 1 }}"
                                    style="width: 32px;">
                                </button>
                            @endfor
                        </div>
                    @endif
                </div>
            @endif

            {{-- View All Services Button (Homepage Only) --}}
            @if (!$fullPage && $totalServicesCount > 12)
                <div class="services-view-btn opacity-0 text-center mt-10">
                    <a href="{{ route('frontend.page.show', 'services') }}"
                        class="group inline-flex items-center gap-3 px-8 py-3.5 
                        bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                        text-white font-semibold rounded-xl 
                        hover:shadow-xl hover:shadow-[#1363C6]/30 
                        transition-all duration-300">
                        <span>View All Services</span>
                        <svg class="view-arrow w-5 h-5 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            @endif

            {{-- Pagination (Full Page Only) --}}
            @if ($fullPage && method_exists($services, 'links'))
                <div class="mt-12 flex justify-center">
                    <div class="inline-block">
                        {{ $services->links() }}
                    </div>
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="empty-state opacity-0 text-center py-20">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 rounded-2xl mb-6 shadow-lg">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Services Yet</h3>
                <p class="text-lg text-gray-600 dark:text-gray-400">Check back soon for our services!</p>
            </div>
        @endif

    </div>
</section>

{{-- Service Preview Modal --}}
<x-service-preview :all-services-json="$allServicesJson" :section-id="$sectionId" />

{{-- GSAP Animation Script --}}
@push('scripts')
    <script>
        (function() {
            const services = {!! $allServicesJson !!};
            const isServicesFullPage = {{ $fullPage ? 'true' : 'false' }};

            document.addEventListener('DOMContentLoaded', function() {
                gsap.registerPlugin(ScrollTrigger);

                const sectionId = '#{{ $sectionId }}';

                // Floating background blurs
                gsap.to(`${sectionId} .services-bg-blur-1`, {
                    y: -30,
                    x: 20,
                    duration: 7,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                gsap.to(`${sectionId} .services-bg-blur-2`, {
                    y: 30,
                    x: -20,
                    duration: 9,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                // Badge animation
                gsap.fromTo(`${sectionId} .services-badge`, {
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
                        trigger: `${sectionId} .services-badge`,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });

                // Title animation
                gsap.fromTo(`${sectionId} .services-title`, {
                    opacity: 0,
                    y: 50
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: `${sectionId} .services-title`,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });

                // Content animation
                gsap.fromTo(`${sectionId} .services-content`, {
                    opacity: 0,
                    y: 40
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: `${sectionId} .services-content`,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });

                if (isServicesFullPage) {
                    // Grid animation for full page - staggered fade-in from bottom
                    gsap.fromTo(`${sectionId} .service-card`, {
                        opacity: 0,
                        y: 80,
                        scale: 0.9
                    }, {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.7,
                        stagger: {
                            amount: 0.6,
                            from: "start",
                            ease: "power2.out"
                        },
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: `${sectionId} .services-grid`,
                            start: 'top 80%',
                            toggleActions: 'play none none none'
                        }
                    });
                } else {
                    // Slider for homepage
                    const sliderWrapper = document.querySelector(`${sectionId} .services-slider-wrapper`);
                    const sliderContainer = document.querySelector(`${sectionId} .services-slider-container`);
                    const slider = document.querySelector(`${sectionId} .services-slider`);
                    const slides = document.querySelectorAll(`${sectionId} .service-slide`);
                    const indicators = document.querySelectorAll(`${sectionId} .services-indicator`);

                    if (slider && sliderWrapper && slides.length > 0) {
                        let currentIndex = 0;
                        let autoplayInterval = null;
                        const slidesPerView = 3;
                        let isDragging = false;
                        let startX = 0;
                        let currentTranslate = 0;
                        let prevTranslate = 0;
                        let dragStartTime = 0;

                        // Show slider wrapper
                        gsap.fromTo(sliderWrapper, {
                            opacity: 0,
                            y: 50
                        }, {
                            opacity: 1,
                            y: 0,
                            duration: 1,
                            ease: 'power3.out',
                            scrollTrigger: {
                                trigger: sliderWrapper,
                                start: 'top 85%',
                                toggleActions: 'play none none none'
                            }
                        });

                        // Animate indicators
                        gsap.to(indicators, {
                            opacity: 1,
                            duration: 0.5,
                            stagger: 0.05,
                            delay: 0.7,
                            ease: 'power2.out'
                        });

                        // Update active indicator
                        function updateIndicators() {
                            const totalPages = Math.ceil(slides.length / slidesPerView);

                            indicators.forEach((indicator, index) => {
                                if (index === currentIndex) {
                                    indicator.style.width = '48px';
                                    indicator.style.backgroundColor = '#1363C6';
                                } else {
                                    indicator.style.width = '32px';
                                    indicator.style.backgroundColor = '';
                                }
                            });
                        }

                        // Go to specific page (each page shows 3 cards)
                        function goToSlide(pageIndex) {
                            const totalPages = Math.ceil(slides.length / slidesPerView);
                            currentIndex = Math.max(0, Math.min(pageIndex, totalPages - 1));

                            // Calculate offset dynamically based on actual card width
                            const slideWidth = slides[0].offsetWidth;
                            const gap = parseFloat(getComputedStyle(slider).gap) || 24;
                            const offset = -(currentIndex * slidesPerView * (slideWidth + gap));

                            gsap.to(slider, {
                                x: offset,
                                duration: 0.6,
                                ease: 'power2.out'
                            });

                            prevTranslate = offset;
                            updateIndicators();
                        }

                        // Next slide - move by 3 cards
                        function nextSlide() {
                            const totalPages = Math.ceil(slides.length / slidesPerView);
                            const maxPage = totalPages - 1;

                            if (currentIndex < maxPage) {
                                currentIndex++;
                            } else {
                                currentIndex = 0;
                            }
                            goToSlide(currentIndex);
                        }

                        // Previous slide - move by 3 cards
                        function prevSlide() {
                            const totalPages = Math.ceil(slides.length / slidesPerView);
                            const maxPage = totalPages - 1;

                            if (currentIndex > 0) {
                                currentIndex--;
                            } else {
                                currentIndex = maxPage;
                            }
                            goToSlide(currentIndex);

                        }

                        // Start autoplay
                        function startAutoplay() {
                            stopAutoplay();
                            autoplayInterval = setInterval(() => {
                                nextSlide();
                            }, 4000);
                        }

                        // Stop autoplay
                        function stopAutoplay() {
                            if (autoplayInterval) {
                                clearInterval(autoplayInterval);
                                autoplayInterval = null;
                            }
                        }

                        // Drag start
                        function handleDragStart(e) {
                            isDragging = true;
                            dragStartTime = Date.now();
                            startX = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
                            currentTranslate = gsap.getProperty(slider, 'x') || 0;
                            stopAutoplay();
                            sliderContainer.style.cursor = 'grabbing';
                        }

                        // Drag move
                        function handleDragMove(e) {
                            if (!isDragging) return;

                            const currentX = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
                            const diff = currentX - startX;

                            gsap.set(slider, {
                                x: currentTranslate + diff
                            });
                        }

                        // Drag end
                        function handleDragEnd(e) {
                            if (!isDragging) return;

                            isDragging = false;
                            sliderContainer.style.cursor = 'grab';

                            const currentX = e.type.includes('mouse') ? e.pageX : (e.changedTouches ? e
                                .changedTouches[0].clientX : startX);
                            const diff = currentX - startX;
                            const dragDuration = Date.now() - dragStartTime;

                            // Prevent click if dragged
                            if (Math.abs(diff) > 10 || dragDuration > 200) {
                                slides.forEach(slide => slide.style.pointerEvents = 'none');
                                setTimeout(() => {
                                    slides.forEach(slide => slide.style.pointerEvents = 'auto');
                                }, 100);
                            }

                            // Determine slide change
                            if (Math.abs(diff) > 50) {
                                if (diff > 0) {
                                    prevSlide();
                                } else {
                                    nextSlide();
                                }
                            } else {
                                goToSlide(currentIndex);
                            }

                            // Resume autoplay after 5 seconds
                            setTimeout(() => {
                                startAutoplay();
                            }, 5000);
                        }

                        // Mouse events
                        sliderContainer.addEventListener('mousedown', handleDragStart);
                        sliderContainer.addEventListener('mousemove', handleDragMove);
                        sliderContainer.addEventListener('mouseup', handleDragEnd);
                        sliderContainer.addEventListener('mouseleave', (e) => {
                            if (isDragging) handleDragEnd(e);
                        });

                        // Touch events
                        sliderContainer.addEventListener('touchstart', handleDragStart, {
                            passive: true
                        });
                        sliderContainer.addEventListener('touchmove', handleDragMove, {
                            passive: true
                        });
                        sliderContainer.addEventListener('touchend', handleDragEnd);

                        // Indicator clicks
                        indicators.forEach((indicator, index) => {
                            indicator.addEventListener('click', () => {
                                goToSlide(index);
                                stopAutoplay();
                                setTimeout(() => {
                                    startAutoplay();
                                }, 5000);
                            });
                        });

                        // Pause on hover
                        sliderWrapper.addEventListener('mouseenter', () => {
                            stopAutoplay();
                        });
                        sliderWrapper.addEventListener('mouseleave', () => {
                            startAutoplay();
                        });

                        updateIndicators();
                        goToSlide(0);

                        // Start autoplay after delay
                        setTimeout(() => {
                            startAutoplay();
                        }, 1000);
                    } else {}
                }

                gsap.fromTo(`${sectionId} .services-view-btn`, {
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
                        trigger: `${sectionId} .services-view-btn`,
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

                // Card hover effects - image/icon animation
                document.querySelectorAll(`${sectionId} .service-card, ${sectionId} .service-slide`)
                    .forEach(card => {
                        const image = card.querySelector('.service-image img');
                        const icon = card.querySelector('i, svg');

                        card.addEventListener('mouseenter', () => {
                            if (image) {
                                gsap.to(image, {
                                    scale: 1.15,
                                    rotation: 3,
                                    duration: 0.4,
                                    ease: 'back.out(1.7)'
                                });
                            } else if (icon) {
                                gsap.to(icon, {
                                    scale: 1.2,
                                    rotation: 8,
                                    duration: 0.4,
                                    ease: 'back.out(1.7)'
                                });
                            }
                        });

                        card.addEventListener('mouseleave', () => {
                            if (image) {
                                gsap.to(image, {
                                    scale: 1,
                                    rotation: 0,
                                    duration: 0.4,
                                    ease: 'power2.out'
                                });
                            } else if (icon) {
                                gsap.to(icon, {
                                    scale: 1,
                                    rotation: 0,
                                    duration: 0.4,
                                    ease: 'power2.out'
                                });
                            }
                        });
                    });

                // View All button hover effect
                const viewBtn = document.querySelector(`${sectionId} .services-view-btn a`);
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
        })();
    </script>
@endpush
