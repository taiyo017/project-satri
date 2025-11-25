@extends('frontend.layouts.app')

@section('content')
    {{-- Hero Section  --}}
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

                <a href="{{ route('frontend.page.show', 'career') }}"
                    class="text-white/70 hover:text-white transition-colors">
                    Careers
                </a>

                <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>

                <span class="text-white font-medium">{{ Str::limit($career->title, 35) }}</span>
            </nav>

            {{-- Hero Content --}}
            <div class="max-w-4xl">
                {{-- Status Badges --}}
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ ucwords(str_replace('-', ' ', $career->job_type)) }}
                    </span>

                    @if ($career->deadline->isPast())
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-500/90 backdrop-blur-sm rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Applications Closed
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/90 backdrop-blur-sm rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Now Hiring
                        </span>
                    @endif
                </div>

                {{-- Title --}}
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-6">
                    {{ $career->title }}
                </h1>

                {{-- Meta Info --}}
                <div class="flex flex-wrap gap-6">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-white/60">Location</p>
                            <p class="text-sm font-semibold">{{ $career->location }}</p>
                        </div>
                    </div>

                    @if ($career->salary_range)
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-white/60">Salary</p>
                                <p class="text-sm font-semibold">{{ $career->salary_range }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-white/60">Deadline</p>
                            <p class="text-sm font-semibold">{{ $career->deadline->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content Section --}}
    <section class="relative py-12 md:py-16 lg:py-20 bg-gray-50 dark:bg-gray-900" x-data="{ showApplyForm: false }"
        id="job-detail-page">

        {{-- Decorative Background Elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="lg:grid lg:grid-cols-12 lg:gap-8">

                {{-- Column 1: Job Description (8/12 width) --}}
                <div class="lg:col-span-8">

                    {{-- Main Content Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">

                        {{-- Job Description Content --}}
                        <div class="p-6 md:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Job Description
                                </h2>
                            </div>
                            <div
                                class="prose prose-sm sm:prose-base dark:prose-invert max-w-none prose-headings:text-gray-900 dark:prose-headings:text-white prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-a:text-[#1363C6] dark:prose-a:text-blue-400 prose-strong:text-gray-900 dark:prose-strong:text-white prose-ul:text-gray-700 dark:prose-ul:text-gray-300">
                                {!! $career->description !!}
                            </div>
                        </div>
                    </div>

                    {{-- Back Button --}}
                    <div class="mb-8">
                        <a href="{{ route('frontend.page.show', 'career') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to All Jobs
                        </a>
                    </div>
                </div>

                {{-- Column 2: Sticky Sidebar (4/12 width) --}}
                <div class="lg:col-span-4 mt-8 lg:mt-0">
                    <div class="lg:sticky lg:top-6 space-y-6">

                        {{-- Quick Overview Card --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div
                                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-[#1363C6]/5 to-transparent">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#1363C6] dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Quick Overview
                                </h3>
                            </div>
                            <div class="p-6">
                                <dl class="space-y-4">
                                    <div
                                        class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                                        <dt
                                            class="text-sm font-medium text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Job Type
                                        </dt>
                                        <dd class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ ucwords(str_replace('-', ' ', $career->job_type)) }}
                                        </dd>
                                    </div>

                                    <div
                                        class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                                        <dt
                                            class="text-sm font-medium text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Location
                                        </dt>
                                        <dd class="text-sm font-bold text-gray-900 dark:text-white text-right">
                                            {{ $career->location }}
                                        </dd>
                                    </div>

                                    @if ($career->salary_range)
                                        <div
                                            class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                                            <dt
                                                class="text-sm font-medium text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Salary
                                            </dt>
                                            <dd class="text-sm font-bold text-gray-900 dark:text-white text-right">
                                                {{ $career->salary_range }}
                                            </dd>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between py-3">
                                        <dt
                                            class="text-sm font-medium text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Posted On
                                        </dt>
                                        <dd class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $career->created_at->format('M d, Y') }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        {{-- Apply Button Card --}}
                        @if ($career->deadline->isFuture())
                            <div class="relative overflow-hidden bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-2xl shadow-xl"
                                x-show="!showApplyForm">
                                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                                <div class="relative p-6">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div
                                            class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-lg text-white">Ready to Apply?</p>
                                            <p class="text-white/80 text-sm">Join our team today!</p>
                                        </div>
                                    </div>
                                    <button
                                        @click="showApplyForm = true; $nextTick(() => document.getElementById('apply-form').scrollIntoView({ behavior: 'smooth', block: 'start' }));"
                                        class="w-full px-6 py-3.5 bg-white text-[#1363C6] font-bold text-base rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 group">
                                        Apply Now
                                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </button>
                                    <p class="text-white/70 text-xs text-center mt-3">
                                        Application closes {{ $career->deadline->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <div
                                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-2 border-red-200 dark:border-red-900/50 overflow-hidden">
                                <div class="p-6 text-center">
                                    <div
                                        class="w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Applications Closed
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        The application deadline for this position has passed.
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Share Card --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="p-6">
                                <h4
                                    class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    Share this Job
                                </h4>
                                <div class="flex gap-2">
                                    <button
                                        onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank', 'width=600,height=400')"
                                        class="flex-1 p-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                                        title="Share on Facebook">
                                        <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                        </svg>
                                    </button>
                                    <button
                                        onclick="window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent('{{ $career->title }}'), '_blank', 'width=600,height=400')"
                                        class="flex-1 p-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors"
                                        title="Share on Twitter">
                                        <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                        </svg>
                                    </button>
                                    <button
                                        onclick="window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(window.location.href), '_blank', 'width=600,height=400')"
                                        class="flex-1 p-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg transition-colors"
                                        title="Share on LinkedIn">
                                        <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                        </svg>
                                    </button>
                                    <button
                                        onclick="navigator.clipboard.writeText(window.location.href).then(() => { alert('Link copied to clipboard!'); })"
                                        class="flex-1 p-2.5 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors"
                                        title="Copy Link">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Application Form Section (Hidden by default) --}}
            <div id="apply-form" class="mt-16 scroll-mt-20" x-show="showApplyForm"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform translate-y-8"
                x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak>

                <div class="max-w-4xl mx-auto">
                    {{-- Application Header --}}
                    <div class="text-center mb-8">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-2xl mb-4 shadow-lg shadow-[#1363C6]/20">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                            Submit Your Application
                        </h2>
                        <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                            Complete the form below to apply for <span
                                class="font-semibold text-gray-900 dark:text-white">{{ $career->title }}</span>
                        </p>
                    </div>

                    {{-- Include the Apply Form Component --}}
                    @include('frontend.careers.apply-form', ['career' => $career])

                    {{-- Close Form Button --}}
                    <div class="mt-8 text-center">
                        <button @click="showApplyForm = false; window.scrollTo({ top: 0, behavior: 'smooth' })"
                            class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel Application
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- Sticky Mobile Apply Button --}}
        @if ($career->deadline->isFuture())
            <div class="fixed bottom-0 left-0 right-0 p-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 lg:hidden z-50 shadow-2xl"
                x-show="!showApplyForm" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-full"
                x-transition:enter-end="opacity-100 transform translate-y-0">
                <button
                    @click="showApplyForm = true; $nextTick(() => document.getElementById('apply-form').scrollIntoView({ behavior: 'smooth', block: 'start' }));"
                    class="w-full px-6 py-4 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] text-white font-bold text-base rounded-xl shadow-lg hover:shadow-xl active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    Apply for this Position
                </button>
            </div>
        @endif
    </section>
@endsection

@push('styles')
    <style>
        /* Enhanced prose styling for job description */
        .prose h2 {
            @apply mt-8 mb-4 text-xl sm:text-2xl;
        }

        .prose h3 {
            @apply mt-6 mb-3 text-lg sm:text-xl;
        }

        .prose ul,
        .prose ol {
            @apply my-4 space-y-2;
        }

        .prose li {
            @apply leading-relaxed;
        }

        .prose strong {
            @apply font-semibold;
        }

        .prose a {
            @apply underline hover:no-underline;
        }

        /* Custom scrollbar for webkit browsers */
        .prose::-webkit-scrollbar {
            width: 8px;
        }

        .prose::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-800;
        }

        .prose::-webkit-scrollbar-thumb {
            @apply bg-gray-300 dark:bg-gray-600 rounded-full;
        }

        .prose::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-400 dark:bg-gray-500;
        }
    </style>
@endpush
