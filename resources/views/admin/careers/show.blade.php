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
                console.log('Applications view initialized');
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
                form.action = '/admin/career-applications/' + this.applicationId + '/forward';
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
                <a href="{{ route('careers.index') }}"
                    class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    title="Back to Careers">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-xl sm:text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $career->title }}
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        View and manage job applications
                    </p>
                </div>
            </div>

            <!-- Export Button -->
            <a href="{{ route('applications.export', $career) }}"
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

        <!-- Job Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1 truncate">{{ $career->title }}
                    </h3>
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $career->location }}
                        </span>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ ucfirst(str_replace('-', ' ', $career->job_type)) }}
                        </span>
                        @if ($career->deadline)
                            <span
                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md {{ $career->deadline < now() ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' : 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' }} text-xs">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $career->deadline->format('M d, Y') }}
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

        <!-- Applications Split View -->
        <div class="flex flex-row gap-6 h-[75vh]">
            <!-- LEFT PANEL: Applications List -->
            <div :class="selectedApp ? 'w-1/3' : 'w-full'"
                class="flex-shrink-0 flex flex-col bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 ease-in-out">

                <!-- Search Header -->
                <div
                    class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex-shrink-0">
                    <div class="relative">
                        <input type="text" x-model="search" placeholder="Search applicants..."
                            class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Scrollable List -->
                <div class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-2">
                    @forelse ($applications as $application)
                        <div data-search="{{ strtolower($application->name . ' ' . $application->email) }}"
                            x-show="!search || $el.dataset.search.includes(search.toLowerCase())"
                            @click="selectApplication({{ json_encode($application) }}, '{{ $application->resume ? asset('storage/' . $application->resume) : '' }}', '{{ $application->cover_letter ? asset('storage/' . $application->cover_letter) : '' }}')"
                            :class="selectedApp && selectedApp.id === {{ $application->id }} ?
                                'bg-blue-50 dark:bg-blue-900/20 border-blue-500 shadow-sm ring-1 ring-blue-500/20' :
                                'bg-transparent border-transparent hover:bg-gray-50 dark:hover:bg-gray-700/50'"
                            class="p-3 rounded-lg border-l-4 cursor-pointer transition-all duration-200 group relative">

                            <div class="flex items-start gap-3">
                                <!-- Avatar -->
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white shadow-sm flex-shrink-0"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    {{ strtoupper(substr($application->name, 0, 1)) }}
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate pr-2"
                                            :class="selectedApp && selectedApp.id === {{ $application->id }} ?
                                                'text-blue-700 dark:text-blue-400' : ''">
                                            {{ $application->name }}
                                        </h4>
                                        @if (!$application->is_read)
                                            <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0 mt-1.5"
                                                title="Unread"></span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ $application->email }}</p>

                                    <div class="flex items-center gap-2 mt-2">
                                        @if ($application->resume)
                                            <span
                                                class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Resume
                                            </span>
                                        @endif
                                        @if ($application->cover_letter)
                                            <span
                                                class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                Cover Letter
                                            </span>
                                        @endif
                                        <span
                                            class="text-[10px] text-gray-400 ml-auto">{{ $application->created_at->diffForHumans(null, true, true) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 px-4">
                            <p class="text-sm text-gray-500">No applications found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- RIGHT PANEL: Document Preview -->
            <div x-show="selectedApp" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-8"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-8"
                class="flex flex-1 flex-col min-w-0 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                <!-- Toolbar -->
                <div
                    class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex items-center justify-between shadow-sm z-10 flex-shrink-0">
                    <div class="flex items-center gap-4 min-w-0 flex-1">
                        <div class="min-w-0 flex-1">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white truncate"
                                x-text="selectedApp ? selectedApp.name : 'Select Applicant'"></h2>
                            <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                <template x-if="selectedApp && selectedApp.email">
                                    <a :href="'mailto:' + selectedApp.email"
                                        class="hover:text-blue-600 flex items-center gap-1 transition-colors truncate">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span x-text="selectedApp.email" class="truncate"></span>
                                    </a>
                                </template>
                                <template x-if="selectedApp && selectedApp.phone">
                                    <span
                                        class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600 flex-shrink-0"></span>
                                </template>
                                <template x-if="selectedApp && selectedApp.phone">
                                    <a :href="'tel:' + selectedApp.phone"
                                        class="hover:text-blue-600 flex items-center gap-1 transition-colors">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span x-text="selectedApp.phone"></span>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 flex-shrink-0">
                        <!-- Tab Switcher -->
                        <div class="flex p-1 bg-gray-100 dark:bg-gray-700/50 rounded-lg">
                            <button @click="setTab('resume')" :disabled="!selectedApp || !selectedApp.resume"
                                :class="activeTab === 'resume' ?
                                    'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm' :
                                    'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                                class="px-3 py-1.5 text-xs font-semibold rounded-md transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                Resume
                            </button>
                            <button @click="setTab('cover_letter')"
                                :disabled="!selectedApp || !selectedApp.cover_letter"
                                :class="activeTab === 'cover_letter' ?
                                    'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm' :
                                    'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                                class="px-3 py-1.5 text-xs font-semibold rounded-md transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                Cover Letter
                            </button>
                        </div>

                        <div class="h-6 w-px bg-gray-200 dark:bg-gray-700 mx-1"></div>

                        <template x-if="selectedApp">
                            <button @click="openMailModal(selectedApp.id, selectedApp.email, selectedApp.name)"
                                class="flex items-center gap-2 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition-colors shadow-sm shadow-blue-500/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Forward
                            </button>
                        </template>

                        <div class="h-6 w-px bg-gray-200 dark:bg-gray-700 mx-1"></div>

                        <button @click="deselectApplication()"
                            class="p-2 rounded-lg text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                            title="Close preview">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Preview Content Area -->
                <div class="flex-1 relative bg-gray-50 dark:bg-gray-900/50 min-h-0">
                    <!-- File Preview Component -->
                    <x-file-preview mode="inline" />
                </div>
            </div>
        </div>

        <!-- Modals -->
        @if ($applications->isNotEmpty())
            <x-forward-email :career="$career" :application="$applications->first()" />
        @endif

        <!-- Mobile Preview Modal -->
        <div class="lg:hidden">
            <x-file-preview mode="modal" />
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: rgba(156, 163, 175, 0.5);
                border-radius: 20px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background-color: rgba(107, 114, 128, 0.8);
            }
        </style>
    </div>
</x-app-layout>
