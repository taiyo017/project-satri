@props(['section', 'projects', 'fullPage' => null])

@php
    $currentSlug = request()->route()?->parameter('slug') ?? '';
    if (is_null($fullPage)) {
        $fullPage = $currentSlug === 'our-projects';
    }

    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    $title = $fields['title'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $content = $fields['content'] ?? '';

    // Fetch projects based on context
    if ($fullPage) {
        $displayProjects = $projects;
    } else {
        $displayProjects = \App\Models\Project::where('status', true)->latest()->take(4)->get();
    }

    $totalProjectsCount = \App\Models\Project::where('status', true)->count();

    $sectionId = 'projects-section-' . uniqid();
@endphp

<section
    class="relative py-8 lg:py-12 px-6 sm:px-8 lg:px-14 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-950 overflow-hidden"
    id="{{ $sectionId }}">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="projects-bg-blur-1 absolute top-20 left-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="projects-bg-blur-2 absolute bottom-20 right-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative">

        {{-- Section Header --}}
        @if ($title || $subtitle || $content)
            <div class="text-center max-w-3xl mx-auto mb-4">

                @if ($subtitle)
                    <span
                        class="projects-badge opacity-0 inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs sm:text-xs md:text-sm lg:text-sm tracking-wide font-semibold
                        bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                        border border-[#1363C6]/20 dark:border-[#1363C6]/30
                        shadow-sm shadow-[#1363C6]/10">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                        </svg>
                        {{ $subtitle }}
                    </span>
                @endif
            </div>

            @if ($content)
                <div class="projects-content max-w-7xl mx-auto mb-4 opacity-0">
                    <div
                        class="text-[16px] sm:text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                        {!! $content !!}
                    </div>
                </div>
            @endif

            <div class="text-center max-w-3xl mx-auto mb-4">
                @if ($title)
                    <h2
                        class="projects-title opacity-0 text-[24px] sm:text-[24px] md:text-[40px] lg:text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight">
                        {{ $title }}
                    </h2>
                @endif
            </div>
        @endif

        {{-- Projects Grid --}}
        @if ($displayProjects->count())
            <div class="projects-grid grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-12">
                @foreach ($displayProjects as $index => $project)
                    <div class="project-card opacity-0 group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden 
                        border border-gray-200 dark:border-gray-800 
                        hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 
                        transition-all duration-500 
                        hover:shadow-2xl hover:shadow-[#1363C6]/20"
                        data-index="{{ $index }}">

                        {{-- Project Image --}}
                        <div
                            class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 overflow-hidden">
                            @if ($project->image)
                                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}"
                                    class="project-image w-full h-full object-cover transition-transform duration-700"
                                    loading="lazy" decoding="async">

                                {{-- Overlay on hover --}}
                                @if ($project->project_url)
                                    <div
                                        class="project-overlay absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition-opacity duration-300">
                                        <div
                                            class="absolute bottom-4 left-4 right-4 transform translate-y-4 transition-transform duration-300">
                                            <a href="{{ $project->project_url }}" target="_blank"
                                                rel="noopener noreferrer"
                                                class="project-btn inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-700 text-white text-sm font-semibold rounded-lg shadow-lg hover:from-blue-600 hover:to-blue-800 transition-all duration-300">
                                                <span>View Project</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            {{-- Status Badge --}}
                            @if ($project->project_url)
                                <div
                                    class="absolute top-4 right-4 px-3 py-1.5 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1.5">
                                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                    Live
                                </div>
                            @endif
                        </div>

                        {{-- Project Content --}}
                        <div class="p-5">
                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors line-clamp-2">
                                {{ $project->title }}
                            </h3>

                            @if ($project->short_description)
                                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                    {{ $project->short_description }}
                                </p>
                            @endif

                            {{-- Technologies --}}
                            @if (isset($project->technologies) && $project->technologies)
                                <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-100 dark:border-gray-800">
                                    @foreach (array_slice(explode(',', $project->technologies), 0, 3) as $tech)
                                        <span
                                            class="px-2.5 py-1 bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8] text-xs font-semibold rounded-md">
                                            {{ trim($tech) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- View Full Projects Button (Homepage Only) --}}
            @if (!$fullPage)
                <div class="projects-view-btn opacity-0 text-center mt-10">
                    <a href="{{ route('frontend.page.show', 'our-projects') }}"
                        class="group inline-flex items-center gap-3 px-8 py-3.5 
                        bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                        text-white font-semibold rounded-xl 
                        hover:shadow-xl hover:shadow-[#1363C6]/30 
                        transition-all duration-300">
                        <span>View All Projects</span>
                        <svg class="view-arrow w-5 h-5 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            @endif

            {{-- Pagination (Full Page Only) --}}
            @if ($fullPage && method_exists($projects, 'links'))
                <div class="mt-12 flex justify-center">
                    <div class="inline-block">
                        {{ $projects->links() }}
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
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Projects Yet</h3>
                <p class="text-lg text-gray-600 dark:text-gray-400">Check back soon for exciting projects!</p>
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
            gsap.to(`${sectionId} .projects-bg-blur-1`, {
                y: 30,
                x: -20,
                duration: 6,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            gsap.to(`${sectionId} .projects-bg-blur-2`, {
                y: -30,
                x: 20,
                duration: 8,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            // Badge animation
            gsap.fromTo(`${sectionId} .projects-badge`, {
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
                    trigger: `${sectionId} .projects-badge`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Title animation
            gsap.fromTo(`${sectionId} .projects-title`, {
                opacity: 0,
                y: 50
            }, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .projects-title`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Content animation
            gsap.fromTo(`${sectionId} .projects-content`, {
                opacity: 0,
                y: 40
            }, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .projects-content`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Project cards stagger animation
            gsap.fromTo(`${sectionId} .project-card`, {
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
                    trigger: `${sectionId} .projects-grid`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // View All Projects button animation
            gsap.fromTo(`${sectionId} .projects-view-btn`, {
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
                    trigger: `${sectionId} .projects-view-btn`,
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

            // Card hover effects
            document.querySelectorAll(`${sectionId} .project-card`).forEach(card => {
                const image = card.querySelector('.project-image');
                const overlay = card.querySelector('.project-overlay');

                card.addEventListener('mouseenter', () => {
                    gsap.to(card, {
                        y: -10,
                        duration: 0.4,
                        ease: 'power2.out'
                    });

                    if (image) {
                        gsap.to(image, {
                            scale: 1.1,
                            duration: 0.7,
                            ease: 'power2.out'
                        });
                    }

                    if (overlay) {
                        gsap.to(overlay, {
                            opacity: 1,
                            duration: 0.3
                        });
                        gsap.to(overlay.querySelector('div'), {
                            y: 0,
                            duration: 0.3,
                            delay: 0.1
                        });
                    }
                });

                card.addEventListener('mouseleave', () => {
                    gsap.to(card, {
                        y: 0,
                        duration: 0.4,
                        ease: 'power2.out'
                    });

                    if (image) {
                        gsap.to(image, {
                            scale: 1,
                            duration: 0.7,
                            ease: 'power2.out'
                        });
                    }

                    if (overlay) {
                        gsap.to(overlay, {
                            opacity: 0,
                            duration: 0.3
                        });
                        gsap.to(overlay.querySelector('div'), {
                            y: 16,
                            duration: 0.3
                        });
                    }
                });
            });

            // View All button hover effect
            const viewBtn = document.querySelector(`${sectionId} .projects-view-btn a`);
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
