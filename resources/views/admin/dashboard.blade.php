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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 pb-8">

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
                            'icon' => 'M12 6v12m6-6H6',
                        ],
                        [
                            'label' => 'Team',
                            'count' => $stats['team'],
                            'route' => route('team-members.index'),
                            'icon' =>
                                'M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m4-.13a4 4 0 100-8 4 4 0 000 8z',
                        ],
                        [
                            'label' => 'Unread',
                            'count' => $stats['unread_messages'],
                            'route' => route('contacts.index'),
                            'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8',
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
                                    <div class="flex-shrink-0">
                                        @if ($act['type'] === 'page')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-[#1A66C5]">
                                                Page
                                            </span>
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
