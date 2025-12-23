@props(['section', 'testimonials' => null])

@php
    $currentSlug = request()->route()?->parameter('slug') ?? '';
    $fullPage = $currentSlug === 'testimonial';

    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    $title = $fields['heading'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $content = $fields['content'] ?? '';

    // Fetch testimonials based on context
    if ($fullPage) {
        $displayTestimonials = $testimonials ?? \App\Models\Testimonial::where('status', 'active')->paginate(12);
    } else {
        $displayTestimonials = \App\Models\Testimonial::where('status', 'active')->latest()->take(12)->get();
    }

    $totalTestimonialsCount = \App\Models\Testimonial::where('status', 'active')->count();
    $allTestimonialsJson = \App\Models\Testimonial::where('status', 'active')->get()->toJson();

    $sectionId = 'testimonials-section-' . uniqid();
@endphp

<section
    class="relative py-8 lg:py-12 px-6 sm:px-8 lg:px-14 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900 overflow-hidden"
    id="{{ $sectionId }}">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="testimonials-bg-blur-1 absolute top-20 right-10 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl">
        </div>
        <div class="testimonials-bg-blur-2 absolute bottom-20 left-10 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl">
        </div>
    </div>

    <div class="max-w-7xl mx-auto relative">

        {{-- Section Header --}}
        @if ($title || $subtitle || $content)
            <div class="text-center max-w-3xl mx-auto mb-4">

                @if ($subtitle)
                    <span
                        class="testimonials-badge opacity-0 inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs sm:text-xs md:text-sm lg:text-sm tracking-wide font-semibold
                        bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                        border border-[#1363C6]/20 dark:border-[#1363C6]/30
                        shadow-sm shadow-[#1363C6]/10">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" />
                        </svg>
                        {{ $subtitle }}
                    </span>
                @endif
            </div>

            @if ($content)
                <div class="testimonials-content max-w-7xl mx-auto mb-4 opacity-0">
                    <div
                        class="text-[16px] sm:text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                        {!! $content !!}
                    </div>
                </div>
            @endif

            <div class="text-center max-w-3xl mx-auto mb-4">
                @if ($title)
                    <h2
                        class="testimonials-title opacity-0 text-[24px] sm:text-[24px] md:text-[40px] lg:text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight">
                        {{ $title }}
                    </h2>
                @endif
            </div>
        @endif

        {{-- Testimonials Display --}}
        @if ($displayTestimonials->count())

            @if ($fullPage)
                {{-- Grid Layout for Full Testimonials Page --}}
                <div class="testimonials-grid grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($displayTestimonials as $index => $testimonial)
                        <div class="testimonial-card opacity-0 group relative bg-white dark:bg-gray-900 rounded-2xl overflow-hidden 
                            border border-gray-200 dark:border-gray-800 
                            hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 
                            transition-all duration-300 
                            hover:shadow-2xl hover:shadow-[#1363C6]/20 p-6 cursor-pointer
                            transform hover:-translate-y-2"
                            data-index="{{ $index }}" data-testimonial-id="{{ $testimonial->id }}">

                            {{-- Quote Icon --}}
                            <div class="absolute top-4 right-4 opacity-10 dark:opacity-5">
                                <svg class="w-16 h-16 text-[#1363C6]" fill="currentColor" viewBox="0 0 32 32">
                                    <path
                                        d="M10 8c-3.3 0-6 2.7-6 6s2.7 6 6 6c.3 0 .5 0 .8-.1L8 24h4.4l1.6-2.7c1.6-1.1 2.7-3 2.7-5.1 0-3.3-2.7-6-6-6zm12 0c-3.3 0-6 2.7-6 6s2.7 6 6 6c.3 0 .5 0 .8-.1L20 24h4.4l1.6-2.7c1.6-1.1 2.7-3 2.7-5.1 0-3.3-2.7-6-6-6z" />
                                </svg>
                            </div>

                            {{-- Rating Stars --}}
                            <div class="flex items-center gap-1 mb-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $testimonial->rating)
                                        <svg class="star-icon w-5 h-5 text-yellow-400" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg class="star-icon w-5 h-5 text-gray-300 dark:text-gray-700"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>

                            {{-- Testimonial Message --}}
                            <div class="mb-6">
                                <p
                                    class="testimonial-message text-gray-700 dark:text-gray-300 leading-relaxed line-clamp-4">
                                    "{{ $testimonial->message }}"
                                </p>
                            </div>

                            {{-- Customer Info --}}
                            <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                                {{-- Photo --}}
                                <div class="testimonial-avatar flex-shrink-0">
                                    @if ($testimonial->photo)
                                        <img src="{{ asset('storage/' . $testimonial->photo) }}"
                                            alt="{{ $testimonial->name }}"
                                            class="w-14 h-14 rounded-full object-cover border-2 border-[#1363C6]/20 dark:border-[#1363C6]/30"
                                            loading="lazy" decoding="async">
                                    @else
                                        <div
                                            class="w-14 h-14 rounded-full flex items-center justify-center text-white text-xl font-bold bg-gradient-to-br from-[#1363C6] to-[#0d4a94]">
                                            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Name & Position --}}
                                <div class="flex-1 min-w-0">
                                    <h4
                                        class="font-bold text-gray-900 dark:text-white group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors truncate">
                                        {{ $testimonial->name }}
                                    </h4>
                                    @if ($testimonial->position || $testimonial->company)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                            {{ $testimonial->position }}{{ $testimonial->position && $testimonial->company ? ' at ' : '' }}{{ $testimonial->company }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Marquee Animation for Homepage/Other Pages --}}
                <div
                    class="testimonials-marquee-container opacity-0 overflow-hidden relative pt-2 py-2 cursor-grab active:cursor-grabbing">
                    <div class="testimonials-marquee flex gap-6 will-change-transform" data-paused="false">
                        @foreach ($displayTestimonials->concat($displayTestimonials) as $testimonial)
                            <div class="testimonial-card-marquee flex-shrink-0 w-[380px] group relative bg-white dark:bg-gray-900 rounded-2xl overflow-hidden 
                                border border-gray-200 dark:border-gray-800 
                                hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 
                                transition-all duration-300 
                                hover:shadow-2xl hover:shadow-[#1363C6]/20 p-6 cursor-pointer
                                hover:-translate-y-2"
                                data-testimonial-id="{{ $testimonial->id }}">

                                {{-- Quote Icon --}}
                                <div class="absolute top-4 right-4 opacity-10 dark:opacity-5">
                                    <svg class="w-12 h-12 text-[#1363C6]" fill="currentColor" viewBox="0 0 32 32">
                                        <path
                                            d="M10 8c-3.3 0-6 2.7-6 6s2.7 6 6 6c.3 0 .5 0 .8-.1L8 24h4.4l1.6-2.7c1.6-1.1 2.7-3 2.7-5.1 0-3.3-2.7-6-6-6zm12 0c-3.3 0-6 2.7-6 6s2.7 6 6 6c.3 0 .5 0 .8-.1L20 24h4.4l1.6-2.7c1.6-1.1 2.7-3 2.7-5.1 0-3.3-2.7-6-6-6z" />
                                    </svg>
                                </div>

                                {{-- Rating Stars --}}
                                <div class="flex items-center gap-1 mb-4">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $testimonial->rating)
                                            <svg class="star-icon w-4 h-4 text-yellow-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="star-icon w-4 h-4 text-gray-300 dark:text-gray-700"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>

                                {{-- Testimonial Message --}}
                                <div class="mb-6">
                                    <p
                                        class="testimonial-message text-sm text-gray-700 dark:text-gray-300 leading-relaxed line-clamp-4">
                                        "{{ $testimonial->message }}"
                                    </p>
                                </div>

                                {{-- Customer Info --}}
                                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                                    {{-- Photo --}}
                                    <div class="testimonial-avatar flex-shrink-0">
                                        @if ($testimonial->photo)
                                            <img src="{{ asset('storage/' . $testimonial->photo) }}"
                                                alt="{{ $testimonial->name }}"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-[#1363C6]/20 dark:border-[#1363C6]/30"
                                                loading="lazy" decoding="async">
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg font-bold bg-gradient-to-br from-[#1363C6] to-[#0d4a94]">
                                                {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Name & Position --}}
                                    <div class="flex-1 min-w-0">
                                        <h2 class="font-bold text-sm text-gray-900 dark:text-white truncate">
                                            {{ $testimonial->name }}
                                        </h2>
                                        @if ($testimonial->position || $testimonial->company)
                                            <p class="text-xs text-gray-600 dark:text-gray-400 truncate">
                                                {{ $testimonial->position }}{{ $testimonial->position && $testimonial->company ? ' at ' : '' }}{{ $testimonial->company }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- View All Testimonials Button (Homepage Only) --}}
            @if (!$fullPage && $totalTestimonialsCount > 12)
                <div class="testimonials-view-btn opacity-0 text-center mt-10">
                    <a href="{{ route('frontend.page.show', 'testimonials') }}"
                        class="group inline-flex items-center gap-3 px-8 py-3.5 
                        bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                        text-white font-semibold rounded-xl 
                        hover:shadow-xl hover:shadow-[#1363C6]/30 
                        transition-all duration-300">
                        <span>View All Testimonials</span>
                        <svg class="view-arrow w-5 h-5 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            @endif

            {{-- Pagination (Full Page Only) --}}
            @if ($fullPage && method_exists($testimonials, 'links'))
                <div class="mt-12 flex justify-center">
                    <div class="inline-block">
                        {{ $testimonials->links() }}
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
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Testimonials Yet</h3>
                <p class="text-lg text-gray-600 dark:text-gray-400">Check back soon for customer reviews!</p>
            </div>
        @endif

    </div>
</section>

{{-- Testimonial Preview Modal --}}
<x-testimonial-preview :all-testimonials-json="$allTestimonialsJson" :section-id="$sectionId" />

{{-- GSAP Animation Script --}}
@push('scripts')
    <script>
        (function() {
            const testimonials = {!! $allTestimonialsJson !!};
            const isTestimonialsFullPage = {{ $fullPage ? 'true' : 'false' }};

            document.addEventListener('DOMContentLoaded', function() {
                gsap.registerPlugin(ScrollTrigger);

                const sectionId = '#{{ $sectionId }}';

                // Floating background blurs
                gsap.to(`${sectionId} .testimonials-bg-blur-1`, {
                    y: -30,
                    x: 20,
                    duration: 7,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                gsap.to(`${sectionId} .testimonials-bg-blur-2`, {
                    y: 30,
                    x: -20,
                    duration: 9,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                // Badge animation
                gsap.fromTo(`${sectionId} .testimonials-badge`, {
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
                        trigger: `${sectionId} .testimonials-badge`,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });

                // Title animation
                gsap.fromTo(`${sectionId} .testimonials-title`, {
                    opacity: 0,
                    y: 50
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: `${sectionId} .testimonials-title`,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });

                // Content animation
                gsap.fromTo(`${sectionId} .testimonials-content`, {
                    opacity: 0,
                    y: 40
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: `${sectionId} .testimonials-content`,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });

                if (isTestimonialsFullPage) {
                    // Grid animation for full page - staggered fade-in from bottom
                    gsap.fromTo(`${sectionId} .testimonial-card`, {
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
                            trigger: `${sectionId} .testimonials-grid`,
                            start: 'top 80%',
                            toggleActions: 'play none none none'
                        }
                    });
                } else {
                    // Marquee animation for homepage
                    const marqueeContainer = document.querySelector(
                        `${sectionId} .testimonials-marquee-container`);
                    const marquee = document.querySelector(`${sectionId} .testimonials-marquee`);
                    const cards = document.querySelectorAll(`${sectionId} .testimonial-card-marquee`);

                    if (marquee && marqueeContainer) {
                        let isDragging = false;
                        let startX = 0;
                        let currentX = 0;
                        let marqueeAnimation = null;

                        // Show marquee container
                        gsap.fromTo(marqueeContainer, {
                            opacity: 0,
                            y: 50
                        }, {
                            opacity: 1,
                            y: 0,
                            duration: 1,
                            ease: 'power3.out',
                            scrollTrigger: {
                                trigger: marqueeContainer,
                                start: 'top 85%',
                                toggleActions: 'play none none none'
                            }
                        });

                        // Calculate marquee width (half because we duplicated)
                        const marqueeWidth = marquee.scrollWidth / 2;

                        // Start marquee animation
                        function startMarquee() {
                            if (marqueeAnimation) marqueeAnimation.kill();
                            marqueeAnimation = gsap.to(marquee, {
                                x: -marqueeWidth,
                                duration: 50,
                                ease: 'none',
                                repeat: -1,
                                modifiers: {
                                    x: gsap.utils.unitize(x => parseFloat(x) % marqueeWidth)
                                }
                            });
                        }

                        // Stop marquee animation
                        function stopMarquee() {
                            if (marqueeAnimation) {
                                gsap.to(marqueeAnimation, {
                                    timeScale: 0,
                                    duration: 0.5,
                                    ease: 'power2.out'
                                });
                            }
                        }

                        // Resume marquee animation
                        function resumeMarquee() {
                            if (marqueeAnimation) {
                                gsap.to(marqueeAnimation, {
                                    timeScale: 1,
                                    duration: 0.5,
                                    ease: 'power2.in'
                                });
                            }
                        }

                        // Drag start
                        function handleDragStart(e) {
                            isDragging = true;
                            startX = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
                            currentX = gsap.getProperty(marquee, 'x') || 0;
                            stopMarquee();
                            marqueeContainer.style.cursor = 'grabbing';
                        }

                        // Drag move
                        function handleDragMove(e) {
                            if (!isDragging) return;
                            const x = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
                            const diff = x - startX;
                            gsap.set(marquee, {
                                x: currentX + diff
                            });
                        }

                        // Drag end
                        function handleDragEnd(e) {
                            if (!isDragging) return;
                            isDragging = false;
                            marqueeContainer.style.cursor = 'grab';

                            const x = e.type.includes('mouse') ? e.pageX : (e.changedTouches ? e.changedTouches[
                                0].clientX : startX);
                            const diff = x - startX;

                            // Prevent click if dragged
                            if (Math.abs(diff) > 10) {
                                cards.forEach(card => card.style.pointerEvents = 'none');
                                setTimeout(() => {
                                    cards.forEach(card => card.style.pointerEvents = 'auto');
                                }, 100);
                            }

                            // Resume animation after drag
                            setTimeout(() => {
                                resumeMarquee();
                            }, 500);
                        }

                        // Mouse events
                        marqueeContainer.addEventListener('mousedown', handleDragStart);
                        marqueeContainer.addEventListener('mousemove', handleDragMove);
                        marqueeContainer.addEventListener('mouseup', handleDragEnd);
                        marqueeContainer.addEventListener('mouseleave', (e) => {
                            if (isDragging) handleDragEnd(e);
                        });

                        // Touch events
                        marqueeContainer.addEventListener('touchstart', handleDragStart, {
                            passive: true
                        });
                        marqueeContainer.addEventListener('touchmove', handleDragMove, {
                            passive: true
                        });
                        marqueeContainer.addEventListener('touchend', handleDragEnd);

                        // Pause on hover
                        marqueeContainer.addEventListener('mouseenter', () => {
                            if (!isDragging) stopMarquee();
                        });

                        marqueeContainer.addEventListener('mouseleave', () => {
                            if (!isDragging) resumeMarquee();
                        });

                        // Start the animation
                        startMarquee();
                    }
                }

                // View All button animation
                gsap.fromTo(`${sectionId} .testimonials-view-btn`, {
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
                        trigger: `${sectionId} .testimonials-view-btn`,
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

                // Card hover effects - avatar animation only
                document.querySelectorAll(
                        `${sectionId} .testimonial-card, ${sectionId} .testimonial-card-marquee`)
                    .forEach(card => {
                        const avatar = card.querySelector('.testimonial-avatar');

                        card.addEventListener('mouseenter', () => {
                            if (avatar) {
                                gsap.to(avatar, {
                                    scale: 1.15,
                                    rotation: 8,
                                    duration: 0.4,
                                    ease: 'back.out(1.7)'
                                });
                            }
                        });

                        card.addEventListener('mouseleave', () => {
                            if (avatar) {
                                gsap.to(avatar, {
                                    scale: 1,
                                    rotation: 0,
                                    duration: 0.4,
                                    ease: 'power2.out'
                                });
                            }
                        });
                    });

                // View All button hover effect
                const viewBtn = document.querySelector(`${sectionId} .testimonials-view-btn a`);
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
            }); // Close DOMContentLoaded
        })(); // Close IIFE
    </script>
@endpush
