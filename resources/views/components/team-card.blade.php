@props(['title', 'members' => collect(), 'groupKey' => ''])
<div>
    <div class="team-section-title flex items-center justify-center gap-4 mb-10 opacity-0"
        data-section="{{ $groupKey }}">
        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-[#1363C6]/20 to-[#1363C6]/40">
        </div>
        <h2 class="text-lg font-bold text-gray-900 dark:text-white uppercase tracking-wide">
            {{ $title }}
        </h2>
        <div class="h-px flex-1 bg-gradient-to-l from-transparent via-[#1363C6]/20 to-[#1363C6]/40">
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">
        @foreach ($members as $index => $member)
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
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}"
                                class="relative w-full h-full rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @else
                        <div
                            class="relative w-32 h-32 mx-auto bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-full flex items-center justify-center shadow-lg border-4 border-white dark:border-gray-800">
                            <span class="text-3xl font-bold text-white">{{ substr($member->name ?? 'U', 0, 1) }}</span>
                        </div>
                    @endif
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
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 line-clamp-2 min-h-[2.5rem]">
                            {{ $member->designation }}
                        </p>
                    @endif

                    <div class="w-12 h-0.5 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] mx-auto mb-4 rounded-full">
                    </div>

                    @if (!empty($member->social_links) && count($member->social_links) > 0)
                        <div class="flex items-center justify-center gap-2">
                            @foreach ($member->social_links as $link)
                                <a href="{{ $link['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                    onclick="event.stopPropagation()"
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
