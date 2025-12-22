<h2 style="color: #2563eb; margin-bottom: 20px;">{{ $course->title }}</h2>

@if($course->image_path)
    <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" style="max-width: 100%; height: auto; border-radius: 5px; margin: 20px 0;">
@endif

<div style="margin: 20px 0;">
    @if($course->category)
        <p><strong>Category:</strong> {{ $course->category->name }}</p>
    @endif
    @if($course->duration)
        <p><strong>Duration:</strong> {{ $course->duration }}</p>
    @endif
    @if($course->price)
        <p><strong>Price:</strong> ${{ number_format($course->price, 2) }}</p>
    @endif
</div>

<div style="margin: 20px 0;">
    {!! $course->description !!}
</div>

<p style="margin-top: 30px;">Enroll now and start your learning journey!</p>
