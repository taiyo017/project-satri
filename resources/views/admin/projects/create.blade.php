<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Add New Project') }}
                </h2>
                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                    Add a new project to showcase on your website
                </p>
            </div>
            <a href="{{ route('projects.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Project') }}
            </a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.projects.form', ['project' => null, 'button' => 'Create Project'])
        </form>
    </div>
</x-app-layout>
