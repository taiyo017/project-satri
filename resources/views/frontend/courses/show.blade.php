@extends('frontend.layouts.app')

@section('title', $course->meta_title ?? $course->title)
@section('meta_description', $course->meta_description)
@section('meta_keywords', $course->meta_keywords)

@section('content')


    <section class="relative bg-gradient-to-br from-[#1363C6] via-[#1363C6] to-[#0d4a94] text-white overflow-hidden">

        {{-- Decorative elements --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16 relative z-10">

            {{-- Breadcrumb Navigation --}}
            <nav class="flex items-center flex-wrap gap-2 text-sm mb-8 sm:mb-10" aria-label="Breadcrumb">
                <a href="{{ route('frontend.page.show', 'home') }}"
                    class="flex items-center gap-1.5 text-white/70 hover:text-white transition-colors group">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Home</span>
                </a>

                <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>

                <a href="{{ route('frontend.page.show', 'our-courses') }}"
                    class="text-white/70 hover:text-white transition-colors">
                    Courses
                </a>

                <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>

                <span class="text-white font-medium">{{ Str::limit($course->title, 35) }}</span>
            </nav>

            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">

                {{-- Left Content --}}
                <div class="order-2 lg:order-1">
                    {{-- Category Badge --}}
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-xs sm:text-sm font-medium mb-4">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <span>{{ $course->category->name ?? 'Uncategorized' }}</span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-4">
                        {{ $course->title }}
                    </h1>

                    {{-- Description --}}
                    <p class="text-base sm:text-lg text-white/90 leading-relaxed mb-6 lg:mb-8">
                        {{ $course->short_description }}
                    </p>

                    {{-- Meta Info --}}
                    <div class="flex flex-wrap gap-4 sm:gap-6">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-white/60">Duration</p>
                                <p class="text-sm font-semibold">{{ $course->duration }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-white/60">Price</p>
                                <p class="text-sm font-semibold">NPR {{ number_format($course->price) }}</p>
                            </div>
                        </div>

                        @if (isset($course->level))
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-white/60">Level</p>
                                    <p class="text-sm font-semibold">{{ $course->level }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right Image --}}
                <div class="order-1 lg:order-2">
                    @if ($course->image_path)
                        <div class="relative group">
                            <div
                                class="absolute -inset-4 bg-white/20 rounded-3xl blur-2xl group-hover:bg-white/30 transition-all duration-500">
                            </div>
                            <img src="{{ asset('storage/' . $course->image_path) }}"
                                class="relative w-full h-64 sm:h-80 lg:h-96 object-cover rounded-2xl shadow-2xl"
                                alt="{{ $course->title }}">
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    <section class="py-12 sm:py-16 lg:py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8 lg:gap-12">

                {{-- LEFT CONTENT --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- ABOUT COURSE --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">About This Course</h2>
                        </div>
                        <div
                            class="prose prose-sm sm:prose-base dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                            {!! $course->description !!}
                        </div>
                    </div>


                    {{-- SYLLABUS SECTION --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Course Syllabus</h2>
                        </div>

                        @if ($syllabi->count())
                            <div class="space-y-4">
                                @foreach ($syllabi as $index => $item)
                                    <div
                                        class="group border border-gray-200 dark:border-gray-700 rounded-xl p-5 bg-gray-50 dark:bg-gray-700/50 hover:border-[#1363C6]/30 transition-all duration-300">
                                        <div class="flex items-start gap-3">
                                            {{-- Number Badge --}}
                                            <div
                                                class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>

                                            <div class="flex-1">
                                                <h4
                                                    class="font-semibold text-base sm:text-lg text-gray-900 dark:text-white mb-2">
                                                    {{ $item->title }}
                                                </h4>

                                                @if ($item->content)
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                                        {!! nl2br(e($item->content)) !!}
                                                    </p>
                                                @endif

                                                @if ($item->file_path)
                                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                                        class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] text-white text-sm rounded-lg shadow hover:shadow-lg hover:shadow-[#1363C6]/30 transition-all duration-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                            </path>
                                                        </svg>
                                                        <span>Download PDF</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">No syllabus added yet.</p>
                            </div>
                        @endif
                    </div>

                </div>


                {{-- RIGHT SIDEBAR --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">

                        {{-- ENROLL BOX --}}
                        <div
                            class="relative overflow-hidden bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-2xl shadow-xl">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                            <div class="relative p-6 sm:p-8">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-xl sm:text-2xl font-bold text-white">Enroll Now</h3>
                                </div>

                                <p class="text-gray-200 text-sm mb-6 leading-relaxed">
                                    Begin your hands-on learning journey today and gain practical skills.
                                </p>

                                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 mb-6">
                                    <p class="text-white/70 text-xs mb-1">Course Price</p>
                                    <p class="text-2xl sm:text-3xl font-bold text-white">
                                        NPR {{ number_format($course->price) }}
                                    </p>
                                </div>

                                <a href="{{ route('frontend.page.show', 'contact-us') }}"
                                    class="flex items-center justify-center gap-2 w-full py-3.5 bg-white text-[#1363C6] rounded-xl font-semibold text-sm hover:bg-gray-50 transition-all duration-300 hover:scale-105 shadow-lg">
                                    <span>Enroll Now</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- WHAT YOU'LL LEARN --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">What You'll Get</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-[#1363C6] flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Lifetime access to course
                                        materials</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-[#1363C6] flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Hands-on practical
                                        projects</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-[#1363C6] flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Certificate of completion</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-[#1363C6] flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Expert instructor support</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
