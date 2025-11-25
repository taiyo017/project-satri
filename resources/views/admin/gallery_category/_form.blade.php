@php $isEdit = isset($category); @endphp

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
    @if ($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-4">
            <ul class="list-disc list-inside text-red-700 dark:text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-5">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required
            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
    </div>

    <div class="mb-5">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
        <textarea name="description" rows="3"
            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <div class="mb-5 flex items-center gap-3">
        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</label>
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                {{ old('is_active', $category->is_active ?? 1) ? 'checked' : '' }}>
            <div
                class="w-11 h-6 bg-gray-300 dark:bg-gray-700 rounded-full peer peer-checked:bg-emerald-600 transition-all">
            </div>
        </label>
    </div>

    <div class="mt-6">
        <button type="submit"
            class="px-6 py-2 bg-emerald-600 text-black font-semibold rounded-lg hover:bg-emerald-700 transition">
            {{ $isEdit ? 'Update Category' : 'Create Category' }}
        </button>
    </div>
</div>
