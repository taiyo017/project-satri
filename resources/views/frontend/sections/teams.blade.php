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
@endphp

<section
    class="relative py-20 lg:py-28 px-6 sm:px-10 lg:px-14 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900 overflow-hidden">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative">

        {{-- Section Header --}}
        @if ($heading)
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm tracking-wide font-semibold
                    bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                    border border-[#1363C6]/20 dark:border-[#1363C6]/30
                    shadow-sm shadow-[#1363C6]/10">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    OUR TEAM
                </span>

                <h2 class="text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight">
                    {{ $heading }}
                </h2>

                @if ($fields['content'])
                    <div class="text-[16px] leading-[26px] text-gray-600 dark:text-gray-400">
                        {!! $fields['content'] !!}
                    </div>
                @endif
            </div>
        @endif

        {{-- HIERARCHICAL GRID LAYOUT --}}
        @if ($layout === 'grid')
            <div class="space-y-12">
                @foreach (['executives' => 'Leadership', 'seniors' => 'Senior Team', 'others' => 'Team Members', 'juniors' => 'Interns & Trainees'] as $group => $title)
                    @if (isset($$group) && count($$group) > 0)
                        <div>
                            <div class="flex items-center justify-center gap-3 mb-8">
                                <div class="h-px flex-1 bg-gradient-to-r from-transparent to-[#1363C6]/30"></div>
                                <span
                                    class="text-[15px] font-semibold text-[#1363C6] dark:text-[#4a8dd8] uppercase tracking-wider">
                                    {{ $title }}
                                </span>
                                <div class="h-px flex-1 bg-gradient-to-l from-transparent to-[#1363C6]/30"></div>
                            </div>

                            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 max-w-4xl mx-auto">
                                @foreach ($$group as $member)
                                    <div
                                        class="group relative p-5 rounded-xl 
                                    bg-white dark:bg-gray-900
                                    border border-gray-100 dark:border-gray-800
                                    hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50
                                    hover:shadow-lg hover:shadow-[#1363C6]/5
                                    transition-all duration-300
                                    hover:-translate-y-0.5">

                                        {{-- Photo --}}
                                        @if (!empty($member->photo))
                                            <div class="mb-4 flex justify-center">
                                                <div
                                                    class="relative w-20 h-20 rounded-full p-0.5 
                                                bg-gradient-to-br from-[#1363C6] to-[#0d4a94]
                                                group-hover:scale-105 transition-transform duration-300">
                                                    <img src="{{ asset('storage/' . $member->photo) }}"
                                                        alt="{{ $member->name }}"
                                                        class="w-full h-full rounded-full object-cover border-2 border-white dark:border-gray-900">
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Name --}}
                                        @if (!empty($member->name))
                                            <h3
                                                class="text-[18px] font-semibold text-gray-900 dark:text-white mb-1 text-center
                                           group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors duration-300">
                                                {{ $member->name }}
                                            </h3>
                                        @endif

                                        {{-- Designation --}}
                                        @if (!empty($member->designation))
                                            <p
                                                class="text-[15px] text-gray-600 dark:text-gray-400 text-center line-clamp-1">
                                                {{ $member->designation }}
                                            </p>
                                        @endif

                                        {{-- Social Links --}}
                                        @if (!empty($member->social_links) && count($member->social_links) > 0)
                                            <div class="mt-2 flex justify-center gap-3">
                                                @foreach ($member->social_links as $link)
                                                    <a href="{{ $link['url'] ?? '#' }}" target="_blank"
                                                        class="text-gray-500 hover:text-[#1363C6] dark:hover:text-[#4a8dd8] transition-colors">
                                                        @if ($link['platform'] === 'facebook')
                                                            <i class="fab fa-facebook-f"></i>
                                                        @elseif ($link['platform'] === 'twitter')
                                                            <i class="fab fa-twitter"></i>
                                                        @elseif ($link['platform'] === 'linkedin')
                                                            <i class="fab fa-linkedin-in"></i>
                                                        @elseif ($link['platform'] === 'instagram')
                                                            <i class="fab fa-instagram"></i>
                                                        @else
                                                            <i class="fas fa-globe"></i>
                                                        @endif
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Decorative line --}}
                                        <div
                                            class="mt-3 h-0.5 w-0 group-hover:w-full bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                                        mx-auto rounded-full transition-all duration-500">
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
