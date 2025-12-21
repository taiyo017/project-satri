<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('job-categories.index') }}"
                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Edit Job Category') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Update job category: {{ $jobCategory->name }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('job-categories.update', $jobCategory) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.job_categories.form', ['category' => $jobCategory, 'button' => 'Update Category'])
        </form>
    </div>
</x-app-layout>
