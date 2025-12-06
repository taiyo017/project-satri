@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();

    $heading = $fields['heading'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $layout = $fields['layout'] ?? 'grid';

    $all_members = \App\Models\TeamMember::orderBy('created_at', 'desc')->get(); // Most recent first

    // Positions
    $executivePositions = ['ceo', 'president', 'founder', 'co-founder', 'chief executive officer'];
    $seniorPositions = [
        'cto',
        'coo',
        'cfo',
        'senior developer',
        'operation manager',
        'operations manager',
        'senior',
        'sr',
        'lead',
        'manager',
        'director',
    ];
    $juniorPositions = ['junior', 'associate', 'jr'];
    $internPositions = ['intern', 'trainee'];

    // Categorize members
    $executives = collect();
    $seniors = collect();
    $juniors = collect();
    $interns = collect();
    $others = collect();

    foreach ($all_members as $member) {
        $designation = strtolower($member->designation ?? '');
        $isMatched = false;

        foreach ($executivePositions as $pos) {
            if (str_contains($designation, $pos)) {
                $executives->push($member);
                $isMatched = true;
                break;
            }
        }
        if (!$isMatched) {
            foreach ($seniorPositions as $pos) {
                if (str_contains($designation, $pos)) {
                    $seniors->push($member);
                    $isMatched = true;
                    break;
                }
            }
        }
        if (!$isMatched) {
            foreach ($juniorPositions as $pos) {
                if (str_contains($designation, $pos)) {
                    $juniors->push($member);
                    $isMatched = true;
                    break;
                }
            }
        }
        if (!$isMatched) {
            foreach ($internPositions as $pos) {
                if (str_contains($designation, $pos)) {
                    $interns->push($member);
                    $isMatched = true;
                    break;
                }
            }
        }
        if (!$isMatched) {
            $others->push($member);
        }
    }

    // Pagination for interns page
    $perPage = 12; // members per page
    $currentPage = (int) request()->get('page', 1);

    $currentPageSlug = request()->segment(1);
    if ($currentPageSlug === 'interns') {
        $groupsToShow = ['interns'];
        $internsPaginated = $interns->forPage($currentPage, $perPage);
    } else {
        $groupsToShow = ['executives', 'seniors', 'juniors', 'others'];
    }

    $groups = [
        'executives' => $executives,
        'seniors' => $seniors,
        'juniors' => $juniors,
        'interns' => $internsPaginated ?? $interns,
        'others' => $others,
    ];

    $allMembersJson = $all_members->toJson();
    $sectionId = 'team-section-' . uniqid();
@endphp


<section
    class="relative py-8 lg:py-12 px-6 sm:px-8 lg:px-12 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900 overflow-hidden"
    id="{{ $sectionId }}">

    {{-- Decorative Background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative">
        @if ($heading)
            <div class="text-center max-w-3xl mx-auto mb-8">
                <span
                    class="team-badge inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs sm:text-xs md:text-sm lg:text-sm tracking-wide font-semibold 
                    bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8] 
                    border border-[#1363C6]/20 dark:border-[#1363C6]/30 shadow-sm shadow-[#1363C6]/10 opacity-0">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    {{ $subtitle ?? 'Meet Our Team' }}
                </span>

                <h2
                    class="team-heading text-[24px] sm:text-[24px] md:text-[40px] lg:text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight opacity-0">
                    {{ $heading }}
                </h2>
            </div>

            @if ($fields['content'])
                <div class="team-content max-w-7xl mx-auto mb-12 opacity-0">
                    <div class="text-[16px] leading-[26px] text-gray-600 dark:text-gray-400 text-justify">
                        {!! $fields['content'] !!}
                    </div>
                </div>
            @endif
        @endif

        @if ($layout === 'grid')
            <div class="space-y-16">
                @foreach (['executives' => 'Leadership', 'seniors' => 'Senior Team', 'juniors' => 'Junior Team', 'interns' => 'Interns & Trainees', 'others' => 'Team Members'] as $groupKey => $title)
                    @if (in_array($groupKey, $groupsToShow))
                        @php $members = $groups[$groupKey]; @endphp
                        @if ($members->count() > 0)
                            <x-team-card :title="$title" :members="$members" :group-key="$groupKey" />
                        @endif
                    @endif
                @endforeach
            </div>

            {{-- Pagination for interns page --}}
            @if ($currentPageSlug === 'interns')
                <div class="flex justify-center mt-8 space-x-4">
                    @if ($currentPage > 1)
                        <a href="?page={{ $currentPage - 1 }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded">Prev</a>
                    @endif
                    @if ($interns->count() > $currentPage * $perPage)
                        <a href="?page={{ $currentPage + 1 }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded">Next</a>
                    @endif
                </div>
            @endif
        @endif
    </div>
</section>
<x-member-preview :all-members-json="$allMembersJson" :section-id="$sectionId" />

@push('scripts')
    <script>
        const teamMembers = {!! $allMembersJson !!};

        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            const sectionId = '#{{ $sectionId }}';

            // Animate badge
            gsap.fromTo(`${sectionId} .team-badge`, {
                opacity: 0,
                y: -30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .team-badge`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate heading
            gsap.fromTo(`${sectionId} .team-heading`, {
                opacity: 0,
                y: -30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.2,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .team-heading`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate content
            gsap.fromTo(`${sectionId} .team-content`, {
                opacity: 0,
                y: 30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .team-content`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate section titles
            document.querySelectorAll(`${sectionId} .team-section-title`).forEach(title => {
                gsap.fromTo(title, {
                    opacity: 0,
                    y: 40
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: title,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });
            });

            // Animate team cards (staggered from bottom)
            gsap.fromTo(`${sectionId} .team-member-card`, {
                opacity: 0,
                y: 60
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .team-member-card`,
                    start: 'top 90%',
                    toggleActions: 'play none none none'
                }
            });

            // Hover effect for cards
            document.querySelectorAll(`${sectionId} .team-member-card`).forEach(card => {
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

            // Modal functionality
            const modal = document.getElementById('teamMemberModal');
            const closeBtn = document.getElementById('closeModal');

            document.querySelectorAll('.team-member-card').forEach(card => {
                card.addEventListener('click', () => {
                    const memberId = card.dataset.memberId;
                    const member = teamMembers.find(m => m.id == memberId);

                    if (member) {
                        // Set name and designation
                        document.getElementById('modalName').textContent = member.name || '';
                        document.getElementById('modalNameMobile').textContent = member.name || '';
                        document.getElementById('modalDesignation').textContent = member
                            .designation || '';
                        document.getElementById('modalDesignationMobile').textContent = member
                            .designation || '';
                        document.getElementById('modalBio').innerHTML = member.bio ||
                            'No bio available for this team member.';

                        // Set photo
                        const photoDiv = document.getElementById('modalPhoto');
                        if (member.photo) {
                            photoDiv.innerHTML =
                                `<img src="/storage/${member.photo}" alt="${member.name}" class="w-full h-full object-cover">`;
                        } else {
                            photoDiv.innerHTML =
                                `<span class="text-4xl font-bold text-white">${(member.name || 'U').charAt(0)}</span>`;
                        }

                        // Set social links
                        const socialDiv = document.getElementById('modalSocialLinks');
                        socialDiv.innerHTML = '';
                        if (member.social_links && member.social_links.length > 0) {
                            member.social_links.forEach(link => {
                                socialDiv.innerHTML += `<a href="${link.url}" target="_blank" rel="noopener" 
                                onclick="event.stopPropagation()" 
                                class="w-10 h-10 flex items-center justify-center rounded-lg 
                                bg-[#1363C6]/10 dark:bg-[#1363C6]/20 text-[#1363C6] dark:text-[#4a8dd8] 
                                hover:bg-[#1363C6] hover:text-white hover:scale-110 
                                transition-all duration-300" 
                                title="${link.platform}">
                                <i class="fab fa-${link.platform} text-base"></i>
                            </a>`;
                            });
                        } else {
                            socialDiv.innerHTML =
                                '<p class="text-sm text-gray-500 dark:text-gray-400">No social links available</p>';
                        }

                        // Show modal with animation
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';

                        gsap.fromTo('.modal-content', {
                            opacity: 0,
                            scale: 0.9,
                            y: 30
                        }, {
                            opacity: 1,
                            scale: 1,
                            y: 0,
                            duration: 0.4,
                            ease: 'power3.out'
                        });
                    }
                });
            });

            // Close modal
            function closeModal() {
                gsap.to('.modal-content', {
                    opacity: 0,
                    scale: 0.9,
                    y: 30,
                    duration: 0.3,
                    ease: 'power2.in',
                    onComplete: () => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.style.overflow = 'auto';
                    }
                });
            }

            closeBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // ESC key to close
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
@endpush
