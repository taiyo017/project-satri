<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-gray-800 leading-tight">
                Dashboard
            </h2>
            <div class="text-sm text-gray-500">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $settings = \App\Models\Setting::first();
                $settingsIncomplete = !$settings || empty($settings->site_name) || empty($settings->email);
            @endphp

            @if($settingsIncomplete)
            <div class="mb-6 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl shadow-md p-5 text-white">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-1">Complete Your Settings</h3>
                            <p class="text-amber-100 text-sm">Please configure your site settings before accessing other features. Site Name and Email are required.</p>
                        </div>
                    </div>
                    <a href="{{ route('settings.index') }}" class="flex-shrink-0 px-4 py-2 bg-white text-amber-600 rounded-lg font-medium text-sm hover:bg-amber-50 transition-colors duration-200">
                        Go to Settings
                    </a>
                </div>
            </div>
            @endif

            <div class="mb-6 bg-gradient-to-r from-[#1A66C5] to-[#2E7FDB] rounded-xl shadow-md p-5 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-semibold mb-1">Welcome back, {{ Auth::user()->name }}!</h1>
                        <p class="text-blue-100 text-sm">Here's what's happening with your website today.</p>
                    </div>

                    <div class="hidden md:block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 opacity-15" fill="none"
                            stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h8v8H3V3zm10 3h8v14h-8V6zM3 13h8v8H3v-8z" />
                        </svg>
                    </div>

                </div>
            </div>


            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 pb-8">

                {{-- Single Stat Card Component --}}
                @php
                    $items = [
                        [
                            'label' => 'Pages',
                            'count' => $stats['pages'],
                            'route' => route('pages.index'),
                            'icon' =>
                                'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l6.414 6.414V19a2 2 0 01-2 2z',
                        ],
                        [
                            'label' => 'Projects',
                            'count' => $stats['projects'],
                            'route' => route('projects.index'),
                            'icon' => 'M3 7h18M3 12h18M3 17h18',
                        ],
                        [
                            'label' => 'Courses',
                            'count' => $stats['courses'],
                            'route' => route('courses.index'),
                            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                        ],
                        [
                            'label' => 'Team',
                            'count' => $stats['team'],
                            'route' => route('team-members.index'),
                            'icon' =>
                                'M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m4-.13a4 4 0 100-8 4 4 0 000 8z',
                        ],
                    ];
                @endphp

                @foreach ($items as $item)
                    <a href="{{ $item['route'] }}"
                        class="group block bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">

                        <div class="flex items-center gap-3">
                            {{-- Icon --}}
                            <div class="p-2 rounded-md bg-gradient-to-br from-[#1A66C5] to-[#2E7FDB] text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                </svg>
                            </div>

                            {{-- Title + Number --}}
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-gray-600 dark:text-gray-400">
                                    {{ $item['label'] }}
                                </span>
                                <span class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $item['count'] }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>

            {{-- Application Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 pb-8">
                <a href="{{ route('careers.index') }}"
                    class="group block bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-md bg-gradient-to-br from-purple-600 to-purple-700 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[13px] font-medium text-gray-600 dark:text-gray-400">Career Apps</span>
                            <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['career_applications'] }}</span>
                        </div>
                    </div>
                </a>

                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-md bg-gradient-to-br from-red-600 to-red-700 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[13px] font-medium text-gray-600 dark:text-gray-400">Unread Career</span>
                            <span class="text-xl font-bold text-red-600 dark:text-red-400">{{ $stats['unread_career_applications'] }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('courses.index') }}"
                    class="group block bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-md bg-gradient-to-br from-blue-600 to-blue-700 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[13px] font-medium text-gray-600 dark:text-gray-400">Course Apps</span>
                            <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['course_applications'] }}</span>
                        </div>
                    </div>
                </a>

                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-md bg-gradient-to-br from-orange-600 to-orange-700 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[13px] font-medium text-gray-600 dark:text-gray-400">Unread Course</span>
                            <span class="text-xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['unread_course_applications'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 dark:bg-gray-900">
                    <a href="{{ route('pages.create') }}"
                        class="group bg-white dark:bg-gray-900 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-6 border border-gray-100 dark:border-gray-800 hover:border-[#1A66C5]">
                        <div class="flex items-center space-x-4">
                            <div
                                class="p-3 rounded-lg bg-blue-50  group-hover:bg-[#1A66C5] transition-colors duration-300">
                                <svg class="h-6 w-6 text-[#1A66C5] group-hover:text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-200">New Page</p>
                                <p class="text-sm text-gray-500">Create content</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('pages.index') }}"
                        class="group bg-white dark:bg-gray-900 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-6 border border-gray-100 dark:border-gray-800 hover:border-[#1A66C5]">
                        <div class="flex items-center space-x-4">
                            <div
                                class="p-3 rounded-lg bg-blue-50 group-hover:bg-[#1A66C5] transition-colors duration-300">
                                <svg class="h-6 w-6 text-[#1A66C5] group-hover:text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-200">All Pages</p>
                                <p class="text-sm text-gray-500">Manage content</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('contacts.index') }}"
                        class="group bg-white dark:bg-gray-900 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-6 border border-gray-100 dark:border-gray-800 hover:border-[#1A66C5]">
                        <div class="flex items-center space-x-4">
                            <div
                                class="p-3 rounded-lg bg-blue-50 group-hover:bg-[#1A66C5] transition-colors duration-300">
                                <svg class="h-6 w-6 text-[#1A66C5] group-hover:text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-200">Messages</p>
                                <p class="text-sm text-gray-500">View inquiries</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('settings.index') }}"
                        class="group bg-white dark:bg-gray-900 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-6 border border-gray-100 dark:border-gray-800 hover:border-[#1A66C5]">
                        <div class="flex items-center space-x-4">
                            <div
                                class="p-3 rounded-lg bg-blue-50 group-hover:bg-[#1A66C5] transition-colors duration-300">
                                <svg class="h-6 w-6 text-[#1A66C5] group-hover:text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-200">Settings</p>
                                <p class="text-sm text-gray-500">Site config</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Activity Timeline --}}
                <div
                    class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                        <span class="text-sm text-gray-500">Last 10 activities</span>
                    </div>

                    @if ($activities->count() > 0)
                        <div class="space-y-4">
                            @foreach ($activities as $act)
                                <div
                                    class="flex items-start space-x-4 p-4 rounded-lg hover:bg-blue-400 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        @if ($act['type'] === 'page')
                                            <div class="p-2 rounded-lg bg-blue-50">
                                                <svg class="h-5 w-5 text-[#1A66C5]" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                        @elseif ($act['type'] === 'career_application')
                                            <div class="p-2 rounded-lg bg-purple-50">
                                                <svg class="h-5 w-5 text-purple-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @elseif ($act['type'] === 'course_application')
                                            <div class="p-2 rounded-lg bg-blue-50">
                                                <svg class="h-5 w-5 text-blue-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="p-2 rounded-lg bg-green-50">
                                                <svg class="h-5 w-5 text-green-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-sm font-medium text-gray-900 dark:text-gray-200 hover:text-blue-600 truncate">
                                            {{ $act['title'] }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $act['time']->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 flex items-center gap-2">
                                        @if ($act['type'] === 'page')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-[#1A66C5]">
                                                Page
                                            </span>
                                        @elseif ($act['type'] === 'career_application')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Career
                                            </span>
                                            @if (!$act['is_read'])
                                                <span class="w-2 h-2 rounded-full bg-red-500" title="Unread"></span>
                                            @endif
                                        @elseif ($act['type'] === 'course_application')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Course
                                            </span>
                                            @if (!$act['is_read'])
                                                <span class="w-2 h-2 rounded-full bg-red-500" title="Unread"></span>
                                            @endif
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100  text-green-800">
                                                Message
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No recent activity</p>
                        </div>
                    @endif
                </div>

                {{-- Right Sidebar --}}
                <div class="space-y-6">

                    {{-- Recent Pages --}}
                    <div
                        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200">Recent Pages</h3>
                            <a href="{{ route('pages.index') }}"
                                class="text-sm text-[#1A66C5] hover:text-[#2E7FDB] font-medium">
                                View all
                            </a>
                        </div>

                        @if ($recentPages->count() > 0)
                            <ul class="space-y-3">
                                @foreach ($recentPages as $page)
                                    <li>
                                        <a href="{{ route('pages.edit', $page->id) }}"
                                            class="block p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 group">
                                            <p
                                                class="text-sm font-medium text-gray-900 dark:text-gray-200 group-hover:text-[#1A66C5] truncate">
                                                {{ $page->title }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $page->created_at->format('M d, Y') }}
                                            </p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No pages yet</p>
                            </div>
                        @endif
                    </div>

                    {{-- New Messages --}}
                    <div
                        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Unread Messages</h3>
                            <a href="{{ route('contacts.index') }}"
                                class="text-sm text-[#1A66C5] hover:text-[#2E7FDB] font-medium">
                                View all
                            </a>
                        </div>

                        @if ($newMessages->count() > 0)
                            <ul class="space-y-3">
                                @foreach ($newMessages as $msg)
                                    <li>
                                        <a href="{{ route('contacts.show', $msg->id) }}"
                                            class="block p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 group">
                                            <div class="flex items-start justify-between">
                                                <p
                                                    class="text-sm font-medium text-gray-900 dark:text-gray-200 group-hover:text-[#1A66C5] truncate flex-1">
                                                    {{ $msg->subject ?? 'No Subject' }}
                                                </p>
                                                <span
                                                    class="ml-2 flex-shrink-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $msg->created_at->diffForHumans() }}
                                            </p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No new messages</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
