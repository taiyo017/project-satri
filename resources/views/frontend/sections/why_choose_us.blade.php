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
@endphp

<section
    class="relative py-8 lg:py-12 px-6 sm:px-10 lg:px-14 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900">

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
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm tracking-wide font-semibold
                bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                border border-[#1363C6]/20 dark:border-[#1363C6]/30
                shadow-sm shadow-[#1363C6]/10">
                    {{ $subtitle }}
                </span>
            @endif
            {{-- Title --}}
            <h2 class="text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-2 leading-tight">
                {{ $title }}
            </h2>
            {{-- Description --}}
        </div>
        <div class="px-6 sm:px-10 md:px-16 pb-8">
            @if ($description)
                <div class="text-[16px] sm:text-[16px] leading-[28px] text-gray-600 dark:text-gray-400 text-justify">
                    {!! $description !!}
                </div>
            @endif
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center">

            {{-- LEFT SIDE – Features --}}
            <div class="space-y-4">

                @foreach ($features as $index => $feature)
                    <div
                        class="group flex gap-4 p-5 rounded-xl 
                        bg-white dark:bg-gray-900
                        border border-gray-100 dark:border-gray-800
                        hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50
                        hover:shadow-lg hover:shadow-[#1363C6]/5
                        transition-all duration-300 ease-out
                        hover:-translate-y-0.5">

                        {{-- Number Badge --}}
                        <div
                            class="w-11 h-11 rounded-lg flex items-center justify-center flex-shrink-0
                            bg-gradient-to-br from-[#1363C6] to-[#0d4a94] 
                            text-white font-bold text-[18px]
                            shadow-md shadow-[#1363C6]/20
                            group-hover:scale-105 group-hover:shadow-lg group-hover:shadow-[#1363C6]/30
                            transition-all duration-300">
                            {{ $index + 1 }}
                        </div>

                        {{-- Content --}}
                        <div class="flex-1">
                            <h3
                                class="text-[14px] font-semibold text-gray-900 dark:text-white mb-1.5 
                                group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8]
                                transition-colors duration-300">
                                {{ $feature['title'] }}
                            </h3>
                            <p class="text-[12px] leading-[24px] text-gray-600 dark:text-gray-400">
                                {{ $feature['content'] }}
                            </p>
                        </div>
                    </div>
                @endforeach

                {{-- Stats --}}
                <div class="grid grid-cols-2 gap-4 pt-3">

                    {{-- Internships --}}
                    <div
                        class="relative group text-center p-6 
                        bg-gradient-to-br from-white to-gray-50 
                        dark:from-gray-900 dark:to-gray-900/50
                        rounded-xl border border-gray-100 dark:border-gray-800
                        hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50
                        hover:shadow-lg hover:shadow-[#1363C6]/5
                        transition-all duration-300">
                        <div
                            class="text-[16px] font-extrabold text-[#1363C6] dark:text-[#4a8dd8] mb-1
                            group-hover:scale-105 transition-transform duration-300">
                            {{ $internships }}+
                        </div>
                        <p class="text-[12px] text-gray-600 dark:text-gray-400 font-medium">
                            Internships
                        </p>
                    </div>

                    {{-- Projects --}}
                    <div
                        class="relative group text-center p-6 
                        bg-gradient-to-br from-white to-gray-50 
                        dark:from-gray-900 dark:to-gray-900/50
                        rounded-xl border border-gray-100 dark:border-gray-800
                        hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50
                        hover:shadow-lg hover:shadow-[#1363C6]/5
                        transition-all duration-300">
                        <div
                            class="text-[18px] font-extrabold text-[#1363C6] dark:text-[#4a8dd8] mb-1
                            group-hover:scale-105 transition-transform duration-300">
                            {{ $projects }}+
                        </div>
                        <p class="text-[12px] text-gray-600 dark:text-gray-400 font-medium">
                            Projects Completed
                        </p>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE – Big Hero Image --}}
            <div class="relative lg:order-last order-first">
                @if ($image)
                    <div class="relative group max-w-md mx-auto lg:mx-0">
                        {{-- Image container --}}
                        <div
                            class="relative rounded-2xl overflow-hidden 
                            shadow-xl shadow-gray-900/10 dark:shadow-black/30">
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $title }}"
                                alt="{{ $title }}"
                                class="w-full h-[420px] object-cover 
                                group-hover:scale-105 transition-transform duration-700 ease-out">

                            {{-- Overlay gradient --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-[#1363C6]/10 to-transparent 
                                opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
