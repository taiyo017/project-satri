@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    $title = $fields['title'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $content = $fields['content'] ?? '';
    $image = $fields['image'] ?? null;

    $buttons = isset($fields['buttons']) ? json_decode($fields['buttons'], true) : [];

    $sectionId = 'about-section-' . uniqid();
@endphp

<section class="relative py-16 lg:py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-950 overflow-hidden"
    id="{{ $sectionId }}">

    {{-- Decorative Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="about-bg-blur-1 absolute top-20 -right-32 w-[500px] h-[500px] bg-[#1363C6]/5 rounded-full blur-3xl">
        </div>
        <div
            class="about-bg-blur-2 absolute bottom-20 -left-32 w-[500px] h-[500px] bg-[#1363C6]/5 rounded-full blur-3xl">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div
            class="grid {{ $image ? 'lg:grid-cols-2' : 'grid-cols-1' }} gap-12 lg:gap-16 items-center {{ !$image ? 'max-w-4xl mx-auto text-center' : '' }}">

            {{-- Content Section --}}
            <div class="{{ !$image ? 'text-center' : 'text-left' }}">

                @if ($subtitle)
                    <p
                        class="about-subtitle opacity-0 text-[16px] sm:text-[16px] md:text-[20px]   leading-[28px] mt-4 mb-4 font-bold tracking-wider uppercase text-[#1363C6] dark:text-[#4a8dd8]">
                        {{ $subtitle }}
                    </p>
                @endif

                @if ($title)
                    <h2
                        class="about-title text-[24px] sm:text-[24px] md:text-[40px] lg:text-[40px] leading-[48px] mt-6 mb-6 font-extrabold text-gray-900 dark:text-white">
                        {{ $title }}
                    </h2>
                @endif

                @if ($content)
                    <div
                        class="about-content opacity-0 text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                        {!! $content !!}
                    </div>
                @endif

                @if (!empty($buttons))
                    <div
                        class="about-buttons opacity-0 flex flex-wrap gap-4 mt-8 {{ !$image ? 'justify-center' : 'justify-start' }}">
                        @foreach ($buttons as $index => $btn)
                            @if ($index === 0)
                                {{-- Primary Button --}}
                                <a href="{{ $btn['url'] ?? '#' }}"
                                    class="about-btn-primary inline-flex items-center px-5 py-2.5 text-[14px] leading-[20px] font-semibold text-white bg-[#1363C6] rounded-full shadow-md shadow-[#1363C6]/25 hover:bg-[#0e54ad] transition-all duration-300">
                                    {{ $btn['text'] ?? 'Learn More' }}
                                    <svg class="btn-arrow w-4 h-4 ml-2 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                {{-- Secondary Button --}}
                                <a href="{{ $btn['url'] ?? '#' }}"
                                    class="about-btn-secondary inline-flex items-center px-5 py-2.5 text-[14px] leading-[20px] font-semibold text-gray-700 dark:text-gray-300 bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-full hover:border-[#1363C6] hover:text-[#1363C6] dark:hover:border-[#4a8dd8] dark:hover:text-[#4a8dd8] transition-all duration-300">
                                    {{ $btn['text'] ?? 'Learn More' }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Image Section --}}
            @if ($image)
                <div class="about-image-wrapper opacity-0 relative lg:order-last order-first">

                    {{-- Soft glow behind image --}}
                    <div
                        class="about-glow absolute -inset-8 bg-gradient-to-br from-[#1363C6]/12 via-[#1363C6]/5 to-transparent rounded-[3rem] blur-3xl opacity-50">
                    </div>

                    {{-- Image container - properly sized --}}
                    <div
                        class="relative rounded-2xl overflow-hidden shadow-2xl shadow-gray-300/30 dark:shadow-black/40">

                        {{-- Main Image - full and natural --}}
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $title }}"
                            class="about-image w-full h-auto object-contain transform transition-all duration-700">

                        {{-- Subtle bottom blend only --}}
                        <div
                            class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-white/30 to-transparent dark:from-gray-950/30 dark:to-transparent pointer-events-none">
                        </div>

                        {{-- Hover overlay --}}
                        <div
                            class="about-overlay absolute inset-0 bg-gradient-to-br from-[#1363C6]/0 to-[#1363C6]/0 opacity-0 transition-all duration-500 pointer-events-none">
                        </div>
                    </div>

                    {{-- Decorative corner elements --}}
                    <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-[#1363C6]/8 rounded-full blur-2xl"></div>
                    <div class="absolute -top-6 -left-6 w-32 h-32 bg-[#1363C6]/5 rounded-full blur-xl"></div>
                </div>
            @endif

        </div>
    </div>
</section>

{{-- GSAP Animation Script --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            const sectionId = '#{{ $sectionId }}';

            // Floating background blur animations
            gsap.to(`${sectionId} .about-bg-blur-1`, {
                y: 40,
                x: -30,
                duration: 7,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            gsap.to(`${sectionId} .about-bg-blur-2`, {
                y: -40,
                x: 30,
                duration: 9,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            // Subtitle slide from left
            gsap.fromTo(`${sectionId} .about-subtitle`, {
                opacity: 0,
                x: -60
            }, {
                opacity: 1,
                x: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .about-subtitle`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Title animation - Clean fade and slide up
            gsap.fromTo(`${sectionId} .about-title`, {
                opacity: 0,
                y: 50
            }, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .about-title`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Content fade up
            gsap.fromTo(`${sectionId} .about-content`, {
                opacity: 0,
                y: 50
            }, {
                opacity: 1,
                y: 0,
                duration: 1.2,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .about-content`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Buttons container
            gsap.fromTo(`${sectionId} .about-buttons`, {
                opacity: 0,
                y: 40
            }, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .about-buttons`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Individual button scale animations
            gsap.fromTo(`${sectionId} .about-btn-primary, ${sectionId} .about-btn-secondary`, {
                scale: 0.7,
                opacity: 0
            }, {
                scale: 1,
                opacity: 1,
                duration: 0.7,
                stagger: 0.15,
                ease: 'back.out(1.7)',
                scrollTrigger: {
                    trigger: `${sectionId} .about-buttons`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Image wrapper entrance
            gsap.fromTo(`${sectionId} .about-image-wrapper`, {
                opacity: 0,
                x: 100,
                scale: 0.9
            }, {
                opacity: 1,
                x: 0,
                scale: 1,
                duration: 1.4,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .about-image-wrapper`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Glow pulse effect
            gsap.to(`${sectionId} .about-glow`, {
                opacity: 0.7,
                scale: 1.05,
                duration: 3,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            // Button hover effects
            document.querySelectorAll(`${sectionId} .about-btn-primary`).forEach(btn => {
                const arrow = btn.querySelector('.btn-arrow');

                btn.addEventListener('mouseenter', () => {
                    gsap.to(btn, {
                        y: -4,
                        scale: 1.05,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                    gsap.to(arrow, {
                        x: 6,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });

                btn.addEventListener('mouseleave', () => {
                    gsap.to(btn, {
                        y: 0,
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
            });

            document.querySelectorAll(`${sectionId} .about-btn-secondary`).forEach(btn => {
                btn.addEventListener('mouseenter', () => {
                    gsap.to(btn, {
                        y: -4,
                        scale: 1.05,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });

                btn.addEventListener('mouseleave', () => {
                    gsap.to(btn, {
                        y: 0,
                        scale: 1,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });
            });

            // Image hover effect - gentle scale only
            const imageWrapper = document.querySelector(`${sectionId} .about-image-wrapper`);
            if (imageWrapper) {
                const image = imageWrapper.querySelector('.about-image');
                const overlay = imageWrapper.querySelector('.about-overlay');

                imageWrapper.addEventListener('mouseenter', () => {
                    gsap.to(image, {
                        scale: 1.05,
                        duration: 0.7,
                        ease: 'power2.out'
                    });
                    gsap.to(overlay, {
                        opacity: 1,
                        background: 'linear-gradient(to bottom right, rgba(19, 99, 198, 0.03), rgba(19, 99, 198, 0.08))',
                        duration: 0.5,
                        ease: 'power2.out'
                    });
                });

                imageWrapper.addEventListener('mouseleave', () => {
                    gsap.to(image, {
                        scale: 1,
                        duration: 0.7,
                        ease: 'power2.out'
                    });
                    gsap.to(overlay, {
                        opacity: 0,
                        duration: 0.5,
                        ease: 'power2.out'
                    });
                });
            }
        });
    </script>
@endpush
