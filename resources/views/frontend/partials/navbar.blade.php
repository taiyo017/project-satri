@php
    $setting = \App\Models\Setting::first();
    $currentSlug = request()->route('slug') ?? '';

    // Navigation structure
    $navItems = [
        'home' => [
            'route' => 'frontend.home',
            'label' => 'Home',
            'icon' =>
                'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        ],
        'about' => [
            'label' => 'About',
            'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'dropdown' => [
                ['slug' => 'about-us', 'label' => 'About Company'],
                ['slug' => 'team', 'label' => 'Our Team'],
                ['slug' => 'interns', 'label' => 'Our Interns'],
                ['slug' => 'our-projects', 'label' => 'Products'],
            ],
        ],
        'courses' => [
            'route' => 'frontend.page.show',
            'label' => 'Courses',
            'icon' =>
                'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        ],
        'services' => [
            'route' => 'frontend.page.show',
            'label' => 'Services',
            'icon' =>
                'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        ],
        'gallery' => [
            'route' => 'frontend.page.show',
            'label' => 'Gallery',
            'icon' =>
                'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
        ],
        'contact-us' => [
            'route' => 'frontend.page.show',
            'label' => 'Contact',
            'icon' =>
                'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        ],
    ];

    // Helper functions
    $isActive = fn($slug) => $currentSlug === $slug;
    $aboutSlugs = array_column($navItems['about']['dropdown'], 'slug');
    $isAboutActive = in_array($currentSlug, $aboutSlugs);
    $getRoute = fn($item, $slug = null) => $slug ? route($item['route'], $slug) : route($item['route']);
@endphp

<style>
    [x-cloak] {
        display: none !important;
    }

    .nav-active-indicator {
        position: absolute;
        bottom: 0.25rem;
        left: 40%;
        transform: translateX(-50%);
        width: 1.5rem;
        height: 2px;
        background: white;
        border-radius: 9999px;
    }
</style>

<nav x-data="{ isMobileMenuOpen: false, activeDropdown: null }" @click.away="activeDropdown = null"
    class="sticky top-0 z-50 bg-[#1363C6] dark:bg-gray-800 backdrop-blur-md shadow-lg transition-all duration-300">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('frontend.home') }}" class="flex items-center gap-3 group flex-shrink-0" aria-label="Home">
                @if ($setting?->show_logo && $setting?->logo_path)
                    {{-- Show Logo --}}
                    <img src="{{ asset('storage/' . $setting->logo_path) }}"
                        class="h-8 w-auto transition-transform duration-300 group-hover:scale-105 drop-shadow-lg"
                        alt="{{ $setting->site_name ?? 'Logo' }}">
                @else
                    {{-- Show Site Name --}}
                    <div class=" items-center">
                        <span class="text-white font-bold text-lg tracking-tight">
                            {{ $setting->site_name ?? 'Satri Technologies' }}
                        </span>
                    </div>
                @endif
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden lg:flex items-center space-x-1 flex-1 justify-center">
                @foreach ($navItems as $key => $item)
                    @if (isset($item['dropdown']))
                        {{-- Dropdown Menu --}}
                        <div class="relative" @mouseenter="activeDropdown = '{{ $key }}'"
                            @mouseleave="activeDropdown = null">
                            <a class=" flex flex-col text-gray-100 text-sm font-medium px-4 py-2">
                                <div class="flex gap-1">
                                    <span>{{ $item['label'] }}</span>
                                    <svg :class="{ 'rotate-180': activeDropdown === '{{ $key }}' }"
                                        class="w-4 h-4 transition-transform duration-200" fill="none"
                                        stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                                @if ($isAboutActive && $key === 'about')
                                    <div class="h-0.5 w-7 bg-white"></div>
                                @endif
                            </a>

                            <div x-show="activeDropdown === '{{ $key }}'"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2" x-cloak
                                class="absolute left-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                                <div class="py-2">
                                    @foreach ($item['dropdown'] as $page)
                                        <a href="{{ route('frontend.page.show', $page['slug']) }}"
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-[#1363C6]/10 hover:text-[#1363C6] dark:hover:text-[#1363C6] transition-all duration-200 {{ $isActive($page['slug']) ? 'font-bold' : '' }}">
                                            <span>{{ $page['label'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Regular Link --}}
                        <a href="{{ $getRoute($item, $key === 'home' ? null : $key) }}"
                            class="relative px-4 py-2 rounded-lg text-sm font-medium text-white transition-all duration-200 {{ $isActive($key) ? '' : '' }}">
                            {{ $item['label'] }}
                            @if ($isActive($key))
                                <div class="h-0.5 w-7 bg-white"></div>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Right Section --}}
            <div class="flex items-center gap-2">
                {{-- App Store Button - Desktop & Tablet --}}
                <a href="{{ route('frontend.apps.index') }}"
                    class="group inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-sm transition-all duration-300 hover:scale-105 active:scale-95 border border-white/20 hover:border-white/30"
                    aria-label="App Store">
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                    </svg>
                    <span class="hidden sm:inline text-sm font-semibold">Apps</span>
                </a>

                {{-- Dark Mode Toggle --}}
                <button @click.prevent="darkMode = !darkMode"
                    class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white backdrop-blur-sm transition-all duration-200 hover:bg-white/20 hover:scale-105 active:scale-95 border border-white/20"
                    aria-label="Toggle dark mode">
                    <svg class="hidden dark:block w-5 h-5 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg class="dark:hidden w-5 h-5 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                {{-- Mobile Menu Toggle --}}
                <button @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="lg:hidden relative flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white backdrop-blur-sm transition-all duration-200 hover:bg-white/20 hover:scale-105 active:scale-95 border border-white/20"
                    aria-label="Toggle mobile menu" :aria-expanded="isMobileMenuOpen.toString()">
                    <svg x-show="!isMobileMenuOpen" class="h-6 w-6 transition-all duration-200" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="isMobileMenuOpen" class="h-6 w-6 transition-all duration-200" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
            @foreach ($navItems as $key => $item)
                @if (isset($item['dropdown']))
                    {{-- Mobile Dropdown --}}
                    <div x-data="{ open: {{ $isAboutActive ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center px-4 py-3 text-sm font-medium rounded-xl text-gray-800 dark:text-gray-200 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200 group {{ $isAboutActive ? 'bg-[#1363C6]/10 text-[#1363C6]' : '' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 opacity-60 group-hover:opacity-100 transition-opacity"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $item['icon'] }}" />
                                </svg>
                                <span>{{ $item['label'] }}</span>
                            </div>
                            <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-200"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="pl-6 space-y-1">
                            @foreach ($item['dropdown'] as $page)
                                <a href="{{ route('frontend.page.show', $page['slug']) }}"
                                    @click="isMobileMenuOpen = false"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200 {{ $isActive($page['slug']) ? 'bg-[#1363C6]/5 text-[#1363C6] font-medium' : '' }}">
                                    <div class="w-2 h-2 rounded-full bg-[#1363C6]/40"></div>
                                    <span>{{ $page['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Mobile Regular Link --}}
                    <a href="{{ $getRoute($item, $key === 'home' ? null : $key) }}" @click="isMobileMenuOpen = false"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-800 dark:text-gray-200 hover:bg-[#1363C6]/10 hover:text-[#1363C6] transition-all duration-200 group {{ $isActive($key) ? 'bg-[#1363C6]/10 text-[#1363C6]' : '' }}">
                        <svg class="w-5 h-5 opacity-60 group-hover:opacity-100 transition-opacity" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $item['icon'] }}" />
                        </svg>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</nav>
