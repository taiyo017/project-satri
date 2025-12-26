<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $app->name }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1">
                    Manage versions, files, screenshots & QR codes
                </p>
            </div>
            <div class="flex items-center gap-2">
                @if ($app->status === 'active')
                    <a href="{{ route('frontend.apps.show', $app->slug) }}" target="_blank"
                        class="inline-flex items-center gap-1.5 sm:gap-2 px-4 sm:px-5 py-2 sm:py-2.5 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] whitespace-nowrap"
                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="hidden sm:inline">{{ __('View Live') }}</span>
                        <span class="sm:hidden">{{ __('View') }}</span>
                    </a>
                @endif
                <a href="{{ route('apps.edit', $app) }}"
                    class="inline-flex items-center gap-1.5 sm:gap-2 px-4 sm:px-5 py-2 sm:py-2.5 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] whitespace-nowrap"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span class="sm:hidden">{{ __('Edit') }}</span>
                </a>
                <a href="{{ route('apps.index') }}"
                    class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">{{ __('Back to Apps') }}</span>
                    <span class="sm:hidden">{{ __('Back') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <x-alert type="success" :message="session('success')" dismissible="true" />
        @endif

        @if (session('error'))
            <x-alert type="error" :message="session('error')" dismissible="true" />
        @endif

        @if ($app->versions->count() === 0)
            <div class="rounded-xl border-2 p-6 mb-6 animate-pulse-slow"
                style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.1) 0%, rgba(245, 158, 11, 0.15) 100%); border-color: rgba(251, 191, 36, 0.4);">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center shadow-lg"
                        style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);">
                        <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                            <i class="fas fa-tools text-yellow-600"></i>
                            App Setup Incomplete
                        </h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-5">
                            Your app has been created successfully, but it's not ready for users yet. Complete these
                            steps to publish your app:
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                class="group relative overflow-hidden rounded-xl p-4 bg-white dark:bg-gray-800 border-2 border-blue-200 dark:border-blue-800 hover:border-blue-400 dark:hover:border-blue-600 transition-all duration-300 hover:shadow-lg">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500/10 rounded-full -mr-10 -mt-10">
                                </div>
                                <div class="relative">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span
                                            class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-md"
                                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                            <i class="fas fa-code-branch"></i>
                                        </span>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">Add Version</h4>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                                        Click "Add Version" in the Versions tab below. Enter version number (e.g.,
                                        1.0.0) and release notes.
                                    </p>
                                </div>
                            </div>

                            <div
                                class="group relative overflow-hidden rounded-xl p-4 bg-white dark:bg-gray-800 border-2 border-green-200 dark:border-green-800 hover:border-green-400 dark:hover:border-green-600 transition-all duration-300 hover:shadow-lg">
                                <div
                                    class="absolute top-0 right-0 w-20 h-20 bg-green-500/10 rounded-full -mr-10 -mt-10">
                                </div>
                                <div class="relative">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span
                                            class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-md"
                                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                            <i class="fas fa-file-archive"></i>
                                        </span>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">Add Files</h4>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                                        <i class="fas fa-check-circle text-green-600"></i> Paste Store URL (if
                                        published) OR
                                        <i class="fas fa-upload text-blue-600"></i> Upload APK/IPA file
                                    </p>
                                </div>
                            </div>

                            <div
                                class="group relative overflow-hidden rounded-xl p-4 bg-white dark:bg-gray-800 border-2 border-purple-200 dark:border-purple-800 hover:border-purple-400 dark:hover:border-purple-600 transition-all duration-300 hover:shadow-lg">
                                <div
                                    class="absolute top-0 right-0 w-20 h-20 bg-purple-500/10 rounded-full -mr-10 -mt-10">
                                </div>
                                <div class="relative">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span
                                            class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-md"
                                            style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                                            <i class="fas fa-images"></i>
                                        </span>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">Upload Screenshots
                                        </h4>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                                        Go to Screenshots tab and upload 3-5 images to showcase your app features.
                                    </p>
                                </div>
                            </div>

                            <div
                                class="group relative overflow-hidden rounded-xl p-4 bg-white dark:bg-gray-800 border-2 border-indigo-200 dark:border-indigo-800 hover:border-indigo-400 dark:hover:border-indigo-600 transition-all duration-300 hover:shadow-lg">
                                <div
                                    class="absolute top-0 right-0 w-20 h-20 bg-indigo-500/10 rounded-full -mr-10 -mt-10">
                                </div>
                                <div class="relative">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span
                                            class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-md"
                                            style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                                            <i class="fas fa-qrcode"></i>
                                        </span>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">Generate QR Code
                                        </h4>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                                        Create a QR code for easy sharing and marketing. Users can scan to download.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-5 p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg border border-green-200 dark:border-green-800">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-rocket text-green-600 text-xl"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Ready to Publish?
                                    </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                        After completing the steps above, click "Edit Info" and change status to
                                        "Active" to make your app live!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sidebar Stats -->
            <div class="lg:col-span-1">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-6">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">App Overview</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Quick stats and information</p>
                    </div>

                    <div class="p-6 space-y-4">
                        @if ($app->category)
                            <div>
                                <label
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 block">Category</label>
                                <div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium"
                                    style="background-color: {{ $app->category->color }}20; color: {{ $app->category->color }};">
                                    <i class="fas fa-tag"></i>
                                    {{ $app->category->name }}
                                </div>
                            </div>
                        @endif

                        <div>
                            <label
                                class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 block">Status</label>
                            @if ($app->status === 'active')
                                <span
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-sm font-semibold">
                                    <i class="fas fa-check-circle"></i>
                                    Active & Published
                                </span>
                            @elseif ($app->status === 'draft')
                                <span
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-sm font-semibold">
                                    <i class="fas fa-file-alt"></i>
                                    Draft
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-sm font-semibold">
                                    <i class="fas fa-times-circle"></i>
                                    Inactive
                                </span>
                            @endif
                        </div>

                        @if ($app->latestVersion)
                            <div>
                                <label
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 block">Latest
                                    Version</label>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-code-branch text-blue-600"></i>
                                    <span
                                        class="text-lg font-bold text-gray-900 dark:text-white">v{{ $app->latestVersion->version_number }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <label
                                class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 block">Analytics</label>
                            <div class="space-y-3">
                                <div
                                    class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-blue-600">
                                            <i class="fas fa-download text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">Downloads</p>
                                            <p class="text-xl font-bold text-gray-900 dark:text-white">
                                                {{ number_format($app->download_count) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-between p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg flex items-center justify-center bg-purple-600">
                                            <i class="fas fa-qrcode text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">QR Scans</p>
                                            <p class="text-xl font-bold text-gray-900 dark:text-white">
                                                {{ number_format($app->scan_count) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($app->is_featured)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="p-3 rounded-lg"
                                    style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.1) 0%, rgba(245, 158, 11, 0.15) 100%);">
                                    <div class="flex items-center gap-2 text-yellow-700 dark:text-yellow-400">
                                        <i class="fas fa-star"></i>
                                        <span class="text-sm font-semibold">Featured App</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6" x-data="{ activeTab: 'versions' }">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <nav class="flex gap-1 px-4 py-2" aria-label="Tabs">
                            <button @click="activeTab = 'versions'"
                                :class="activeTab === 'versions' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' :
                                    'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200'"
                                class="flex-1 py-3 px-4 rounded-lg font-medium text-sm transition-all inline-flex items-center justify-center gap-2">
                                <i class="fas fa-code-branch"></i>
                                <span class="hidden sm:inline">Versions & Files</span>
                                <span class="sm:hidden">Versions</span>
                            </button>
                            <button @click="activeTab = 'screenshots'"
                                :class="activeTab === 'screenshots' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' :
                                    'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200'"
                                class="flex-1 py-3 px-4 rounded-lg font-medium text-sm transition-all inline-flex items-center justify-center gap-2">
                                <i class="fas fa-images"></i>
                                Screenshots
                            </button>
                            <button @click="activeTab = 'qr'"
                                :class="activeTab === 'qr' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' :
                                    'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200'"
                                class="flex-1 py-3 px-4 rounded-lg font-medium text-sm transition-all inline-flex items-center justify-center gap-2">
                                <i class="fas fa-qrcode"></i>
                                QR Code
                            </button>
                        </nav>
                    </div>

                    <div class="p-6">
                        <div x-show="activeTab === 'versions'" x-transition>
                            @include('admin.apps.partials.versions')
                        </div>

                        <div x-show="activeTab === 'screenshots'" x-cloak x-transition>
                            @include('admin.apps.partials.screenshots')
                        </div>

                        <div x-show="activeTab === 'qr'" x-cloak x-transition>
                            @include('admin.apps.partials.qr-code')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
