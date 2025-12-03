@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();

    $title = $fields['title'] ?? 'Page Title';
    $breadcrumbs = isset($fields['breadcrumbs']) ? json_decode($fields['breadcrumbs'], true) : [];

    $image = $fields['background'] ?? null;
    $imageUrl = asset('storage/' . $image);

    $content_image_field = $fields['image'] ?? null;
    $contentImageUrl = asset('storage/' . $content_image_field);

@endphp


<section
    class="relative bg-[#1363C6] dark:bg-gray-900 overflow-hidden min-h-[250px] md:min-h-[300px] lg:min-h-[400px] flex items-center">

    @if ($imageUrl)
        <div class="absolute inset-0 z-0 hero-parallax">
            <img src="{{ $imageUrl }}" class="w-full h-full object-cover object-center  opacity-15"
                alt="{{ $title }} Background">

        </div>
    @endif

    {{-- Glow Decor (Kept for style) --}}
    <div class="absolute inset-0 z-[1] pointer-events-none">
        <div class="absolute top-1/4 right-1/4 w-80 h-80 bg-[#4CAFF9]/30 rounded-full blur-3xl opacity-50 animate-pulse-slow"
            style="animation-delay: 0.5s;"></div>
        <div
            class="absolute bottom-1/4 left-1/4 w-80 h-80 bg-[#1363C6]/30 rounded-full blur-3xl opacity-50 animate-pulse-slow">
        </div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-8">

            <div class="lg:col-span-8 text-center lg:text-left px-2">

                {{-- Title --}}
                <h1
                    class="scroll-reveal text-white text-xl sm:text-2xl md:text-3xl lg:text-4xl font-extrabold drop-shadow-lg mb-4 leading-tight">
                    {{ $title }}
                </h1>

                {{-- Breadcrumbs --}}
                <nav
                    class="scroll-reveal flex items-center justify-center lg:justify-start gap-2 text-base sm:text-lg text-gray-300 mt-4">
                    <a href="{{ url('/') }}"
                        class="font-semibold text-gray-200 hover:text-[#4CAFF9] transition-colors">Home</a>

                    {{-- Dynamic breadcrumbs --}}
                    @foreach ($breadcrumbs as $crumb)
                        <span class="mx-1 text-gray-400">/</span>

                        @if (!empty($crumb['url']))
                            <a href="{{ $crumb['url'] }}" class="text-gray-300 hover:text-[#4CAFF9] transition-colors">
                                {{ $crumb['label'] ?? '' }}
                            </a>
                        @else
                            <span class="font-bold text-white">{{ $crumb['label'] ?? $title }}</span>
                        @endif
                    @endforeach
                </nav>

            </div> {{-- End of Title/Breadcrumbs Column --}}

            {{-- Right Column: Optional Image (Hidden on mobile) --}}
            @if ($contentImageUrl)
                <div class="lg:col-span-4 hidden lg:block scroll-reveal" style="animation-delay: 0.4s;">
                    <img src="{{ $contentImageUrl }}" alt="{{ $title }} Visual"
                        class="w-full max-h-[300px] object-contain object-right mx-auto drop-shadow-2xl rounded-lg" />
                </div>
            @endif

        </div> {{-- End of Grid --}}

    </div>
</section>


{{-- Custom Style for Glow Animation (Retained) --}}
<style>
    @keyframes pulse-slow {

        0%,
        100% {
            opacity: 0.5;
            transform: scale(1);
        }

        50% {
            opacity: 0.7;
            transform: scale(1.1);
        }
    }

    .animate-pulse-slow {
        animation: pulse-slow 6s ease-in-out infinite;
    }
</style>


<script>
    (function() {
        'use strict';

        // Smooth Parallax Effect
        let ticking = false;
        const parallaxBg = document.querySelector('.hero-parallax');

        function updateParallax() {
            if (parallaxBg) {
                const scrolled = window.pageYOffset;
                const parallaxSpeed = 0.3;
                parallaxBg.style.transform = `translateY(${scrolled * parallaxSpeed}px)`;
            }
            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                window.requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }

        window.addEventListener('scroll', requestTick, {
            passive: true
        });

        // Scroll Reveal Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        entry.target.classList.remove('opacity-0', 'translate-y-6');
                    }, index * 150);
                    revealObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Initialize reveal elements
        const revealElements = document.querySelectorAll('.scroll-reveal');
        revealElements.forEach(el => {
            el.classList.add('opacity-0', 'translate-y-6', 'transition-all', 'duration-700', 'ease-out');
            revealObserver.observe(el);
        });

        // Cleanup
        window.addEventListener('beforeunload', () => {
            revealObserver.disconnect();
        });
    })();
</script>

<style>
    .scroll-reveal {
        will-change: opacity, transform;
    }

    .hero-parallax {
        will-change: transform;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 32px !important;
            line-height: 40px !important;
        }
    }
</style>
