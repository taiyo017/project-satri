@props(['text' => 'Learn More', 'url' => '#'])

<a href="{{ $url }}"
    class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold 
          border-2 border-[#1363C6]/40 dark:border-[#4CAFF9]/40
          text-gray-900 dark:text-white transition-all duration-300
          hover:scale-105 hover:border-[#1363C6]/60 dark:hover:border-[#4CAFF9]/60">

    {{ $text }}

    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>

</a>
