<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xs text-gray-700 dark:text-gray-200">Edit Gallery Category</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('gallery-categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.gallery_category._form')
        </form>
    </div>
</x-app-layout>
