<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Courses Management') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Create and manage your website courses
                </p>
            </div>

            <!-- Create Button -->
            <a href="{{ route('courses.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98]"
                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Add New Course') }}
            </a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <!-- Flash Messages -->
        @foreach (['success', 'error'] as $msg)
            @if (session($msg))
                <div class="mb-4">
                    <x-alert type="{{ $msg }}" :message="session($msg)" dismissible="true" />
                </div>
            @endif
        @endforeach


        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

            <!-- Total Courses -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 
               border border-gray-200 dark:border-gray-700 
               shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Total Courses
                        </p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ $courses->total() }}
                        </p>
                    </div>

                    <div class="p-2.5 rounded-lg"
                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>

                </div>
            </div>

            <!-- Total Applications -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 
               border border-gray-200 dark:border-gray-700 
               shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Total Applications
                        </p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ $courses->sum('applications_count') }}
                        </p>
                    </div>

                    <div class="p-2.5 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>

                </div>
            </div>

            <!-- New Applications -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 
               border border-gray-200 dark:border-gray-700 
               shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            New Applications
                        </p>
                        <p class="text-xl font-bold text-orange-600 dark:text-orange-400 mt-1">
                            {{ $courses->sum('new_applications_count') }}
                        </p>
                    </div>

                    <div class="p-2.5 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                </div>
            </div>

            <!-- Active Courses -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 
               border border-gray-200 dark:border-gray-700 
               shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Active Courses
                        </p>
                        <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-1">
                            {{ $courses->where('status', 1)->count() }}
                        </p>
                    </div>

                    <div class="p-2.5 bg-green-100 dark:bg-green-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                </div>
            </div>

        </div>



        <!-- Courses Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden"
            x-data="{
                showDeleteModal: false,
                courseToDelete: null,
                courseTitle: '',
                showImageModal: false,
                currentImage: '',
                currentImageAlt: '',
                confirmDelete(courseId, courseTitle) {
                    this.courseToDelete = courseId;
                    this.courseTitle = courseTitle;
                    this.showDeleteModal = true;
                },
                executeDelete() {
                    if (this.courseToDelete) {
                        document.getElementById('delete-course-' + this.courseToDelete).submit();
                    }
                },
                previewImage(imageSrc, imageAlt) {
                    this.currentImage = imageSrc;
                    this.currentImageAlt = imageAlt;
                    this.showImageModal = true;
                }
            }">

            <!-- Table Header with Search -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Courses</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                ({{ $courses->count() }} of {{ $courses->total() }})
                            </p>
                        </div>
                    </div>

                    <!-- Search & Filter Form -->
                    <form method="GET" action="{{ route('courses.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by title, description, category..."
                                class="pl-10 pr-4 py-2 w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <select name="status"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        <select name="category"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="featured"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm">
                            <option value="">All Featured</option>
                            <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Featured</option>
                            <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>Not Featured</option>
                        </select>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] whitespace-nowrap"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="hidden sm:inline">Search</span>
                        </button>

                        @if (request('search') || request('status') || request('category') || request('featured'))
                            <a href="{{ route('courses.index') }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span class="hidden sm:inline">Clear</span>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Course
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Category
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Price
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Applications
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($courses as $course)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">

                                <!-- Course with Image -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <!-- Course Icon/Image -->
                                        @if (isset($course->image) && $course->image)
                                            <img src="{{ asset('storage/' . $course->image) }}"
                                                alt="{{ $course->title }}"
                                                class="w-16 h-16 rounded-lg object-cover border-2 border-gray-200 dark:border-gray-700 shadow-sm">
                                        @else
                                            <div class="w-16 h-16 rounded-lg flex items-center justify-center"
                                                style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                                                <svg class="w-8 h-8" style="color: #1363C6;" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Title & Info -->
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-semibold text-gray-900 dark:text-white text-base">
                                                {{ Str::limit($course->title, 40) }}
                                            </span>
                                            <div class="flex items-center gap-2 mt-1">
                                                @if (isset($course->is_featured) && $course->is_featured)
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-medium">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                        Featured
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td class="px-6 py-4">
                                    @if ($course->category)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium"
                                            style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%); color: #1363C6;">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $course->category->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">—</span>
                                    @endif
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1">
                                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                                            Rs.{{ number_format($course->price) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Applications -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if ($course->applications_count > 0)
                                            <a href="{{ route('courses.applications', $course) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-medium hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                {{ $course->applications_count }}
                                                @if ($course->new_applications_count > 0)
                                                    <span class="ml-1 px-1.5 py-0.5 bg-red-500 text-white rounded-full text-[10px] font-bold">
                                                        {{ $course->new_applications_count }}
                                                    </span>
                                                @endif
                                            </a>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-medium">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                0
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    @if ($course->status)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium">
                                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">

                                        <!-- View Applications -->
                                        <a href="{{ route('courses.applications', $course) }}"
                                            class="p-2 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
                                            title="View Applications">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('courses.edit', $course) }}"
                                            class="p-2 rounded-lg text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors"
                                            title="Edit Course">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <!-- Delete -->
                                        <button type="button"
                                            @click="confirmDelete({{ $course->id }}, '{{ $course->title }}')"
                                            class="p-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                            title="Delete Course">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <!-- Hidden Delete Form -->
                                        <form id="delete-course-{{ $course->id }}"
                                            action="{{ route('courses.destroy', $course) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4"
                                            style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                                            <svg class="w-8 h-8" style="color: #1363C6;" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No
                                            courses found</h3>
                                        <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating
                                            your first course</p>
                                        <a href="{{ route('courses.create') }}"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Create First Course
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($courses->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    {{ $courses->links() }}
                </div>
            @endif

            <!-- Delete Modal -->
            <x-delete-modal show="showDeleteModal" title="Delete Course"
                x-bind:message="'Are you sure you want to delete &quot;' + courseTitle +
                    '&quot;? This action cannot be undone and will remove all associated syllabuses.'"
                @click="executeDelete(); showDeleteModal = false" />
        </div>
    </div>
</x-app-layout>
