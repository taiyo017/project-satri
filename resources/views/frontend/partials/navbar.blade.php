@php
    $setting = \App\Models\Setting::first();
    $pages = \App\Models\Page::where('status', 'published')->orderBy('title', 'asc')->get();
    $currentRoute = Route::currentRouteName();
@endphp

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<nav x-data="{
    isMobileMenuOpen: false,
    isAboutOpen: false,
    activeDropdown: null
}" @click.away="activeDropdown = null"
    class="sticky top-0 z-50 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] backdrop-blur-md dark:bg-gray-900 shadow-lg transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('frontend.home') }}" class="flex items-center gap-3 group">
                @if ($setting?->logo_path)
                    <img src="{{ asset('storage/' . $setting->logo_path) }}"
                        class="h-8 w-auto transition-all duration-300 group-hover:scale-105 drop-shadow-lg"
                        alt="{{ $setting->site_name ?? 'Logo' }}">
                @else
                    <div
                        class="h-10 w-10 bg-white rounded-xl flex items-center justify-center text-[#1363C6] font-bold text-lg shadow-lg transition-all duration-300 group-hover:scale-105 group-hover:rotate-3">
                        {{ substr($setting->site_name ?? 'ST', 0, 2) }}
                    </div>
                @endif
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden lg:flex items-center space-x-1">
                {{-- Home --}}
                <a href="{{ route('frontend.home') }}"
                    class="relative px-4 py-2 rounded-lg text-sm text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('frontend.page.show') && request()->route('slug') == 'home' ? 'bg-white/20' : '' }}">
                    Home
                    @if (request()->routeIs('frontend.page.show') && request()->route('slug') == 'home')
                        <span
                            class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-white rounded-full"></span>
                    @endif
                </a>

                {{-- About Dropdown --}}
                @php
                    // List all slugs that belong to the About dropdown
                    $aboutSlugs = ['about-us', 'team', 'our-projects'];

                    // Get the current route slug, safely
                    $currentSlug = request()->route('slug') ?? '';

                    // Check if the current page is any of the About pages
                    $isAboutActive = in_array($currentSlug, $aboutSlugs);
                @endphp

                {{-- About Dropdown --}}
                <div class="relative" @mouseenter="activeDropdown = 'about'" @mouseleave="activeDropdown = null">
                    <button
                        class="px-4 py-2 rounded-lg text-sm text-white hover:bg-white/10 transition-all duration-200 flex items-center gap-1.5 {{ $isAboutActive ? 'bg-white/20' : '' }}">
                        <span>About</span>
                        <svg :class="{ 'rotate-180': activeDropdown === 'about' }"
                            class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor"
                            stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="activeDropdown === 'about'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2" x-cloak
                        class="absolute left-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="py-2">
                            <a href="{{ route('frontend.page.show', 'about-us') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-gray-700 dark:text-gray-300 hover:bg-[#1363C6]/10 hover:text-[#1363C6] dark:hover:text-[#1363C6] transition-all duration-200 {{ $currentSlug == 'about-us' ? 'bg-[#1363C6]/10 text-[#1363C6] dark:text-[#1363C6]' : '' }}">
                                <span class="text-sm">About Company</span>
                            </a>

                            <a href="{{ route('frontend.page.show', 'team') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-gray-700 dark:text-gray-300 hover:bg-[#1363C6]/10 hover:text-[#1363C6] dark:hover:text-[#1363C6] transition-all duration-200 {{ $currentSlug == 'team' ? 'bg-[#1363C6]/10 text-[#1363C6] dark:text-[#1363C6]' : '' }}">
                                <span class="text-sm">Our Team</span>
                            </a>

                            <a href="{{ route('frontend.page.show', 'our-projects') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-gray-700 dark:text-gray-300 hover:bg-[#1363C6]/10 hover:text-[#1363C6] dark:hover:text-[#1363C6] transition-all duration-200 {{ $currentSlug == 'our-projects' ? 'bg-[#1363C6]/10 text-[#1363C6] dark:text-[#1363C6]' : '' }}">
                                <span class="text-sm">Products</span>
                            </a>
                        </div>
                    </div>
                </div>




                {{-- Courses --}}
                <a href="{{ route('frontend.page.show', 'our-courses') }}"
                    class="relative px-4 py-2 rounded-lg text-sm text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('frontend.page.show') && request()->route('slug') == 'our-courses' ? 'bg-white/20' : '' }}">
                    Courses
                    @if (request()->routeIs('frontend.page.show') && request()->route('slug') == 'our-courses')
                        <span
                            class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-white rounded-full"></span>
                    @endif
                </a>

                {{-- Careers --}}
                <a href="{{ route('frontend.page.show', 'career') }}"
                    class="relative px-4 py-2 rounded-lg text-sm text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('frontend.page.show') && request()->route('slug') == 'career' ? 'bg-white/20' : '' }}">
                    Careers
                    @if (request()->routeIs('frontend.page.show') && request()->route('slug') == 'career')
                        <span
                            class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-white rounded-full"></span>
                    @endif
                </a>

                {{-- Careers --}}
                <a href="{{ route('frontend.page.show', 'gallery') }}"
                    class="relative px-4 py-2 rounded-lg text-sm text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('frontend.page.show') && request()->route('slug') == 'gallery' ? 'bg-white/20' : '' }}">
                    Our Gallery
                    @if (request()->routeIs('frontend.page.show') && request()->route('slug') == 'gallery')
                        <span
                            class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-white rounded-full"></span>
                    @endif
                </a>



                {{-- Contact --}}
                <a href="{{ route('frontend.page.show', 'contact-us') }}"
                    class="relative px-4 py-2 rounded-lg text-sm text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('frontend.page.show') && request()->route('slug') == 'contact-us' ? 'bg-white/20' : '' }}">
                    Contact
                    @if (request()->routeIs('frontend.page.show') && request()->route('slug') == 'contact-us')
                        <span
                            class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-white rounded-full"></span>
                    @endif
                </a>
            </div>

            {{-- Right: Dark Mode + Mobile Menu --}}
            <div class="flex items-center gap-3">
                {{-- Dark Mode Toggle --}}
                <button @click.prevent="darkMode = !darkMode"
                    class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white backdrop-blur-sm transition-all duration-200 hover:bg-white/20 hover:scale-105 active:scale-95"
                    title="Toggle Dark Mode">
                    {{-- Sun Icon (Light Mode) --}}
                    <svg class="hidden dark:block w-5 h-5 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    {{-- Moon Icon (Dark Mode) --}}
                    <svg class="dark:hidden w-5 h-5 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                {{-- Mobile Menu Button --}}
                <button @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="lg:hidden relative flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white backdrop-blur-sm transition-all duration-200 hover:bg-white/20 hover:scale-105 active:scale-95">
                    <svg x-show="!isMobileMenuOpen" class="h-6 w-6 transition-all duration-200" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="isMobileMenuOpen" class="h-6 w-6 transition-all duration-200" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" x-cloak
        class="lg:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 shadow-2xl">
        <div class="px-4 py-4 space-y-1 max-h-[calc(100vh-4rem)] overflow-y-auto">
            {{-- Home --}}
            <a href="{{ route('frontend.home') }}" @click="isMobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl text-gray-800 dark:text-gray-200 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200 group {{ request()->routeIs('frontend.home') ? 'bg-[#1363C6]/10 text-[#1363C6]' : '' }}">
                <svg class="w-5 h-5 opacity-60 group-hover:opacity-100 transition-opacity" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>

            {{-- Mobile About Dropdown --}}
            <div x-data="{ open: false }" class="space-y-1">
                <button @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-3 text-sm rounded-xl text-gray-800 dark:text-gray-200 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200 group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 opacity-60 group-hover:opacity-100 transition-opacity" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>About</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-200"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                {{-- Submenu --}}
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="pl-6 space-y-1">
                    <a href="{{ route('frontend.page.show', 'about-us') }}" @click="isMobileMenuOpen = false"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200">
                        <div class="w-2 h-2 rounded-full bg-[#1363C6]/40"></div>
                        About Company
                    </a>
                    <a href="{{ route('frontend.page.show', 'team') }}" @click="isMobileMenuOpen = false"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200">
                        <div class="w-2 h-2 rounded-full bg-[#1363C6]/40"></div>
                        Our Team
                    </a>
                    <a href="{{ route('frontend.page.show', 'our-projects') }}" @click="isMobileMenuOpen = false"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200">
                        <div class="w-2 h-2 rounded-full bg-[#1363C6]/40"></div>
                        Products
                    </a>
                </div>
            </div>

            {{-- Courses --}}
            <a href="{{ route('frontend.page.show', 'our-courses') }}" @click="isMobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl text-gray-800 dark:text-gray-200 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200 group {{ request()->routeIs('frontend.page.show') && request()->route('slug') == 'our-courses' ? 'bg-[#1363C6]/10 text-[#1363C6]' : '' }}">
                <svg class="w-5 h-5 opacity-60 group-hover:opacity-100 transition-opacity" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Courses
            </a>

            {{-- Careers --}}
            <a href="{{ route('frontend.page.show', 'career') }}" @click="isMobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl text-gray-800 dark:text-gray-200 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200 group {{ request()->routeIs('frontend.page.show') && request()->route('slug') == 'career' ? 'bg-[#1363C6]/10 text-[#1363C6]' : '' }}">
                <svg class="w-5 h-5 opacity-60 group-hover:opacity-100 transition-opacity" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Careers
            </a>
            {{-- Gallery --}}
            <a href="{{ route('frontend.page.show', 'gallery') }}" @click="isMobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl text-gray-800 dark:text-gray-200 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200 group {{ request()->routeIs('frontend.page.show') && request()->route('slug') == 'career' ? 'bg-[#1363C6]/10 text-[#1363C6]' : '' }}">
                <svg class="w-5 h-5 opacity-60 group-hover:opacity-100 transition-opacity" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Our Gallery
            </a>

            {{-- Contact --}}
            <a href="{{ route('frontend.page.show', 'contact-us') }}" @click="isMobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl text-gray-800 dark:text-gray-200 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200 group {{ request()->routeIs('frontend.page.show') && request()->route('slug') == 'contact-us' ? 'bg-[#1363C6]/10 text-[#1363C6]' : '' }}">
                <svg class="w-5 h-5 opacity-60 group-hover:opacity-100 transition-opacity" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Contact
            </a>
        </div>
    </div>
</nav>
