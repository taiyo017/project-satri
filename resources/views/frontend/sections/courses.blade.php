@props(['section', 'courses', 'fullPage' => null])

@php
    $currentSlug = request()->route()?->parameter('slug') ?? '';
    if (is_null($fullPage)) {
        $fullPage = $currentSlug === 'our-courses';
    }

    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    $title = $fields['title'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $content = $fields['content'] ?? '';
    $buttons = isset($fields['buttons']) ? json_decode($fields['buttons'], true) : [];

    // Fetch courses based on context
    if ($fullPage) {
        // Full page - show all courses
        $displayCourses = $courses;
    } else {
        // Homepage or other pages - fetch latest 4 courses
        $displayCourses = \App\Models\Course::where('status', true)->latest()->take(4)->get();
    }

    // Total count for "View All" button logic
    $totalCoursesCount = \App\Models\Course::where('status', true)->count();
@endphp

<section
    class="relative py-20 lg:py-28 px-6 sm:px-10 lg:px-14 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-950 overflow-hidden">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative">

        {{-- Section Header --}}
        @if ($title || $subtitle || $content)
            <div class="text-center max-w-3xl mx-auto mb-16">

                @if ($subtitle)
                    <span
                        class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm tracking-wide font-semibold
                        bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                        border border-[#1363C6]/20 dark:border-[#1363C6]/30
                        shadow-sm shadow-[#1363C6]/10">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                        {{ $subtitle }}
                    </span>
                @endif

                @if ($title)
                    <h2 class="text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight">
                        {{ $title }}
                    </h2>
                @endif

                @if ($content)
                    <div class="text-[16px] leading-[26px] text-gray-600 dark:text-gray-400">
                        {!! $content !!}
                    </div>
                @endif
            </div>
        @endif

        {{-- Courses Grid --}}
        @if ($displayCourses->count())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-12">
                @foreach ($displayCourses as $course)
                    <div
                        class="group bg-white dark:bg-gray-900 rounded-xl overflow-hidden 
                        border border-gray-100 dark:border-gray-800 
                        hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 
                        transition-all duration-300 
                        hover:shadow-lg hover:shadow-[#1363C6]/5 
                        hover:-translate-y-0.5">

                        {{-- Course Image --}}
                        <div
                            class="relative h-40 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 overflow-hidden">
                            @if ($course->image_path)
                                <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                                {{-- Overlay on hover --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-[#1363C6]/80 via-[#1363C6]/30 to-transparent 
                                    opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            {{-- Price Badge --}}
                            <div
                                class="absolute top-2.5 right-2.5 px-2.5 py-1 ml-2
                                bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm 
                                rounded-full shadow-md border border-gray-200 dark:border-gray-700">
                                <span
                                    class="text-[15px] font-bold bg-gradient-to-r from-[#1363C6] to-[#0d4a94] bg-clip-text text-transparent">
                                    NPR.{{ number_format($course->price) }}
                                </span>
                            </div>
                        </div>

                        {{-- Course Content --}}
                        <div class="p-4">
                            <h3
                                class="text-[18px] font-semibold text-gray-900 dark:text-white mb-1.5 
                                group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] 
                                transition-colors line-clamp-1">
                                {{ $course->title }}
                            </h3>

                            <p class="text-[15px] leading-[24px] text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                {{ $course->short_description }}
                            </p>

                            {{-- Course Meta Info --}}
                            <div
                                class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-100 dark:border-gray-800">
                                @if (isset($course->duration))
                                    <div class="flex items-center gap-1 text-[15px] text-gray-600 dark:text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $course->duration }}</span>
                                    </div>
                                @endif

                                @if (isset($course->level))
                                    <div class="flex items-center gap-1 text-[15px] text-gray-600 dark:text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span>{{ $course->level }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Action Button --}}
                            <a href="{{ route('course.show', $course->slug) }}"
                                class="flex items-center justify-center gap-2 w-full px-4 py-2 
                                bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                                text-white text-[15px] font-semibold rounded-lg 
                                hover:shadow-md hover:shadow-[#1363C6]/30 
                                transition-all duration-300 group/btn">
                                <span>View Course</span>
                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination for Full Page (Left Aligned) --}}
            @if ($fullPage && method_exists($courses, 'links'))
                <div class="mt-12">
                    {{ $courses->links() }}
                </div>
            @endif

            {{-- Custom Buttons (Homepage Only) --}}
            @if (!$fullPage)
                <div class="text-center mt-10 flex flex-wrap gap-4 justify-center">
                    <a href="{{ route('frontend.page.show', 'our-courses') }}"
                        class="group inline-flex items-center gap-3 px-8 py-3.5 
                        bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                        text-white font-semibold rounded-xl 
                        hover:shadow-xl hover:shadow-[#1363C6]/30 
                        transition-all duration-300 hover:scale-105 hover:from-[#0d4a94] hover:to-[#1363C6]">
                        <span>View Full Projects</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            @endif

            {{-- View All Courses Button (Homepage Only) --}}
            @if (!$fullPage && $totalCoursesCount > 4)
                <div class="text-center mt-10">
                    <a href="{{ route('frontend.page.show', 'our-courses') }}"
                        class="group inline-flex items-center gap-3 px-6 py-3 
                        bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                        text-white font-semibold rounded-lg 
                        hover:shadow-lg hover:shadow-[#1363C6]/30 
                        transition-all duration-300 hover:scale-105">
                        <span>View All Courses ({{ $totalCoursesCount }})</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="text-center py-20">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full mb-6">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <h3 class="text-[20px] font-bold text-gray-900 dark:text-white mb-2">No Courses Yet</h3>
                <p class="text-[16px] text-gray-600 dark:text-gray-400">Check back soon for exciting courses!</p>
            </div>
        @endif

    </div>
</section>
