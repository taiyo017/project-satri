@php $isEdit = isset($category); @endphp

<div class="max-w-3xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ $isEdit ? 'Edit Category' : 'Create Category' }}
        </h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ $isEdit ? 'Update the category details below.' : 'Fill in the information to create a new category.' }}
        </p>
    </div>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-1">
                        There were {{ count($errors) }} error(s) with your submission
                    </h3>
                    <ul class="text-sm text-red-700 dark:text-red-400 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">

        <div class="p-6 space-y-6">

            {{-- Category Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}"
                    required placeholder="e.g., Technology, Nature, Business"
                    class="block w-full px-4 py-3 text-gray-900 dark:text-gray-100 
                           bg-white dark:bg-gray-900 
                           border border-gray-300 dark:border-gray-600 rounded-lg
                           placeholder:text-gray-400 dark:placeholder:text-gray-500
                           focus:ring-2 focus:ring-[#1A67C6] focus:border-[#1A67C6]
                           transition-all duration-200">
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                    Choose a clear, descriptive name for this category
                </p>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Description <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                </label>
                <textarea id="description" name="description" rows="4"
                    placeholder="Provide additional details about this category..."
                    class="block w-full px-4 py-3 text-gray-900 dark:text-gray-100 
                           bg-white dark:bg-gray-900 
                           border border-gray-300 dark:border-gray-600 rounded-lg
                           placeholder:text-gray-400 dark:placeholder:text-gray-500
                           focus:ring-2 focus:ring-[#1A67C6] focus:border-[#1A67C6]
                           transition-all duration-200 resize-none">{{ old('description', $category->description ?? '') }}</textarea>
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                    Help others understand what this category is for
                </p>
            </div>

            {{-- Status Toggle --}}
            {{-- Status Toggle --}}
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <label for="is_active" class="block text-sm font-semibold text-gray-900 dark:text-white">
                            Status
                        </label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Control whether this category is active and visible
                        </p>
                    </div>

                    {{-- Toggle Switch --}}
                    <label for="is_active" class="inline-flex relative items-center cursor-pointer ml-4">
                        <input type="checkbox" id="is_active" name="is_active" value="1" class="sr-only peer"
                            {{ old('is_active', $category->is_active ?? 1) ? 'checked' : '' }}>
                        <span
                            class="w-12 h-6 bg-gray-300 dark:bg-gray-600 rounded-full peer 
                         peer-checked:bg-[#1A67C6] 
                         peer-focus:ring-4 peer-focus:ring-[#1A67C6]/20
                         relative after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                         after:bg-white after:border after:border-gray-300 after:rounded-full 
                         after:h-5 after:w-5 after:transition-all
                         peer-checked:after:translate-x-6 peer-checked:after:border-white">
                        </span>
                    </label>
                </div>
            </div>


        </div>

        {{-- Form Actions --}}
        <div
            class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700 
                    flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
            <a href="{{ route('gallery-categories.index') }}"
                class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium 
                       text-gray-700 dark:text-gray-300 
                       bg-white dark:bg-gray-800 
                       border border-gray-300 dark:border-gray-600 
                       rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700
                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300
                       transition-colors duration-200">
                Cancel
            </a>
            <x-primary-button type="submit"
                class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium rounded-full 
                       hover:bg-[#155aaf] 
                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1A67C6]
                       transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if ($isEdit)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    @endif
                </svg>
                {{ $isEdit ? 'Update Category' : 'Create Category' }}
            </x-primary-button>
        </div>

    </div>

</div>
