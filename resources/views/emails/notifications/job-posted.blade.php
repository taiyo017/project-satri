<h2 style="color: #2563eb; margin-bottom: 20px;">{{ $job->title }}</h2>

<div style="margin: 20px 0;">
    <p><strong>Location:</strong> {{ $job->location }}</p>
    <p><strong>Type:</strong> {{ $job->type }}</p>
    @if($job->jobCategory)
        <p><strong>Category:</strong> {{ $job->jobCategory->name }}</p>
    @endif
</div>

<div style="margin: 20px 0;">
    {!! $job->description !!}
</div>

<p style="margin-top: 30px;">We're excited to have you consider this opportunity!</p>
