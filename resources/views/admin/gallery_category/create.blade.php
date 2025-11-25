<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold">Create Gallery Category</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('gallery-categories.store') }}" method="POST">
            @csrf
            @include('admin.gallery_category._form')
        </form>
    </div>
</x-app-layout>
