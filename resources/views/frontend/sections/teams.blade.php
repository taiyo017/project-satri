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
    class="relative py-8 lg:py-12 px-6 sm:px-10 lg:px-14 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900 overflow-hidden">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative">

        {{-- Section Header --}}
        @if ($heading)
            <div class="text-center max-w-3xl mx-auto">
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

            </div>
            @if ($fields['content'])
                <div class="max-w-7xl mx-auto mb-8">
                    <div class="text-[16px] leading-[26px] text-gray-600 dark:text-gray-400 text-justify">
                        {!! $fields['content'] !!}
                    </div>
                </div>
            @endif
        @endif

        {{-- HIERARCHICAL GRID LAYOUT --}}
        @if ($layout === 'grid')
            <div class="space-y-16">
                @foreach (['executives' => 'Leadership', 'seniors' => 'Senior Team', 'others' => 'Team Members', 'juniors' => 'Interns & Trainees'] as $group => $title)
                    @if (isset($$group) && count($$group) > 0)
                        <div>
                            {{-- Section Title --}}
                            <div class="flex items-center justify-center gap-4 mb-10">
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

                            {{-- Team Grid --}}
                            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">
                                @foreach ($$group as $member)
                                    <div
                                        class="group relative bg-white dark:bg-gray-800 rounded-2xl overflow-hidden
                                        border border-gray-200 dark:border-gray-700
                                        hover:shadow-xl hover:shadow-[#1363C6]/10
                                        transition-all duration-300 hover:-translate-y-1">

                                        {{-- Photo Section --}}
                                        <div
                                            class="relative bg-gradient-to-br from-[#1363C6]/5 to-[#1363C6]/10 dark:from-[#1363C6]/10 dark:to-[#1363C6]/20 p-6 pb-8">
                                            @if (!empty($member->photo))
                                                <div class="relative w-32 h-32 mx-auto">
                                                    <div
                                                        class="absolute inset-0 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-full 
                                                        opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500">
                                                    </div>
                                                    <img src="{{ asset('storage/' . $member->photo) }}"
                                                        alt="{{ $member->name }}"
                                                        class="relative w-full h-full rounded-full object-cover 
                                                        border-4 border-white dark:border-gray-800 shadow-lg
                                                        group-hover:scale-105 transition-transform duration-300">
                                                </div>
                                            @else
                                                <div
                                                    class="relative w-32 h-32 mx-auto bg-gradient-to-br from-[#1363C6] to-[#0d4a94] 
                                                    rounded-full flex items-center justify-center shadow-lg
                                                    border-4 border-white dark:border-gray-800">
                                                    <span class="text-3xl font-bold text-white">
                                                        {{ substr($member->name ?? 'U', 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif

                                            {{-- Status Badge (Optional) --}}
                                            <div class="absolute top-4 right-4">
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold bg-[#1363C6] text-white rounded-full">
                                                    Active
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Info Section --}}
                                        <div class="p-5 text-center">
                                            {{-- Name --}}
                                            @if (!empty($member->name))
                                                <h3
                                                    class="text-lg font-bold text-gray-900 dark:text-white mb-1
                                                   group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] 
                                                   transition-colors duration-300">
                                                    {{ $member->name }}
                                                </h3>
                                            @endif

                                            {{-- Designation --}}
                                            @if (!empty($member->designation))
                                                <p
                                                    class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2 min-h-[2.5rem]">
                                                    {{ $member->designation }}
                                                </p>
                                            @endif

                                            {{-- Divider --}}
                                            <div
                                                class="w-12 h-0.5 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] mx-auto mb-4 rounded-full">
                                            </div>

                                            {{-- Social Links --}}
                                            @if (!empty($member->social_links) && count($member->social_links) > 0)
                                                <div class="flex items-center justify-center gap-2">
                                                    @foreach ($member->social_links as $link)
                                                        <a href="{{ $link['url'] ?? '#' }}" target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="w-9 h-9 flex items-center justify-center rounded-lg
                                                          bg-gray-100 dark:bg-gray-700 
                                                          text-gray-600 dark:text-gray-400
                                                          hover:bg-[#1363C6] hover:text-white
                                                          hover:scale-110 hover:shadow-lg
                                                          transition-all duration-300"
                                                            title="{{ ucfirst($link['platform'] ?? 'Link') }}">
                                                            @if ($link['platform'] === 'facebook')
                                                                <svg class="w-4 h-4" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                                </svg>
                                                            @elseif ($link['platform'] === 'twitter')
                                                                <svg class="w-4 h-4" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                                                </svg>
                                                            @elseif ($link['platform'] === 'linkedin')
                                                                <svg class="w-4 h-4" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                                                </svg>
                                                            @elseif ($link['platform'] === 'instagram')
                                                                <svg class="w-4 h-4" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                                                                </svg>
                                                            @elseif ($link['platform'] === 'github')
                                                                <svg class="w-4 h-4" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                                                </svg>
                                                            @else
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                                </svg>
                                                            @endif
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Hover Indicator --}}
                                        <div
                                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                                            transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left">
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
