<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-medium text-xs text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Site Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 space-y-2">
                    @foreach ($errors->all() as $error)
                        <x-alert type="danger" :message="$error" />
                    @endforeach
                </div>
            @endif

            <div x-data="{
                editingSection: null,
                showSuccess: false,
                toggleEdit(section) {
                    this.editingSection = this.editingSection === section ? null : section;
                }
            }">
                <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data"
                    @submit="showSuccess = true">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content - 2 columns -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- General Information Card -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <div
                                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                    <h3
                                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 dark:text-blue-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        General Information
                                    </h3>
                                    <button @click="toggleEdit('general')" type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200"
                                        :class="editingSection === 'general'
                                            ?
                                            'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50' :
                                            'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                :d="editingSection === 'general' ? 'M6 18L18 6M6 6l12 12' :
                                                    'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'" />
                                        </svg>
                                        <span x-text="editingSection === 'general' ? 'Cancel' : 'Edit'"></span>
                                    </button>
                                </div>
                                <div class="p-6 space-y-5">
                                    <!-- Site Name -->
                                    <div>
                                        <x-input-label for="site_name" :value="__('Site Name')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="site_name" x-bind:disabled="editingSection !== 'general'"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            type="text" name="site_name" :value="old('site_name', $setting->site_name ?? '')" required
                                            x-bind:class="editingSection !== 'general' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('site_name')" class="mt-2" />
                                    </div>

                                    <!-- Tagline -->
                                    <div>
                                        <x-input-label for="tagline" :value="__('Tagline')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="tagline" x-bind:disabled="editingSection !== 'general'"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            type="text" name="tagline" :value="old('tagline', $setting->tagline ?? '')"
                                            x-bind:class="editingSection !== 'general' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('tagline')" class="mt-2" />
                                    </div>

                                    <!-- Save Button for this section -->
                                    <div class="pt-4" x-show="editingSection === 'general'">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Card -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <div
                                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                    <h3
                                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 dark:text-blue-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Contact Information
                                    </h3>
                                    <button @click="toggleEdit('contact')" type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200"
                                        :class="editingSection === 'contact'
                                            ?
                                            'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50' :
                                            'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                :d="editingSection === 'contact' ? 'M6 18L18 6M6 6l12 12' :
                                                    'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'" />
                                        </svg>
                                        <span x-text="editingSection === 'contact' ? 'Cancel' : 'Edit'"></span>
                                    </button>
                                </div>
                                <div class="p-6 space-y-5">
                                    <!-- Email -->
                                    <div>
                                        <x-input-label for="email" :value="__('Email Address')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="email" x-bind:disabled="editingSection !== 'contact'"
                                            type="email" name="email"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            :value="old('email', $setting->email ?? '')"
                                            x-bind:class="editingSection !== 'contact' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <x-input-label for="phone" :value="__('Phone Number')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="phone" x-bind:disabled="editingSection !== 'contact'"
                                            type="text" name="phone"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            :value="old('phone', $setting->phone ?? '')"
                                            x-bind:class="editingSection !== 'contact' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                    </div>

                                    <!-- Address -->
                                    <div>
                                        <x-input-label for="address" :value="__('Address')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="address" x-bind:disabled="editingSection !== 'contact'"
                                            type="text" name="address"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            :value="old('address', $setting->address ?? '')"
                                            x-bind:class="editingSection !== 'contact' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                    </div>

                                    <!-- Save Button -->
                                    <div class="pt-4" x-show="editingSection === 'contact'">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Settings Card -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <div
                                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                    <h3
                                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 dark:text-blue-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        SEO Settings
                                    </h3>
                                    <button @click="toggleEdit('seo')" type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200"
                                        :class="editingSection === 'seo'
                                            ?
                                            'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50' :
                                            'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                :d="editingSection === 'seo' ? 'M6 18L18 6M6 6l12 12' :
                                                    'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'" />
                                        </svg>
                                        <span x-text="editingSection === 'seo' ? 'Cancel' : 'Edit'"></span>
                                    </button>
                                </div>
                                <div class="p-6 space-y-5">
                                    <!-- Meta Title -->
                                    <div>
                                        <x-input-label for="meta_title" :value="__('Meta Title')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="meta_title" x-bind:disabled="editingSection !== 'seo'"
                                            type="text" name="meta_title"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            :value="old('meta_title', $setting->meta_title ?? '')"
                                            x-bind:class="editingSection !== 'seo' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                                    </div>

                                    <!-- Meta Description -->
                                    <div>
                                        <x-input-label for="meta_description" :value="__('Meta Description')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <textarea id="meta_description" x-bind:disabled="editingSection !== 'seo'" name="meta_description"
                                            rows="4"
                                            class="block mt-2 w-full rounded-lg border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            x-bind:class="editingSection !== 'seo' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'">{{ old('meta_description', $setting->meta_description ?? '') }}</textarea>
                                        <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                                    </div>

                                    <!-- Save Button -->
                                    <div class="pt-4" x-show="editingSection === 'seo'">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media Links Card -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <div
                                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                    <h3
                                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 dark:text-blue-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Social Media Links
                                    </h3>
                                    <button @click="toggleEdit('social')" type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200"
                                        :class="editingSection === 'social'
                                            ?
                                            'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50' :
                                            'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                :d="editingSection === 'social' ? 'M6 18L18 6M6 6l12 12' :
                                                    'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'" />
                                        </svg>
                                        <span x-text="editingSection === 'social' ? 'Cancel' : 'Edit'"></span>
                                    </button>
                                </div>
                                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <!-- Facebook -->
                                    <div>
                                        <x-input-label for="facebook_url" :value="__('Facebook')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="facebook_url"
                                            x-bind:disabled="editingSection !== 'social'" type="url"
                                            name="facebook_url"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            :value="old('facebook_url', $setting->facebook_url ?? '')" placeholder="https://facebook.com/yourpage"
                                            x-bind:class="editingSection !== 'social' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('facebook_url')" class="mt-2" />
                                    </div>

                                    <!-- Twitter -->
                                    <div>
                                        <x-input-label for="twitter_url" :value="__('Twitter')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="twitter_url"
                                            x-bind:disabled="editingSection !== 'social'" type="url"
                                            name="twitter_url"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            :value="old('twitter_url', $setting->twitter_url ?? '')" placeholder="https://twitter.com/yourhandle"
                                            x-bind:class="editingSection !== 'social' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('twitter_url')" class="mt-2" />
                                    </div>

                                    <!-- Instagram -->
                                    <div>
                                        <x-input-label for="instagram_url" :value="__('Instagram')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="instagram_url"
                                            x-bind:disabled="editingSection !== 'social'" type="url"
                                            name="instagram_url"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            :value="old('instagram_url', $setting->instagram_url ?? '')" placeholder="https://instagram.com/yourprofile"
                                            x-bind:class="editingSection !== 'social' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('instagram_url')" class="mt-2" />
                                    </div>

                                    <!-- LinkedIn -->
                                    <div>
                                        <x-input-label for="linkedin_url" :value="__('LinkedIn')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="linkedin_url"
                                            x-bind:disabled="editingSection !== 'social'" type="url"
                                            name="linkedin_url"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            :value="old('linkedin_url', $setting->linkedin_url ?? '')" placeholder="https://linkedin.com/company/yourcompany"
                                            x-bind:class="editingSection !== 'social' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('linkedin_url')" class="mt-2" />
                                    </div>

                                    <!-- YouTube -->
                                    <div class="md:col-span-2">
                                        <x-input-label for="youtube_url" :value="__('YouTube')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="youtube_url"
                                            x-bind:disabled="editingSection !== 'social'" type="url"
                                            name="youtube_url"
                                            class="block mt-2 w-full text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500"
                                            :value="old('youtube_url', $setting->youtube_url ?? '')" placeholder="https://youtube.com/channel/yourchannel"
                                            x-bind:class="editingSection !== 'social' ?
                                                'bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75' :
                                                'bg-white dark:bg-gray-800'" />
                                        <x-input-error :messages="$errors->get('youtube_url')" class="mt-2" />
                                    </div>

                                    <!-- Save Button -->
                                    <div class="md:col-span-2 pt-4" x-show="editingSection === 'social'">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Sidebar - 1 column -->
                        <div class="space-y-6">
                            <!-- Logo Upload Card -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <div
                                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                    <h3
                                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 dark:text-blue-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Logo
                                    </h3>
                                    <button @click="toggleEdit('logo')" type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200"
                                        :class="editingSection === 'logo'
                                            ?
                                            'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50' :
                                            'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                :d="editingSection === 'logo' ? 'M6 18L18 6M6 6l12 12' :
                                                    'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'" />
                                        </svg>
                                        <span x-text="editingSection === 'logo' ? 'Cancel' : 'Edit'"></span>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <div class="flex flex-col items-center">
                                        <!-- Logo Preview -->
                                        <div class="mb-4 w-full flex justify-center">
                                            @if (!empty($setting->logo_path))
                                                <img id="logo-preview"
                                                    src="{{ asset('storage/' . $setting->logo_path) }}" alt="Logo"
                                                    class="max-h-32 max-w-full object-contain rounded-lg border-2 border-gray-300 dark:border-gray-600">
                                            @else
                                                <div id="logo-placeholder"
                                                    class="w-full h-32 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                                                    <span class="text-gray-500 dark:text-gray-400 text-sm">No logo
                                                        uploaded</span>
                                                </div>
                                                <img id="logo-preview"
                                                    class="hidden max-h-32 max-w-full object-contain rounded-lg border-2 border-gray-300 dark:border-gray-600"
                                                    alt="Logo Preview">
                                            @endif
                                        </div>

                                        <!-- Upload Button -->
                                        <div class="w-full" x-show="editingSection === 'logo'">
                                            <label for="logo_path"
                                                class="cursor-pointer w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                <span>Choose Logo</span>
                                            </label>
                                            <input id="logo_path" type="file" name="logo_path" class="hidden"
                                                accept="image/*" onchange="previewLogo(this)">
                                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">
                                                PNG, JPG, SVG up to 2MB
                                            </p>
                                            <x-input-error :messages="$errors->get('logo_path')" class="mt-2" />
                                        </div>

                                        <!-- Save Button -->
                                        <div class="w-full mt-4" x-show="editingSection === 'logo'">
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Favicon Upload Card -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <div
                                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                    <h3
                                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 dark:text-blue-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                        </svg>
                                        Favicon
                                    </h3>
                                    <button @click="toggleEdit('favicon')" type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200"
                                        :class="editingSection === 'favicon'
                                            ?
                                            'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50' :
                                            'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                :d="editingSection === 'favicon' ? 'M6 18L18 6M6 6l12 12' :
                                                    'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'" />
                                        </svg>
                                        <span x-text="editingSection === 'favicon' ? 'Cancel' : 'Edit'"></span>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <div class="flex flex-col items-center">
                                        <!-- Favicon Preview -->
                                        <div class="mb-4 w-full flex justify-center">
                                            @if (!empty($setting->favicon_path))
                                                <img id="favicon-preview"
                                                    src="{{ asset('storage/' . $setting->favicon_path) }}"
                                                    alt="Favicon"
                                                    class="h-16 w-16 object-contain rounded-lg border-2 border-gray-300 dark:border-gray-600">
                                            @else
                                                <div id="favicon-placeholder"
                                                    class="h-16 w-16 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-8 w-8 text-gray-400 dark:text-gray-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <img id="favicon-preview"
                                                    class="hidden h-16 w-16 object-contain rounded-lg border-2 border-gray-300 dark:border-gray-600"
                                                    alt="Favicon Preview">
                                            @endif
                                        </div>

                                        <!-- Upload Button -->
                                        <div class="w-full" x-show="editingSection === 'favicon'">
                                            <label for="favicon_path"
                                                class="cursor-pointer w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                <span>Choose Favicon</span>
                                            </label>
                                            <input id="favicon_path" type="file" name="favicon_path"
                                                class="hidden" accept="image/*" onchange="previewFavicon(this)">
                                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">
                                                32x32 or 16x16 pixels
                                            </p>
                                            <x-input-error :messages="$errors->get('favicon_path')" class="mt-2" />
                                        </div>

                                        <!-- Save Button -->
                                        <div class="w-full mt-4" x-show="editingSection === 'favicon'">
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Help Card -->
                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800/30 p-6">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Quick
                                            Tips</h4>
                                        <ul class="text-xs text-gray-700 dark:text-gray-300 space-y-1.5">
                                            <li>• Click Edit on any section to modify</li>
                                            <li>• Use descriptive titles for better SEO</li>
                                            <li>• Add meta descriptions for search engines</li>
                                            <li>• Save changes after editing each section</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewLogo(input) {
            const preview = document.getElementById('logo-preview');
            const placeholder = document.getElementById('logo-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewFavicon(input) {
            const preview = document.getElementById('favicon-preview');
            const placeholder = document.getElementById('favicon-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
