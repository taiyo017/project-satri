<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-gray-900 dark:text-white">
                    Add Team Member
                </h2>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                    Create a new team member profile
                </p>
            </div>

            <a href="{{ route('team-members.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-gray-700 to-gray-800 
                text-white rounded-xl hover:shadow-lg hover:shadow-gray-700/30 hover:-translate-y-0.5
                transition-all duration-300 font-medium shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('team-members.store') }}" method="POST" enctype="multipart/form-data"
                id="teamMemberForm">
                @csrf

                {{-- Main Information Card --}}
                <div
                    class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 mb-6">

                    {{-- Card Header --}}
                    <div
                        class="px-8 py-6 bg-gradient-to-r from-[#1363C6]/5 to-[#1e7ed8]/5 dark:from-[#1363C6]/10 dark:to-[#1e7ed8]/10 border-b border-gray-200 dark:border-gray-800">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-gradient-to-br from-[#1363C6] to-[#1e7ed8] rounded-xl shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Basic Information</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Essential member details</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        {{-- Photo Upload with Preview --}}
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Profile Photo
                            </label>

                            <div class="flex items-start gap-6">
                                {{-- Preview Area --}}
                                <div class="relative group">
                                    <div id="photoPreview"
                                        class="w-32 h-32 rounded-2xl border-3 border-dashed border-gray-300 dark:border-gray-700 
                                        bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900
                                        flex items-center justify-center overflow-hidden transition-all duration-300
                                        group-hover:border-[#1363C6] dark:group-hover:border-[#1363C6]">

                                        {{-- Default Icon --}}
                                        <div id="defaultIcon" class="text-center">
                                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-2"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">No photo</p>
                                        </div>

                                        {{-- Preview Image --}}
                                        <img id="previewImg" src="" alt="Preview"
                                            class="hidden w-full h-full object-cover">
                                    </div>

                                    {{-- Remove Button --}}
                                    <button type="button" id="removePhotoBtn" onclick="removePhoto()"
                                        class="hidden absolute -top-2 -right-2 w-8 h-8 bg-red-500 hover:bg-red-600 
                                        text-white rounded-full shadow-lg transition-all duration-300 hover:scale-110">
                                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- Upload Button --}}
                                <div class="flex-1">
                                    <label for="photoInput"
                                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1363C6] to-[#1e7ed8] 
                                        text-white rounded-xl hover:shadow-lg hover:shadow-[#1363C6]/30 
                                        transition-all duration-300 cursor-pointer font-medium">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Choose Photo
                                    </label>
                                    <input type="file" name="photo" id="photoInput" accept="image/*"
                                        onchange="previewPhoto(event)" class="hidden">

                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                        Recommended: Square image, at least 400x400px
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                        Supported formats: JPG, PNG, WebP (Max 5MB)
                                    </p>
                                </div>
                            </div>

                            @error('photo')
                                <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Name & Designation --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name"
                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-700 rounded-xl 
                                    focus:border-[#1363C6] focus:ring-4 focus:ring-[#1363C6]/10 
                                    dark:bg-gray-800 dark:text-white transition-all duration-300
                                    @error('name') border-red-500 @enderror"
                                    value="{{ old('name') }}" placeholder="John Doe" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Designation --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Designation
                                </label>
                                <input type="text" name="designation"
                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-700 rounded-xl 
                                    focus:border-[#1363C6] focus:ring-4 focus:ring-[#1363C6]/10 
                                    dark:bg-gray-800 dark:text-white transition-all duration-300"
                                    value="{{ old('designation') }}" placeholder="Chief Executive Officer">
                            </div>

                        </div>

                        {{-- Bio --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Bio / Description
                            </label>
                            <textarea name="bio" rows="4"
                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-700 rounded-xl 
                                focus:border-[#1363C6] focus:ring-4 focus:ring-[#1363C6]/10 
                                dark:bg-gray-800 dark:text-white transition-all duration-300 resize-none"
                                placeholder="Write a brief bio about the team member...">{{ old('bio') }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Optional: Brief description or bio
                            </p>
                        </div>

                        {{-- Order Index --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Display Order
                            </label>
                            <input type="number" name="order_index"
                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-700 rounded-xl 
                                focus:border-[#1363C6] focus:ring-4 focus:ring-[#1363C6]/10 
                                dark:bg-gray-800 dark:text-white transition-all duration-300"
                                value="{{ old('order_index', 0) }}" min="0" placeholder="0">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Lower numbers appear first</p>
                        </div>

                    </div>
                </div>

                {{-- Social Links Card --}}
                <div
                    class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 mb-6">

                    {{-- Card Header --}}
                    <div
                        class="px-8 py-6 bg-gradient-to-r from-[#1363C6]/5 to-[#1e7ed8]/5 dark:from-[#1363C6]/10 dark:to-[#1e7ed8]/10 border-b border-gray-200 dark:border-gray-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 bg-gradient-to-br from-[#1363C6] to-[#1e7ed8] rounded-xl shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Social Media Links</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Add member's social profiles
                                    </p>
                                </div>
                            </div>

                            <button type="button" onclick="addSocialLink()"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-[#1363C6]/10 hover:bg-[#1363C6]/20 
                                text-[#1363C6] dark:text-[#4a9fe8] rounded-lg font-medium transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add Link
                            </button>
                        </div>
                    </div>

                    <div class="p-8">
                        <div id="socialLinksContainer" class="space-y-4">
                            {{-- Social links will be added here dynamically --}}
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400" id="emptyState">
                                <svg class="w-16 h-16 mx-auto mb-3 text-gray-400 dark:text-gray-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                <p class="font-medium mb-1">No social links added yet</p>
                                <p class="text-sm">Click "Add Link" to add social media profiles</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEO Card --}}
                <div
                    class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 mb-6">

                    {{-- Card Header --}}
                    <div
                        class="px-8 py-6 bg-gradient-to-r from-[#1363C6]/5 to-[#1e7ed8]/5 dark:from-[#1363C6]/10 dark:to-[#1e7ed8]/10 border-b border-gray-200 dark:border-gray-800">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-gradient-to-br from-[#1363C6] to-[#1e7ed8] rounded-xl shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">SEO Meta Information</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Optimize for search engines</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            {{-- Meta Title --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Title
                                </label>
                                <input type="text" name="meta_title"
                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-700 rounded-xl 
                                    focus:border-[#1363C6] focus:ring-4 focus:ring-[#1363C6]/10 
                                    dark:bg-gray-800 dark:text-white transition-all duration-300"
                                    value="{{ old('meta_title') }}" placeholder="SEO title for this member">
                            </div>

                            {{-- Meta Keywords --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Keywords
                                </label>
                                <input type="text" name="meta_keywords"
                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-700 rounded-xl 
                                    focus:border-[#1363C6] focus:ring-4 focus:ring-[#1363C6]/10 
                                    dark:bg-gray-800 dark:text-white transition-all duration-300"
                                    value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                            </div>

                        </div>

                        {{-- Meta Description --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Meta Description
                            </label>
                            <textarea name="meta_description" rows="3"
                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-700 rounded-xl 
                                focus:border-[#1363C6] focus:ring-4 focus:ring-[#1363C6]/10 
                                dark:bg-gray-800 dark:text-white transition-all duration-300 resize-none"
                                placeholder="Brief description for search engines (150-160 characters)">{{ old('meta_description') }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Recommended length: 150-160
                                characters</p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('team-members.index') }}"
                        class="px-6 py-3 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 
                        rounded-xl hover:bg-gray-300 dark:hover:bg-gray-700 
                        transition-all duration-300 font-medium">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-[#1363C6] to-[#1e7ed8] 
                        text-white rounded-xl hover:shadow-lg hover:shadow-[#1363C6]/30 hover:-translate-y-0.5
                        transition-all duration-300 font-semibold shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Save Team Member
                    </button>
                </div>

            </form>

        </div>
    </div>

    <script>
        let socialLinkCounter = 0;

        // Social Media Platforms
        const socialPlatforms = {
            facebook: {
                name: 'Facebook',
                icon: 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z',
                color: '#1877F2'
            },
            twitter: {
                name: 'Twitter/X',
                icon: 'M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z',
                color: '#1DA1F2'
            },
            linkedin: {
                name: 'LinkedIn',
                icon: 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z',
                color: '#0A66C2'
            },
            instagram: {
                name: 'Instagram',
                icon: 'M7 0h10c3.866 0 7 3.134 7 7v10c0 3.866-3.134 7-7 7H7c-3.866 0-7-3.134-7-7V7c0-3.866 3.134-7 7-7zm0 2C4.239 2 2 4.239 2 7v10c0 2.761 2.239 5 5 5h10c2.761 0 5-2.239 5-5V7c0-2.761-2.239-5-5-5H7zm5 3c2.761 0 5 2.239 5 5s-2.239 5-5 5-5-2.239-5-5 2.239-5 5-5zm0 2c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm5.5-2a1.5 1.5 0 110 3 1.5 1.5 0 010-3z',
                color: '#E4405F'
            },
            github: {
                name: 'GitHub',
                icon: 'M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22',
                color: '#181717'
            },
            youtube: {
                name: 'YouTube',
                icon: 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z',
                color: '#FF0000'
            },
            website: {
                name: 'Website',
                icon: 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9',
                color: '#1363C6'
            },
            email: {
                name: 'Email',
                icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                color: '#EA4335'
            },
        };

        function addSocialLink() {
            const container = document.getElementById('socialLinksContainer');
            const emptyState = document.getElementById('emptyState');

            if (emptyState) {
                emptyState.remove();
            }

            const linkId = socialLinkCounter++;
            const linkHtml = `
                <div class="social-link-item p-5 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 
                    rounded-xl border-2 border-gray-200 dark:border-gray-700 
                    hover:border-[#1363C6]/30 dark:hover:border-[#1363C6]/30 
                    transition-all duration-300" data-link-id="${linkId}">
                    
                    <div class="flex items-start gap-4">
                        
                        {{-- Platform Select --}}
                        <div class="flex-shrink-0 w-48">
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Platform
                            </label>
                            <select name="social_links[${linkId}][platform]" 
                                onchange="updatePlatformIcon(${linkId}, this.value)"
                                class="w-full px-3 py-2.5 border-2 border-gray-300 dark:border-gray-700 rounded-lg 
                                focus:border-[#1363C6] focus:ring-2 focus:ring-[#1363C6]/10 
                                dark:bg-gray-800 dark:text-white transition-all duration-300 text-sm">
                                ${Object.entries(socialPlatforms).map(([key, platform]) => 
                                    `<option value="${key}">${platform.name}</option>`
                                ).join('')}
                            </select>
                        </div>

                        {{-- URL Input --}}
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Profile URL
                            </label>
                            <input type="url" 
                                name="social_links[${linkId}][url]" 
                                placeholder="https://..."
                                class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-700 rounded-lg 
                                focus:border-[#1363C6] focus:ring-2 focus:ring-[#1363C6]/10 
                                dark:bg-gray-800 dark:text-white transition-all duration-300 text-sm"
                                required>
                        </div>

                        {{-- Platform Icon --}}
                        <div class="flex-shrink-0 pt-6">
                            <div id="platform-icon-${linkId}" 
                                class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#1363C6] to-[#1e7ed8] 
                                flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="${socialPlatforms.facebook.icon}"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Remove Button --}}
                        <div class="flex-shrink-0 pt-6">
                            <button type="button" 
                                onclick="removeSocialLink(${linkId})"
                                class="w-10 h-10 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 
                                text-red-600 dark:text-red-400 rounded-lg transition-all duration-300 
                                hover:scale-110 group">
                                <svg class="w-5 h-5 mx-auto group-hover:rotate-90 transition-transform duration-300" 
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', linkHtml);
        }

        function removeSocialLink(linkId) {
            const element = document.querySelector(`[data-link-id="${linkId}"]`);
            if (element) {
                element.style.transform = 'scale(0.9)';
                element.style.opacity = '0';
                setTimeout(() => {
                    element.remove();
                    checkEmptyState();
                }, 300);
            }
        }

        function updatePlatformIcon(linkId, platform) {
            const iconContainer = document.getElementById(`platform-icon-${linkId}`);
            const platformData = socialPlatforms[platform];

            if (iconContainer && platformData) {
                iconContainer.innerHTML = `
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="${platformData.icon}"/>
                    </svg>
                `;
                iconContainer.style.background =
                    `linear-gradient(to bottom right, ${platformData.color}, ${platformData.color}dd)`;
            }
        }

        function checkEmptyState() {
            const container = document.getElementById('socialLinksContainer');
            if (container.children.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400" id="emptyState">
                        <svg class="w-16 h-16 mx-auto mb-3 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        <p class="font-medium mb-1">No social links added yet</p>
                        <p class="text-sm">Click "Add Link" to add social media profiles</p>
                    </div>
                `;
            }
        }

        // Photo Preview Functions
        function previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const defaultIcon = document.getElementById('defaultIcon');
                    const previewImg = document.getElementById('previewImg');
                    const removeBtn = document.getElementById('removePhotoBtn');
                    const previewContainer = document.getElementById('photoPreview');

                    defaultIcon.classList.add('hidden');
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    removeBtn.classList.remove('hidden');

                    // Update preview container styling
                    previewContainer.classList.remove('border-dashed');
                    previewContainer.classList.add('border-solid', 'border-[#1363C6]');
                }

                reader.readAsDataURL(file);
            }
        }

        function removePhoto() {
            const photoInput = document.getElementById('photoInput');
            const defaultIcon = document.getElementById('defaultIcon');
            const previewImg = document.getElementById('previewImg');
            const removeBtn = document.getElementById('removePhotoBtn');
            const previewContainer = document.getElementById('photoPreview');

            photoInput.value = '';
            previewImg.src = '';
            previewImg.classList.add('hidden');
            defaultIcon.classList.remove('hidden');
            removeBtn.classList.add('hidden');

            // Reset preview container styling
            previewContainer.classList.add('border-dashed');
            previewContainer.classList.remove('border-solid', 'border-[#1363C6]');
        }

        // Form Validation
        document.getElementById('teamMemberForm').addEventListener('submit', function(e) {
            const nameInput = document.querySelector('input[name="name"]');

            if (!nameInput.value.trim()) {
                e.preventDefault();
                nameInput.focus();
                nameInput.classList.add('border-red-500');

                // Show error message
                if (!nameInput.nextElementSibling || !nameInput.nextElementSibling.classList.contains(
                        'text-red-500')) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'text-red-500 text-sm mt-2 flex items-center gap-1';
                    errorMsg.innerHTML = `
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Name is required
                    `;
                    nameInput.parentNode.appendChild(errorMsg);
                }
            }
        });
    </script>
</x-app-layout>
