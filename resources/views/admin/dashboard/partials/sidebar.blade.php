@php
    $setting = \App\Models\Setting::first();

    $menuItems = [
        [
            'title' => 'Dashboard',
            'route' => 'dashboard',
            'routePattern' => 'dashboard',
            'icon' => 'grid',
            'subItems' => [],
        ],
        [
            'title' => 'Pages',
            'routePattern' => 'pages.*',
            'icon' => 'pages',
            'subItems' => [
                ['title' => 'All Pages', 'route' => 'pages.index'],
                ['title' => 'Add New Page', 'route' => 'pages.create'],
            ],
        ],
        [
            'title' => 'Services',
            'routePattern' => 'services.*',
            'icon' => 'services',
            'subItems' => [
                ['title' => 'All Services', 'route' => 'services.index'],
                ['title' => 'Add New Service', 'route' => 'services.create'],
            ],
        ],
        [
            'title' => 'Projects',
            'routePattern' => 'projects.*',
            'icon' => 'projects',
            'subItems' => [
                ['title' => 'All Projects', 'route' => 'projects.index'],
                ['title' => 'Add New Project', 'route' => 'projects.create'],
            ],
        ],
        // [
        //     'title' => 'Blogs',
        //     'routePattern' => 'blogs.*',
        //     'icon' => 'blogs',
        //     'subItems' => [
        //         ['title' => 'All Blogs', 'route' => null],
        //         ['title' => 'Add New Blog', 'route' => null],
        //         ['title' => 'Categories', 'route' => null],
        //     ],
        // ],
        [
            'title' => 'Courses',
            'routePattern' => ['courses.*', 'course-categories.*'],
            'icon' => 'courses',
            'subItems' => [
                ['title' => 'All Courses', 'route' => 'courses.index'],
                ['title' => 'Categories', 'route' => 'course-categories.index'],
            ],
        ],
        [
            'title' => 'Team',
            'route' => null,
            'routePattern' => 'team-members.*',
            'icon' => 'team',
            'subItems' => [
                [
                    'title' => 'All Team Members',
                    'route' => 'team-members.index',
                ],
                [
                    'title' => 'Add Team Member',
                    'route' => 'team-members.create',
                ],
            ],
        ],
        [
            'title' => 'Gallery',
            'route' => null,
            'routePattern' => ['galleries.*', 'gallery-categories.*'],
            'icon' => 'gallery',
            'subItems' => [
                [
                    'title' => 'Gallery',
                    'route' => 'galleries.index',
                ],
                [
                    'title' => 'Gallery Category',
                    'route' => 'gallery-categories.index',
                ],
            ],
        ],
        [
            'title' => 'FAQs',
            'route' => null,
            'routePattern' => 'faqs.*',
            'icon' => 'team',
            'subItems' => [
                [
                    'title' => 'FAQs',
                    'route' => 'faqs.index',
                ],
                [
                    'title' => 'Add FAQ',
                    'route' => 'faqs.create',
                ],
            ],
        ],
        [
            'title' => 'Testimonials',
            'route' => 'testimonials.index',
            'routePattern' => 'testimonials.*',
            'icon' => 'testimonials',
            'subItems' => [],
        ],
        [
            'title' => 'Contacts',
            'route' => 'contacts.index',
            'routePattern' => 'contacts.*',
            'icon' => 'contact',
            'subItems' => [],
        ],
        [
            'title' => 'Careers',
            'routePattern' => ['careers.*', 'job-categories.*'],
            'icon' => 'careers',
            'subItems' => [
                ['title' => 'Job Posts', 'route' => 'careers.index'],
                ['title' => 'Create Job Post', 'route' => 'careers.create'],
                ['title' => 'Add Job Category', 'route' => 'job-categories.index'],
            ],
        ],
        [
            'title' => 'Settings',
            'routePattern' => 'settings.*',
            'icon' => 'settings',
            'subItems' => [
                ['title' => 'Site Configurations', 'route' => 'settings.index'],
                ['title' => 'My Profile', 'route' => 'profile.edit'],
            ],
        ],
    ];
@endphp

<aside x-data="sidebarMenu()"
    :class="[
        sidebarToggle ? 'translate-x-0 lg:w-[60px]' : '-translate-x-full',
        'sidebar fixed top-0 left-0 z-50 flex h-screen w-[255.2px] flex-col overflow-hidden',
        'bg-gradient-to-b from-[#1363C6] via-[#1056b0] to-[#0d4a99]',
        'dark:bg-gradient-to-b dark:from-gray-900 dark:via-gray-900 dark:to-gray-950',
        'lg:static lg:translate-x-0 transition-all duration-300 ease-in-out',
        'shadow-xl shadow-blue-500/10 dark:shadow-none'
    ]"
    @keydown.window.escape="closeAll()" x-init="init()">
    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent pointer-events-none"></div>
    <div :class="sidebarToggle ? 'justify-center px-2' : 'justify-between px-5'"
        class="sidebar-header flex items-center w-full pt-6 pb-5 relative z-10 border-b border-white/10 dark:border-gray-800">
        <a href="{{ route('dashboard') }}" class="flex items-center transition-transform hover:scale-105 duration-200">
            @php
                $logoPath = !empty($setting->logo_path)
                    ? asset('storage/' . $setting->logo_path)
                    : asset('default-logo.png');
            @endphp

            <span class="logo" :class="sidebarToggle ? 'hidden' : 'block'">
                <img class="h-8 w-auto dark:hidden" src="{{ $logoPath }}" alt="{{ config('app.name') }}" />
                <img class="h-8 w-auto hidden dark:block" src="{{ $logoPath }}" alt="{{ config('app.name') }}" />
            </span>

            <img class="logo-icon h-8 w-8 object-contain" :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="{{ $logoPath }}" alt="{{ config('app.name') }}" />
        </a>

    </div>

    <!-- Sidebar Menu -->
    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear flex-1 relative z-10"
        :class="sidebarToggle ? 'px-2' : 'px-4'">
        <nav class="flex flex-col py-4">

            <!-- Main Menu Group -->
            <div>
                <h3 class="mb-3 text-[10px] leading-[20px] uppercase font-bold tracking-wider text-white/60 dark:text-gray-500"
                    :class="sidebarToggle ? 'lg:hidden' : 'block'">
                    <span>Menu</span>
                </h3>

                <ul class="flex flex-col gap-1.5">
                    @foreach ($menuItems as $item)
                        @php
                            $itemSlug = Str::slug($item['title']);
                            $hasSubItems = !empty($item['subItems']);
                            // safe default if routePattern missing
                            $routePattern = $item['routePattern'] ?? ($item['route'] ?? '');
                            // when routePattern is empty, request()->routeIs('') returns false safely
                            $isCurrentRoute = request()->routeIs($routePattern);
                        @endphp

                        <li class="relative" data-index="{{ $loop->index }}"
                            data-active="{{ $isCurrentRoute ? '1' : '0' }}">
                            @if ($hasSubItems)
                                <!-- Dropdown Menu Item (button toggles via central controller) -->
                                <button type="button" @click="toggleDropdown({{ $loop->index }})"
                                    :class="(activeDropdown === {{ $loop->index }} ||
                                        {{ $isCurrentRoute ? 'true' : 'false' }}) ?
                                    'bg-white/20 dark:bg-white/10 text-white backdrop-blur-sm shadow-lg' :
                                    'text-white/80 dark:text-gray-300 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white'"
                                    class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition-all duration-200 group relative overflow-hidden">

                                    <!-- Active indicator -->
                                    <span
                                        x-show="activeDropdown === {{ $loop->index }} || {{ $isCurrentRoute ? 'true' : 'false' }}"
                                        class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-white rounded-r-full"
                                        x-transition></span>

                                    <span
                                        class="flex items-center justify-center w-5 h-5 transition-transform duration-200 group-hover:scale-110">
                                        @include('components.sidebar-icon', ['icon' => $item['icon']])
                                    </span>

                                    <span class="truncate font-medium" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        {{ $item['title'] }}
                                    </span>

                                    <!-- Dropdown Arrow -->
                                    <svg class="ml-auto h-4 w-4 transition-transform duration-300 flex-shrink-0"
                                        :class="[activeDropdown === {{ $loop->index }} ? 'rotate-180' : '', sidebarToggle ?
                                            'lg:hidden' : ''
                                        ]"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M6 9l6 6 6-6" />
                                    </svg>
                                </button>

                                <!-- Dropdown Content -->
                                <div x-show="activeDropdown === {{ $loop->index }}"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1" class="overflow-hidden"
                                    :class="sidebarToggle ? 'lg:hidden' : ''" x-cloak>
                                    <ul class="mt-1.5 flex flex-col gap-1 pl-10 pb-1">
                                        @foreach ($item['subItems'] as $sub)
                                            @php
                                                $subRoute = $sub['route'] ?? '';
                                                $isSubActive = $subRoute ? request()->routeIs($subRoute) : false;
                                            @endphp
                                            <li>
                                                <a href="{{ $subRoute ? route($subRoute) : '#' }}"
                                                    class="block rounded-lg px-3 py-2 text-sm transition-all duration-150 relative group/sub
                                                    {{ $isSubActive
                                                        ? 'bg-white/15 dark:bg-white/10 text-white font-medium'
                                                        : 'text-white/70 dark:text-gray-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
                                                    <span class="flex items-center gap-2">
                                                        <span class="w-1 h-1 rounded-full bg-current"></span>
                                                        {{ $sub['title'] }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <!-- Regular Menu Item -->
                                <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}"
                                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 group relative overflow-hidden
                                    {{ $isCurrentRoute
                                        ? 'bg-white/20 dark:bg-white/10 text-white backdrop-blur-sm shadow-lg'
                                        : 'text-white/80 dark:text-gray-300 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white' }}">

                                    <!-- Active indicator -->
                                    @if ($isCurrentRoute)
                                        <span
                                            class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-white rounded-r-full"></span>
                                    @endif

                                    <span
                                        class="flex items-center justify-center w-5 h-5 transition-transform duration-200 group-hover:scale-110">
                                        @include('components.sidebar-icon', ['icon' => $item['icon']])
                                    </span>

                                    <span class="truncate" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        {{ $item['title'] }}
                                    </span>
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

        </nav>
    </div>

    <!-- Sidebar Footer -->
    <div class="relative z-10 mt-auto border-t border-white/10 dark:border-gray-800 p-4"
        :class="sidebarToggle ? 'px-2' : 'px-4'">
        <div class="flex items-center gap-3 text-white/60 dark:text-gray-500 text-xs"
            :class="sidebarToggle ? 'lg:justify-center' : ''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span :class="sidebarToggle ? 'lg:hidden' : ''">v1.0.0</span>
        </div>
    </div>
</aside>

<!-- Mobile Overlay -->
<div x-show="sidebarToggle" @click="sidebarToggle = false" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden" x-cloak>
</div>
