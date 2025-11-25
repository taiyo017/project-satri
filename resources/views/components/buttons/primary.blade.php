@props(['text' => 'Button', 'url' => '#'])

<a href="{{ $url }}"
    class="relative inline-flex items-center gap-2 px-8 py-4 rounded-full border border-white font-semibold text-white 
          bg-blue-500 transition-all duration-300 
          hover:scale-105 shadow-lg hover:shadow-xl">

    {{ $text }}

    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
    </svg>

</a>
