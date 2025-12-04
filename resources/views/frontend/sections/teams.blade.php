@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();

    $heading = $fields['heading'] ?? '';
    $layout = $fields['layout'] ?? 'grid';

    $all_members = \App\Models\TeamMember::all();

    // Define hierarchy levels
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
    $juniorPositions = ['intern', 'trainee', 'junior', 'associate', 'jr'];

    // Categorize team members
    $executives = collect();
    $seniors = collect();
    $juniors = collect();
    $others = collect();

    foreach ($all_members as $member) {
        $designation = strtolower($member->designation ?? '');
        $isExecutive = false;
        foreach ($executivePositions as $pos) {
            if (str_contains($designation, $pos)) {
                $executives->push($member);
                $isExecutive = true;
                break;
            }
        }
        if (!$isExecutive) {
            $isSenior = false;
            foreach ($seniorPositions as $pos) {
                if (str_contains($designation, $pos)) {
                    $seniors->push($member);
                    $isSenior = true;
                    break;
                }
            }
            if (!$isSenior) {
                $isJunior = false;
                foreach ($juniorPositions as $pos) {
                    if (str_contains($designation, $pos)) {
                        $juniors->push($member);
                        $isJunior = true;
                        break;
                    }
                }
                if (!$isJunior) {
                    $others->push($member);
                }
            }
        }
    }

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
                    OUR TEAM
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
                @foreach (['executives' => 'Leadership', 'seniors' => 'Senior Team', 'others' => 'Team Members', 'juniors' => 'Interns & Trainees'] as $groupKey => $title)
                    @if (isset($$groupKey) && count($$groupKey) > 0)
                        <div>
                            <div class="team-section-title flex items-center justify-center gap-4 mb-10 opacity-0"
                                data-section="{{ $groupKey }}">
                                <div
                                    class="h-px flex-1 bg-gradient-to-r from-transparent via-[#1363C6]/20 to-[#1363C6]/40">
                                </div>
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white uppercase tracking-wide">
                                    {{ $title }}
                                </h2>
                                <div
                                    class="h-px flex-1 bg-gradient-to-l from-transparent via-[#1363C6]/20 to-[#1363C6]/40">
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">
                                @foreach ($$groupKey as $index => $member)
                                    <div class="team-member-card group relative bg-white dark:bg-gray-800 rounded-2xl overflow-hidden 
                                        border border-gray-200 dark:border-gray-700 
                                        hover:shadow-xl hover:shadow-[#1363C6]/10 
                                        transition-all duration-300 cursor-pointer opacity-0"
                                        data-member-id="{{ $member->id }}">

                                        <div
                                            class="relative bg-gradient-to-br from-[#1363C6]/5 to-[#1363C6]/10 dark:from-[#1363C6]/10 dark:to-[#1363C6]/20 p-6 pb-8">
                                            @if (!empty($member->photo))
                                                <div class="relative w-32 h-32 mx-auto">
                                                    <div
                                                        class="absolute inset-0 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-full opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500">
                                                    </div>
                                                    <img src="{{ asset('storage/' . $member->photo) }}"
                                                        alt="{{ $member->name }}"
                                                        class="relative w-full h-full rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg group-hover:scale-105 transition-transform duration-300">
                                                </div>
                                            @else
                                                <div
                                                    class="relative w-32 h-32 mx-auto bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-full flex items-center justify-center shadow-lg border-4 border-white dark:border-gray-800">
                                                    <span
                                                        class="text-3xl font-bold text-white">{{ substr($member->name ?? 'U', 0, 1) }}</span>
                                                </div>
                                            @endif

                                            <div class="absolute top-4 right-4">
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold bg-[#1363C6] text-white rounded-full">Active</span>
                                            </div>
                                        </div>

                                        <div class="p-5 text-center">
                                            @if (!empty($member->name))
                                                <h3
                                                    class="text-lg font-bold text-gray-900 dark:text-white mb-1 
                                                    group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] 
                                                    transition-colors duration-300">
                                                    {{ $member->name }}
                                                </h3>
                                            @endif

                                            @if (!empty($member->designation))
                                                <p
                                                    class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2 min-h-[2.5rem]">
                                                    {{ $member->designation }}
                                                </p>
                                            @endif

                                            <div
                                                class="w-12 h-0.5 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] mx-auto mb-4 rounded-full">
                                            </div>

                                            @if (!empty($member->social_links) && count($member->social_links) > 0)
                                                <div class="flex items-center justify-center gap-2">
                                                    @foreach ($member->social_links as $link)
                                                        <a href="{{ $link['url'] ?? '#' }}" target="_blank"
                                                            rel="noopener noreferrer" onclick="event.stopPropagation()"
                                                            class="w-9 h-9 flex items-center justify-center rounded-lg 
                                                            bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 
                                                            hover:bg-[#1363C6] hover:text-white hover:scale-110 hover:shadow-lg 
                                                            transition-all duration-300">
                                                            <i class="fab fa-{{ $link['platform'] }} text-sm"></i>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <div
                                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- Improved Modal --}}
<div id="teamMemberModal"
    class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/80 backdrop-blur-sm">

    {{-- Modal Container --}}
    <div class="relative w-full max-w-4xl max-h-[90vh] modal-content">

        {{-- Close Button - TOP RIGHT --}}
        <button id="closeModal"
            class="absolute -top-4 -right-4 z-50 w-10 h-10 flex items-center justify-center
            bg-white dark:bg-gray-800 rounded-full shadow-lg
            text-gray-700 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-400
            hover:scale-110 hover:rotate-90 transition-all duration-300
            border-2 border-gray-200 dark:border-gray-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Modal Content Card --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl overflow-hidden">
            <div class="flex flex-col md:flex-row max-h-[85vh]">

                {{-- Left: Photo & Social Section --}}
                <div
                    class="md:w-2/5 bg-gradient-to-br from-[#1363C6]/10 via-[#1363C6]/5 to-transparent 
                    dark:from-[#1363C6]/20 dark:via-[#1363C6]/10 dark:to-transparent 
                    p-8 flex flex-col items-center justify-center relative">

                    {{-- Decorative circles --}}
                    <div class="absolute top-4 right-4 w-24 h-24 bg-[#1363C6]/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-4 left-4 w-32 h-32 bg-[#0d4a94]/10 rounded-full blur-2xl"></div>

                    <div class="relative z-10 flex flex-col items-center w-full">
                        {{-- Photo --}}
                        <div class="relative mb-6">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-full opacity-20 blur-xl">
                            </div>
                            <div id="modalPhoto"
                                class="relative w-40 h-40 rounded-full shadow-2xl border-4 border-white dark:border-gray-800 
                                overflow-hidden bg-gradient-to-br from-[#1363C6] to-[#0d4a94] 
                                flex items-center justify-center">
                            </div>
                        </div>

                        {{-- Name & Designation (Mobile Only) --}}
                        <div class="md:hidden text-center mb-6 w-full">
                            <h2 id="modalNameMobile" class="text-2xl font-extrabold text-gray-900 dark:text-white mb-2">
                            </h2>
                            <p id="modalDesignationMobile"
                                class="text-sm text-[#1363C6] dark:text-[#4a8dd8] font-semibold"></p>
                        </div>

                        {{-- Social Links --}}
                        <div class="w-full">
                            <p
                                class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide text-center mb-3">
                                Connect
                            </p>
                            <div id="modalSocialLinks" class="flex items-center justify-center flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                {{-- Right: Info Section --}}
                <div class="md:w-3/5 p-8 flex flex-col overflow-hidden">
                    {{-- Name & Designation (Desktop) --}}
                    <div class="hidden md:block mb-6">
                        <h2 id="modalName" class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2"></h2>
                        <p id="modalDesignation" class="text-lg text-[#1363C6] dark:text-[#4a8dd8] font-semibold"></p>
                        <div class="w-16 h-1 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] rounded-full mt-4"></div>
                    </div>

                    {{-- Bio Section (Scrollable) --}}
                    <div class="flex-1 overflow-y-auto pr-2">
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 mb-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-[#1363C6]/10 dark:bg-[#1363C6]/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-[#1363C6] dark:text-[#4a8dd8]" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">About</h3>
                            </div>
                            <div id="modalBio"
                                class="text-[15px] leading-[26px] text-gray-600 dark:text-gray-400 space-y-3"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

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
