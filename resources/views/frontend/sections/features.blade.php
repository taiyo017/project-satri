@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();

    $heading = $fields['heading'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $content = $fields['content'] ?? '';
    $layout = $fields['layout'] ?? 'grid'; // grid / list

    $features = isset($fields['features']) ? json_decode($fields['features'], true) : [];
    $sectionId = 'feature-section-' . uniqid();
@endphp

<section class="py-8 lg:py-12 px-6 sm:px-8 lg:px-12 bg-white dark:bg-gray-950" id="{{ $sectionId }}">
    <div class="max-w-7xl mx-auto">

        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto">
            @if ($subtitle)
                <p
                    class="feature-subtitle text-[20px] leading-[28px] mt-4 mb-4 font-bold tracking-wider uppercase text-[#1363C6] dark:text-[#4a8dd8] opacity-0">
                    {{ $subtitle }}
                </p>
            @endif

            @if ($heading)
                <h2
                    class="feature-heading text-[40px] leading-[48px] mt-8 mb-6 font-extrabold text-gray-900 dark:text-white opacity-0">
                    {{ $heading }}
                </h2>
            @endif
        </div>

        {{-- Content Section --}}
        @if ($content)
            <div class="max-w-7xl mx-auto mb-8 feature-content opacity-0">
                <div class="text-[16px] sm:text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                    {!! $content !!}
                </div>
            </div>
        @endif

        {{-- GRID LAYOUT --}}
        @if ($layout === 'grid')
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($features as $index => $item)
                    <div class="feature-card group relative p-6 rounded-xl bg-white dark:bg-gray-900 
                        border border-gray-200 dark:border-gray-800 
                        hover:border-[#1363C6]/30 dark:hover:border-[#1363C6]/40 
                        shadow-sm hover:shadow-lg hover:shadow-[#1363C6]/5 dark:hover:shadow-[#1363C6]/10 
                        transition-all duration-300 opacity-0"
                        data-index="{{ $index }}">

                        <div class="feature-header flex items-center gap-3 mb-3 opacity-0">
                            @if (!empty($item['icon']))
                                <div
                                    class="w-8 h-8 flex items-center justify-center rounded-lg
                                    bg-[#1363C6]/10 dark:bg-[#1363C6]/20 
                                    text-[#1363C6] dark:text-[#4a8dd8]
                                    flex-shrink-0 group-hover:bg-[#1363C6]/20 dark:group-hover:bg-[#1363C6]/30 transition-all duration-300">
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
                            <p
                                class="feature-description text-[14px] leading-[22px] text-gray-600 dark:text-gray-400 mt-1 opacity-0">
                                {{ $item['description'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
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

            // Animate subtitle - fade and slide from top
            gsap.fromTo(`${sectionId} .feature-subtitle`, {
                opacity: 0,
                y: -30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .feature-subtitle`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate heading - fade and slide from top
            gsap.fromTo(`${sectionId} .feature-heading`, {
                opacity: 0,
                y: -30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.2,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .feature-heading`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate content - fade and slide up
            gsap.fromTo(`${sectionId} .feature-content`, {
                opacity: 0,
                y: 30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .feature-content`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate feature cards - stagger from bottom
            gsap.fromTo(`${sectionId} .feature-card`, {
                opacity: 0,
                y: 60
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.15,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .feature-card`,
                    start: 'top 90%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate icon + title together from bottom (inside each card)
            document.querySelectorAll(`${sectionId} .feature-card`).forEach((card, index) => {
                const header = card.querySelector('.feature-header');
                const description = card.querySelector('.feature-description');

                // Animate header (icon + title together)
                gsap.fromTo(header, {
                    opacity: 0,
                    y: 30
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 0.6,
                    delay: 0.3 + (index * 0.1),
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });

                // Animate description after header
                if (description) {
                    gsap.fromTo(description, {
                        opacity: 0,
                        y: 20
                    }, {
                        opacity: 1,
                        y: 0,
                        duration: 0.6,
                        delay: 0.5 + (index * 0.1),
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: card,
                            start: 'top 85%',
                            toggleActions: 'play none none none'
                        }
                    });
                }
            });

            // Simple hover effect - lift card up
            document.querySelectorAll(`${sectionId} .feature-card`).forEach(card => {
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
