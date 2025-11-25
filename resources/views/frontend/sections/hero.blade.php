@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();

    $title = $fields['title'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $content = $fields['content'] ?? '';
    $buttons = isset($fields['buttons']) ? json_decode($fields['buttons'], true) : [];
    $image = $fields['background'] ?? ($fields['image'] ?? null);
    $imageUrl = asset('storage/' . $image);
    $textAlign = $fields['text_align'] ?? 'center';
@endphp

<section
    class="relative bg-gradient-to-br from-[#1363C6] via-[#115CB8] to-[#0D4A8F] overflow-hidden flex items-center justify-center min-h-[550px] md:min-h-[650px] lg:min-h-[750px] py-20 md:py-24 lg:py-28"
    aria-label="{{ $title ?: 'Hero Section' }}">

    {{-- Background Image with Parallax --}}
    <div class="absolute inset-0 z-0 hero-parallax">
        <img src="{{ $imageUrl }}" alt="{{ $title }}" loading="eager"
            class="w-full h-full object-cover opacity-15">

        {{-- Enhanced Overlay with Primary Color Blend --}}
        <div class="absolute inset-0 bg-gradient-to-b from-[#1363C6]/40 via-[#115CB8]/30 to-[#0D4A8F]/50"></div>
    </div>

    {{-- Animated Background Bubbles --}}
    <div class="absolute inset-0 z-[1] pointer-events-none opacity-30">
        <x-hero-bubbles />
    </div>

    {{-- Enhanced Grid Pattern with Primary Color --}}
    <div class="absolute inset-0 z-[2] opacity-[0.04]"
        style="background-image: linear-gradient(rgba(255,255,255,.15) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.15) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    {{-- Gradient Orbs for Depth --}}
    <div class="absolute top-20 left-10 w-96 h-96 bg-[#4CAFF9] rounded-full opacity-10 blur-3xl z-[1]"></div>
    <div class="absolute bottom-20 right-10 w-80 h-80 bg-[#4CAFF9] rounded-full opacity-10 blur-3xl z-[1]"></div>

    {{-- Content Container --}}
    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 sm:px-10 md:px-16 lg:px-20">
        <div class="text-{{ $textAlign }} max-w-4xl {{ $textAlign === 'center' ? 'mx-auto' : '' }}">

            {{-- Subtitle Badge with Primary Color Accent --}}
            @if ($subtitle)
                <div class="scroll-reveal inline-block" style="margin-bottom: 24px;">
                    <div
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/15 backdrop-blur-md shadow-lg shadow-[#1363C6]/20">
                        <span class="text-white font-semibold uppercase tracking-wider"
                            style="font-size: 14px; line-height: 20px;">
                            {{ $subtitle }}
                        </span>
                    </div>
                </div>
            @endif

            {{-- Main Title with Proper Typography --}}
            @if ($title)
                <h1 class="scroll-reveal font-bold text-white"
                    style="font-size: 40px; line-height: 48px; margin-top: 0; margin-bottom: 24px; letter-spacing: -0.02em;">
                    <span class="block md:inline">{{ $title }}</span>
                </h1>
            @endif

            {{-- Description Content with Body Text Specs --}}
            @if ($content)
                <div class="scroll-reveal max-w-3xl {{ $textAlign === 'center' ? 'mx-auto' : '' }}"
                    style="margin-bottom: 32px;">
                    <div class="text-white/90 leading-relaxed" style="font-size: 18px; line-height: 28px;">
                        {!! $content !!}
                    </div>
                </div>
            @endif

            {{-- Call-to-Action Buttons with Proper Sizing --}}
            @if (count($buttons))
                <div class="scroll-reveal flex flex-col sm:flex-row items-center {{ $textAlign === 'center' ? 'justify-center' : 'justify-start' }} gap-4"
                    style="margin-bottom: 48px;">
                    @foreach ($buttons as $i => $btn)
                        @if ($i === 0)
                            {{-- Primary Button with Enhanced Shadow --}}
                            <a href="{{ $btn['url'] ?? '#' }}"
                                class="group inline-flex items-center justify-center gap-2 bg-white text-[#1363C6] font-bold rounded-full transition-all duration-300 hover:shadow-xl hover:shadow-white/30 hover:scale-105 active:scale-95 w-full sm:w-auto"
                                style="padding: 12px 24px; font-size: 14px; line-height: 20px; box-shadow: 0 4px 14px rgba(255, 255, 255, 0.25), 0 2px 8px rgba(255, 255, 255, 0.15);">
                                <span>{{ $btn['text'] ?? 'Get Started' }}</span>
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        @else
                            {{-- Secondary Button with Primary Border Glow --}}
                            <a href="{{ $btn['url'] ?? '#' }}"
                                class="group inline-flex items-center justify-center gap-2 bg-transparent text-white font-bold rounded-full border-2 border-white/40 hover:bg-white/10 hover:border-white/60 hover:shadow-lg hover:shadow-white/20 transition-all duration-300 hover:scale-105 active:scale-95 w-full sm:w-auto"
                                style="padding: 12px 24px; font-size: 14px; line-height: 20px;">
                                <span>{{ $btn['text'] ?? 'Learn More' }}</span>
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif

            {{-- Trust Indicators / Stats with Primary Color Accents --}}
            @if (isset($fields['show_stats']) && $fields['show_stats'])
                <div class="scroll-reveal border-t border-white/20" style="padding-top: 48px; margin-top: 32px;">
                    <div class="grid grid-cols-3 gap-8 md:gap-12">
                        <div class="text-center">
                            <div class="font-bold text-white mb-2" style="font-size: 44px; line-height: 52px;">
                                500<span class="text-[#4CAFF9]">+</span>
                            </div>
                            <div class="text-white/80" style="font-size: 16px; line-height: 24px;">Happy Clients</div>
                        </div>
                        <div class="text-center">
                            <div class="font-bold text-white mb-2" style="font-size: 44px; line-height: 52px;">
                                1000<span class="text-[#4CAFF9]">+</span>
                            </div>
                            <div class="text-white/80" style="font-size: 16px; line-height: 24px;">Projects Done</div>
                        </div>
                        <div class="text-center">
                            <div class="font-bold text-white mb-2" style="font-size: 44px; line-height: 52px;">
                                98<span class="text-[#4CAFF9]">%</span>
                            </div>
                            <div class="text-white/80" style="font-size: 16px; line-height: 24px;">Satisfaction</div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

</section>

{{-- Optimized Scripts --}}
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
