@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                Edit Gallery Item
            </h2>

            <a href="{{ route('galleries.index') }}"
                class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition">
                ← Back
            </a>
        </div>

        <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.gallery._form', ['gallery' => $gallery])
        </form>

    </div>
@endsection

@section('scripts')
    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            preview.classList.remove("hidden");
            preview.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
