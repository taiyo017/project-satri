<x-app-layout>
    <div class="space-y-4" x-data="{
        showMailModal: false,
        showPreviewModal: false,
        previewLoaded: false,
    
        // Split View State
        search: '',
        selectedApp: null,
        activeTab: 'resume',
    
        // Mail Data
        applicationId: null,
        applicationEmail: '',
        applicationName: '',
    
        // Preview Data
        previewUrl: '',
        previewType: '',
        previewName: '',
    
        init() {
            // Wait for DOM to be ready
            this.$nextTick(() => {
                console.log('Course Applications view initialized');
            });
        },
    
        selectApplication(app, resumeUrl, coverUrl) {
            this.selectedApp = { ...app, resumeUrl, coverUrl };
            this.activeTab = 'resume';
    
            // Auto-switch if only cover letter exists
            if (!this.selectedApp.resume && this.selectedApp.cover_letter) {
                this.activeTab = 'cover_letter';
            }
    
            // Use $nextTick to ensure DOM is ready before updating preview
            this.$nextTick(() => {
                this.updatePreview();
            });
        },

        setTab(tab) {
            this.activeTab = tab;
            this.$nextTick(() => {
                this.updatePreview();
            });
        },
    
        updatePreview() {
            if (!this.selectedApp) {
                this.previewUrl = '';
                this.previewType = '';
                this.previewName = '';
                return;
            }
    
            this.previewLoaded = false;
    
            // Short delay to allow loader to show
            setTimeout(() => {
                if (this.activeTab === 'resume' && this.selectedApp.resume) {
                    this.previewUrl = this.selectedApp.resumeUrl;
                    this.previewType = 'resume';
                    this.previewName = this.selectedApp.name;
                } else if (this.activeTab === 'cover_letter' && this.selectedApp.cover_letter) {
                    this.previewUrl = this.selectedApp.coverUrl;
                    this.previewType = 'cover_letter';
                    this.previewName = this.selectedApp.name;
                } else {
                    this.previewUrl = '';
                    this.previewType = '';
                    this.previewName = '';
                }
            }, 100);
        },
    
        openMailModal(id, email, name) {
            this.applicationId = id;
            this.applicationEmail = email;
            this.applicationName = name;
            this.showMailModal = true;
        },
    
        // Legacy/Mobile Modal
        openPreviewModal(url, type, name) {
            this.previewUrl = url;
            this.previewType = type;
            this.previewName = name;
            this.previewLoaded = false;
            this.showPreviewModal = true;
        },

        closePreviewModal() {
            this.showPreviewModal = false;
            setTimeout(() => {
                if (!this.selectedApp) {
                    this.previewUrl = '';
                    this.previewType = '';
                    this.previewName = '';
                }
                this.previewLoaded = false;
            }, 300);
        },
    
        submitForward() {
            const form = document.getElementById('forward-mail-form');
            if (form) {
                form.action = '/admin/course-applications/' + this.applicationId + '/forward';
                form.submit();
            }
        },

        deselectApplication() {
            this.selectedApp = null;
            this.previewUrl = '';
            this.previewType = '';
            this.previewName = '';
            this.previewLoaded = false;
        }
    }">

        <!-- Header with Back Button and Export -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('courses.index') }}"
                    class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    title="Back to Courses">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-xl sm:text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $course->title }}
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        View and manage course applications
                    </p>
                </div>
            </div>

            <!-- Export Button -->
            <a href="{{ route('course-applications.export', $course) }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] bg-gradient-to-br from-green-600 to-green-700 hover:from-green-700 hover:to-green-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Applications
            </a>
        </div>


        <!-- Flash Messages -->
        @if (session('success'))
            <x-alert type="success" :message="session('success')" dismissible="true" />
        @endif

        @if (session('error'))
            <x-alert type="error" :message="session('error')" dismissible="true" />
        @endif

        <!-- Course Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1 truncate">{{ $course->title }}
                    </h3>
                    <div class="flex flex-wrap items-center gap-2">
                        @if($course->category)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $course->category->name }}
                        </span>
                        @endif
                        @if($course->duration)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $course->duration }}
                        </span>
                        @endif
                        @if ($course->price)
                            <span
                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Rs. {{ number_format($course->price, 2) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Applications</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $applications->count() }}</p>
                    </div>
                    <div class="p-2.5 rounded-lg"
                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Unread</p>
                        <p class="text-xl font-bold text-red-600 dark:text-red-400 mt-1">
                            {{ $applications->where('is_read', false)->count() }}
                        </p>
                    </div>
                    <div class="p-2.5 bg-red-100 dark:bg-red-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Read</p>
                        <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-1">
                            {{ $applications->where('is_read', true)->count() }}
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
