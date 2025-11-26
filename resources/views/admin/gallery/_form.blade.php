@php
    $isEdit = isset($gallery);
@endphp

<div class="max-w-4xl mx-auto">
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-xl p-5 animate-shake">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/40 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-red-800 dark:text-red-300 font-bold text-lg mb-2">Please fix the following errors:
                    </h3>
                    <ul class="space-y-1.5">
                        @foreach ($errors->all() as $err)
                            <li class="flex items-start gap-2 text-red-700 dark:text-red-400 text-sm">
                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ $err }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">
                        {{ $isEdit ? 'Edit Gallery Image' : 'Add New Gallery Image' }}</h2>
                    <p class="text-blue-100 text-sm mt-1">
                        {{ $isEdit ? 'Update your gallery image details' : 'Upload and configure your new image' }}</p>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="p-8 space-y-8">

            <!-- Image Upload Section - FIRST -->
            <div class="space-y-4">
                <label class="block">
                    <span class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Gallery Image
                        @if (!$isEdit)
                            <span class="text-red-500">*</span>
                        @endif
                    </span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 mt-1 block">
                        Upload a high-quality image (Max: 10MB, Formats: JPG, PNG, GIF, WebP)
                    </span>
                </label>

                <!-- Drag & Drop Upload Area -->
                <div id="dropzone"
                    class="relative border-3 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-8 text-center transition-all duration-300 hover:border-blue-500 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 cursor-pointer group {{ $isEdit && $gallery->image ? 'hidden' : '' }}">
                    <input type="file" id="imageInput" name="image" accept="image/*"
                        @if (!$isEdit) required @endif
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                        onchange="handleFileSelect(event)">

                    <div class="space-y-4">
                        <div
                            class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/40 dark:to-blue-800/40 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                <span class="text-blue-600 dark:text-blue-400">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                PNG, JPG, GIF, WebP up to 10MB
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Image Preview -->
                <div id="previewContainer" class="relative {{ $isEdit && $gallery->image ? '' : 'hidden' }}">
                    <div class="relative group">
                        <img id="preview"
                            src="{{ $isEdit && $gallery->image ? asset('storage/' . $gallery->image) : '' }}"
                            class="w-full max-h-96 object-contain rounded-2xl shadow-lg border-4 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">

                        <!-- Image Overlay Controls -->
                        <div
                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl flex items-center justify-center gap-4">
                            <button type="button" onclick="document.getElementById('imageInput').click()"
                                class="px-4 py-2 bg-white text-gray-800 rounded-lg font-medium hover:bg-gray-100 transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Change Image
                            </button>
                            <button type="button" onclick="removeImage()"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Remove
                            </button>
                        </div>
                    </div>

                    <!-- Image Info -->
                    <div id="imageInfo"
                        class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span id="fileName" class="font-medium text-gray-700 dark:text-gray-300"></span>
                            <span id="fileSize" class="text-gray-500 dark:text-gray-400"></span>
                        </div>
                    </div>
                </div>

                @error('image')
                    <p class="text-red-600 dark:text-red-400 text-sm flex items-center gap-2 mt-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700"></div>

            <!-- Basic Information Section -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Basic Information
                </h3>

                <!-- Title -->
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title"
                        value="{{ old('title', $gallery->title ?? '') }}" required
                        placeholder="Enter a descriptive title..."
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    @error('title')
                        <p class="text-red-600 dark:text-red-400 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="space-y-2">
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Category (Optional)
                    </label>
                    <select id="category_id" name="category_id"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="" {{ old('category_id', $gallery->category_id ?? '') ? '' : 'selected' }}>
                            -- Select Category --
                        </option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $gallery->category_id ?? '') == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-600 dark:text-red-400 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Description (Optional)
                    </label>
                    <textarea id="description" name="description" rows="4" placeholder="Add a description for this image..."
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none">{{ old('description', $gallery->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-600 dark:text-red-400 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700"></div>

            <!-- Settings Section -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                </h3>

                <!-- Active Status Toggle -->
                <div
                    class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="flex-1">
                        <label class="text-sm font-semibold text-gray-900 dark:text-white block">Active Status</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Make this image visible in the gallery
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                            {{ old('is_active', $gallery->is_active ?? true) ? 'checked' : '' }}>
                        <div
                            class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                    </label>
                </div>

                <!-- Order (Optional) -->
                <div class="space-y-2">
                    <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Display Order (Optional)
                    </label>
                    <input type="number" id="order" name="order"
                        value="{{ old('order', $gallery->order ?? 0) }}" min="0" placeholder="0"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Lower numbers appear first in the gallery</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit"
                    class="flex-1 px-6 py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ $isEdit ? 'Update Image' : 'Add Image' }}
                </button>

                <a href="{{ route('galleries.index') }}"
                    class="px-6 py-3.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-bold rounded-xl transition-all duration-200 hover:shadow-md">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // File handling
    let selectedFile = null;

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Validate file size (10MB)
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        if (file.size > maxSize) {
            const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
            showNotification(`⚠️ Image is too large (${fileSizeMB}MB). Maximum size is 10MB.`, 'error');
            event.target.value = '';
            return;
        }

        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type.toLowerCase())) {
            showNotification('⚠️ Invalid file type. Please upload JPG, PNG, GIF, or WebP images only.', 'error');
            event.target.value = '';
            return;
        }

        selectedFile = file;
        previewImage(file);
        showNotification('✅ Image selected successfully!', 'success');
    }

    function previewImage(file) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('previewContainer');
        const dropzone = document.getElementById('dropzone');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');

        // Show preview, hide dropzone
        previewContainer.classList.remove('hidden');
        dropzone.classList.add('hidden');

        // Set image preview
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Update file info
        fileName.textContent = file.name;
        fileSize.textContent = '(' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
    }

    function removeImage() {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('previewContainer');
        const dropzone = document.getElementById('dropzone');
        const imageInput = document.getElementById('imageInput');

        // Reset
        previewContainer.classList.add('hidden');
        dropzone.classList.remove('hidden');
        preview.src = '';
        imageInput.value = '';
        selectedFile = null;
    }

    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-[100] px-6 py-4 rounded-xl shadow-2xl animate-slide-in ${
            type === 'success' 
                ? 'bg-green-600 text-white' 
                : 'bg-red-600 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' 
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>' 
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'
                    }
                </svg>
                <span class="font-medium">${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Drag and drop functionality
    const dropzone = document.getElementById('dropzone');

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('imageInput').files = files;
            handleFileSelect({
                target: {
                    files: files
                }
            });
        }
    });

    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            const title = document.getElementById('title')?.value.trim();
            const imageInput = document.getElementById('imageInput');
            const isEdit = {{ $isEdit ? 'true' : 'false' }};

            if (!title) {
                e.preventDefault();
                alert('⚠️ Please enter a title for your gallery image');
                document.getElementById('title')?.focus();
                return false;
            }

            if (!isEdit && imageInput && !imageInput.files.length) {
                e.preventDefault();
                alert('⚠️ Please select an image to upload');
                imageInput.click();
                return false;
            }
        });
    });
</script>

<style>
    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-10px);
        }

        75% {
            transform: translateX(10px);
        }
    }

    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }

    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
        transition: all 0.3s ease-out;
    }

    /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
        width: 8px;
    }

    textarea::-webkit-scrollbar-track {
        background: transparent;
    }

    textarea::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    textarea::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Drag and drop hover effect */
    #dropzone.dragover {
        border-color: #3b82f6 !important;
        background-color: rgba(59, 130, 246, 0.1) !important;
    }
</style>
