@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();

    $title = $fields['title'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $description = $fields['description'] ?? '';
    $features = isset($fields['features']) ? json_decode($fields['features'], true) : [];
    $image = $fields['image'] ?? null;

    $internships = \App\Models\TeamMember::where(function ($q) {
        $q->where('designation', 'LIKE', '%intern%')->orWhere('designation', 'LIKE', '%trainee%');
    })->count();

    $projects = \App\Models\Project::count();

    $sectionId = 'about-section-' . uniqid();
@endphp

<section
    class="relative py-8 lg:py-12 px-6 sm:px-8 lg:px-12 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900"
    id="{{ $sectionId }}">

    {{-- Decorative Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative">

        {{-- HEADER --}}
        <div class="text-center max-w-3xl mx-auto mb-4">
            {{-- Badge --}}
            @if ($subtitle)
                <span
                    class="about-badge inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm tracking-wide font-semibold
                    bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                    border border-[#1363C6]/20 dark:border-[#1363C6]/30
                    shadow-sm shadow-[#1363C6]/10 opacity-0">
                    {{ $subtitle }}
                </span>
            @endif

            {{-- Title --}}
            <h2
                class="about-title text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-2 leading-tight opacity-0">
                {{ $title }}
            </h2>
        </div>

        {{-- Description --}}
        @if ($description)
            <div class="about-description max-w-7xl mx-auto pb-8 opacity-0">
                <div class="text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                    {!! $description !!}
                </div>
            </div>
        @endif

        <div class="grid lg:grid-cols-2 gap-12 items-center">

            {{-- LEFT SIDE – Features --}}
            <div class="space-y-4">
                @foreach ($features as $index => $feature)
                    <div class="feature-item group flex gap-4 p-5 rounded-xl 
                        bg-white dark:bg-gray-900
                        border border-gray-100 dark:border-gray-800
                        hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50
                        hover:shadow-lg hover:shadow-[#1363C6]/5
                        transition-all duration-300 ease-out opacity-0"
                        data-index="{{ $index }}">

                        {{-- Number Badge --}}
                        <div
                            class="feature-badge w-11 h-11 rounded-lg flex items-center justify-center flex-shrink-0
                            bg-gradient-to-br from-[#1363C6] to-[#0d4a94] 
                            text-white font-bold text-[18px]
                            shadow-md shadow-[#1363C6]/20
                            transition-all duration-300">
                            {{ $index + 1 }}
                        </div>

                        {{-- Content --}}
                        <div class="flex-1">
                            <h3
                                class="text-[16px] font-semibold text-gray-900 dark:text-white mb-1.5 
                                group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8]
                                transition-colors duration-300">
                                {{ $feature['title'] }}
                            </h3>
                            <p class="text-[14px] leading-[22px] text-gray-600 dark:text-gray-400">
                                {{ $feature['content'] }}
                            </p>
                        </div>
                    </div>
                @endforeach

                {{-- Stats --}}
                <div class="stats-container grid grid-cols-2 gap-4 pt-3 opacity-0">
                    {{-- Internships --}}
                    <div
                        class="stat-card group relative p-6 rounded-xl bg-white dark:bg-gray-900 
                        border border-gray-200 dark:border-gray-800 
                        hover:border-[#1363C6]/30 dark:hover:border-[#1363C6]/40 
                        shadow-sm hover:shadow-lg hover:shadow-[#1363C6]/5 dark:hover:shadow-[#1363C6]/10 
                        transition-all duration-300">
                        <div class="stat-number text-[28px] font-extrabold text-[#1363C6] dark:text-[#4a8dd8] mb-1">
                            {{ $internships }}+
                        </div>
                        <p class="text-[13px] text-gray-600 dark:text-gray-400 font-medium">
                            Internships
                        </p>
                    </div>

                    {{-- Projects --}}
                    <div
                        class="stat-card group relative p-6 rounded-xl bg-white dark:bg-gray-900 
                        border border-gray-200 dark:border-gray-800 
                        hover:border-[#1363C6]/30 dark:hover:border-[#1363C6]/40 
                        shadow-sm hover:shadow-lg hover:shadow-[#1363C6]/5 dark:hover:shadow-[#1363C6]/10 
                        transition-all duration-300">
                        <div class="stat-number text-[28px] font-extrabold text-[#1363C6] dark:text-[#4a8dd8] mb-1">
                            {{ $projects }}+
                        </div>
                        <p class="text-[13px] text-gray-600 dark:text-gray-400 font-medium">
                            Projects Completed
                        </p>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE –  Image --}}
            <div class="relative lg:order-last order-first">
                @if ($image)
                    <div class="about-image relative group max-w-lg mx-auto lg:mx-0 opacity-0">
                        {{-- Soft glow behind image --}}
                        <div
                            class="absolute -inset-6 bg-gradient-to-br from-[#1363C6]/15 to-transparent rounded-[2rem] blur-2xl opacity-50 group-hover:opacity-70 transition-opacity duration-500">
                        </div>

                        {{-- Image container --}}
                        <div
                            class="relative rounded-2xl overflow-hidden shadow-xl shadow-gray-900/10 dark:shadow-black/30">

                            {{-- Main Image --}}
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $title }}"
                                class="w-full h-[450px] object-cover 
                                group-hover:scale-105 transition-transform duration-700 ease-out">

                            {{-- Subtle bottom fade for blending --}}
                            <div
                                class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-gray-50/60 to-transparent dark:from-gray-900/60 dark:to-transparent pointer-events-none">
                            </div>
                        </div>

                        {{-- Corner decorative elements --}}
                        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-[#1363C6]/10 rounded-full blur-xl"></div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

{{-- GSAP Animation Script --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            const sectionId = '#{{ $sectionId }}';

            // Animate badge
            gsap.fromTo(`${sectionId} .about-badge`, {
                opacity: 0,
                y: -30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .about-badge`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate title
            gsap.fromTo(`${sectionId} .about-title`, {
                opacity: 0,
                y: -30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.2,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .about-title`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate description
            gsap.fromTo(`${sectionId} .about-description`, {
                opacity: 0,
                y: 30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .about-description`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate feature items from bottom (staggered)
            gsap.fromTo(`${sectionId} .feature-item`, {
                opacity: 0,
                y: 60
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.15,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .feature-item`,
                    start: 'top 90%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate badge inside each feature item (from bottom - NO SPIN)
            document.querySelectorAll(`${sectionId} .feature-item`).forEach((item, index) => {
                const badge = item.querySelector('.feature-badge');

                gsap.fromTo(badge, {
                    opacity: 0,
                    y: 30,
                    scale: 0.8
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.6,
                    delay: 0.3 + (index * 0.1),
                    ease: 'back.out(1.7)',
                    scrollTrigger: {
                        trigger: item,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });
            });

            // Animate stats container
            gsap.fromTo(`${sectionId} .stats-container`, {
                opacity: 0,
                y: 40
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .stats-container`,
                    start: 'top 90%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate numbers counting up
            document.querySelectorAll(`${sectionId} .stat-number`).forEach(element => {
                const target = parseInt(element.textContent);

                ScrollTrigger.create({
                    trigger: element,
                    start: 'top 85%',
                    onEnter: () => {
                        gsap.from(element, {
                            textContent: 0,
                            duration: 2,
                            ease: 'power1.out',
                            snap: {
                                textContent: 1
                            },
                            onUpdate: function() {
                                element.textContent = Math.ceil(element
                                    .textContent) + '+';
                            }
                        });
                    }
                });
            });

            // Animate image from right with fade
            gsap.fromTo(`${sectionId} .about-image`, {
                opacity: 0,
                x: 60,
                scale: 0.9
            }, {
                opacity: 1,
                x: 0,
                scale: 1,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .about-image`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Hover effects for feature items
            document.querySelectorAll(`${sectionId} .feature-item`).forEach(item => {
                item.addEventListener('mouseenter', () => {
                    gsap.to(item, {
                        y: -8,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });

                item.addEventListener('mouseleave', () => {
                    gsap.to(item, {
                        y: 0,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });
            });

            // Hover effects for stat cards
            document.querySelectorAll(`${sectionId} .stat-card`).forEach(card => {
                card.addEventListener('mouseenter', () => {
                    gsap.to(card, {
                        y: -8,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });

                card.addEventListener('mouseleave', () => {
                    gsap.to(card, {
                        y: 0,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });
            });
        });
    </script>
@endpush
