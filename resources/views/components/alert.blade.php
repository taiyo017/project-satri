@props([
    'type' => 'info',
    'title' => null,
    'message' => null,
    'link' => null,
    'linkText' => 'Learn more',
    'dismissible' => true,
    'autoClose' => true,
    'duration' => 5000,
])

@php
    $styles = [
        'success' => [
            'bg' => 'bg-gradient-to-r from-green-50 to-emerald-50',
            'border' => 'border-l-4 border-green-500',
            'icon' => 'text-green-600',
            'title' => 'text-green-900',
            'text' => 'text-green-700',
            'link' => 'text-green-600 hover:text-green-800',
            'progress' => 'bg-green-500',
            'defaultTitle' => 'Success!',
        ],
        'error' => [
            'bg' => 'bg-gradient-to-r from-red-50 to-rose-50',
            'border' => 'border-l-4 border-red-500',
            'icon' => 'text-red-600',
            'title' => 'text-red-900',
            'text' => 'text-red-700',
            'link' => 'text-red-600 hover:text-red-800',
            'progress' => 'bg-red-500',
            'defaultTitle' => 'Error!',
        ],
        'warning' => [
            'bg' => 'bg-gradient-to-r from-yellow-50 to-amber-50',
            'border' => 'border-l-4 border-yellow-500',
            'icon' => 'text-yellow-600',
            'title' => 'text-yellow-900',
            'text' => 'text-yellow-700',
            'link' => 'text-yellow-600 hover:text-yellow-800',
            'progress' => 'bg-yellow-500',
            'defaultTitle' => 'Warning!',
        ],
        'info' => [
            'bg' => 'bg-gradient-to-r from-blue-50 to-sky-50',
            'border' => 'border-l-4 border-[#1A66C5]',
            'icon' => 'text-[#1A66C5]',
            'title' => 'text-blue-900',
            'text' => 'text-blue-700',
            'link' => 'text-[#1A66C5] hover:text-[#2E7FDB]',
            'progress' => 'bg-[#1A66C5]',
            'defaultTitle' => 'Info',
        ],
    ];

    $style = $styles[$type] ?? $styles['info'];
@endphp

<div x-data="{
    show: true,
    progress: 100,
    interval: null,
    init() {
        if ({{ $autoClose ? 'true' : 'false' }}) {
            this.startTimer();
        }
    },
    startTimer() {
        const duration = {{ $duration }};
        const step = 100 / (duration / 100);

        this.interval = setInterval(() => {
            this.progress -= step;
            if (this.progress <= 0) {
                this.close();
            }
        }, 100);
    },
    close() {
        clearInterval(this.interval);
        this.show = false;
    },
    pauseTimer() {
        if (this.interval) {
            clearInterval(this.interval);
        }
    },
    resumeTimer() {
        if ({{ $autoClose ? 'true' : 'false' }} && this.show) {
            this.startTimer();
        }
    }
}" x-show="show" x-transition:enter="transform transition ease-out duration-300"
    x-transition:enter-start="translate-y-2 opacity-0 scale-95"
    x-transition:enter-end="translate-y-0 opacity-100 scale-100"
    x-transition:leave="transform transition ease-in duration-200"
    x-transition:leave-start="translate-y-0 opacity-100 scale-100"
    x-transition:leave-end="translate-y-2 opacity-0 scale-95" @mouseenter="pauseTimer()" @mouseleave="resumeTimer()"
    role="alert"
    {{ $attributes->merge(['class' => "relative overflow-hidden rounded-xl shadow-lg {$style['bg']} {$style['border']} my-4"]) }}>

    <div class="flex items-start gap-4 p-5">
        {{-- Icon --}}
        <div class="flex-shrink-0 mt-0.5">
            @switch($type)
                @case('success')
                    <div class="p-1.5 rounded-full bg-green-100">
                        <svg class="w-5 h-5 {{ $style['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                        </svg>
                    </div>
                @break

                @case('error')
                    <div class="p-1.5 rounded-full bg-red-100">
                        <svg class="w-5 h-5 {{ $style['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0a9 9 0 0118 0z" />
                        </svg>
                    </div>
                @break

                @case('warning')
                    <div class="p-1.5 rounded-full bg-yellow-100">
                        <svg class="w-5 h-5 {{ $style['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 9v2m0 4h.01M4.93 19h14.14c1.3 0 2.07-1.45 1.43-2.53L13.43 4.47c-.64-1.08-2.22-1.08-2.86 0L3.5 16.47C2.86 17.55 3.63 19 4.93 19z" />
                        </svg>
                    </div>
                @break

                @case('info')
                    <div class="p-1.5 rounded-full bg-blue-100">
                        <svg class="w-5 h-5 {{ $style['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16a8 8 0 000 16z" />
                        </svg>
                    </div>
                @break
            @endswitch
        </div>

        {{-- Content --}}
        <div class="flex-1 min-w-0">
            <p class="font-semibold {{ $style['title'] }} text-sm">
                {{ $title ?? $style['defaultTitle'] }}
            </p>

            @if ($message)
                <p class="text-sm mt-1 {{ $style['text'] }} leading-relaxed">
                    {{ $message }}
                </p>
            @endif

            @if ($link)
                <a href="{{ $link }}"
                    class="inline-flex items-center gap-1 mt-2 text-sm font-medium {{ $style['link'] }} transition-colors duration-200">
                    {{ $linkText }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @endif
        </div>

        {{-- Dismiss Button --}}
        @if ($dismissible)
            <button @click="close()" type="button"
                class="flex-shrink-0 ml-4 p-1.5 rounded-lg {{ $style['text'] }} hover:bg-white/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $type === 'info' ? '[#1A66C5]' : $type }}-500 transition-all duration-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>

    {{-- Progress Bar --}}
    @if ($autoClose)
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-white/30">
            <div class="h-full {{ $style['progress'] }} transition-all duration-100 ease-linear"
                :style="`width: ${progress}%`"></div>
        </div>
    @endif
</div>
