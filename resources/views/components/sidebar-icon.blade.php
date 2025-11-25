@props(['icon'])

@switch($icon)
    @case('grid')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h4a1 1 0 001-1v-4h4v4a1 1 0 001 1h4a1 1 0 001-1V10" />
        </svg>
    @break

    @case('settings')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.591 1.15c1.518-.878 3.303.907 2.425 2.425a1.724 1.724 0 001.15 2.591c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.15 2.591c.878 1.518-.907 3.303-2.425 2.425a1.724 1.724 0 00-2.591 1.15c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.591-1.15c-1.518.878-3.303-.907-2.425-2.425a1.724 1.724 0 00-1.15-2.591c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.15-2.591c-.878-1.518.907-3.303 2.425-2.425a1.724 1.724 0 002.591-1.15z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
    @break

    @case('contact')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.5v7a2 2 0 002 2h14a2 2 0 002-2v-7" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.5l-9 6-9-6" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6.5a2 2 0 012-2h14a2 2 0 012 2" />
        </svg>
    @break

    @case('pages')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 12h6M9 16h6M9 8h3m4-4H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V8l-4-4z" />
        </svg>
    @break

    @case('services')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 7h18M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l3-3h12l3 3M9 17h6" />
        </svg>
    @break

    @case('projects')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 7h4l2-3h10a2 2 0 012 2v3H3V7zm0 5h18v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5z" />
        </svg>
    @break

    @case('blogs')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 6v12m0-12a3 3 0 00-3 3v9a3 3 0 013-3m0-9a3 3 0 013 3v9a3 3 0 00-3-3" />
        </svg>
    @break

    @case('courses')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v6m0 0l4-2m-4 2l-4-2" />
        </svg>
    @break

    @case('team')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M23 20v-2a4 4 0 00-3-3.87" />
            <circle cx="17" cy="7" r="4" />
        </svg>
    @break

    @case('testimonials')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-4.2-7.5L21 3l-2.5 3A8.96 8.96 0 0121 12z" />
        </svg>
    @break

    @case('careers')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 7h16v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7zm3-3h10v3H7V4z" />
        </svg>
    @break

    @case('faqs')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.09 9a3 3 0 115.82 0c0 1.657-3 2.25-3 4m.01 4h.01" />
        </svg>
    @break

    @case('user')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
            <circle cx="12" cy="7" r="4" />
        </svg>
    @break

    @case('edit')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
        </svg>
    @break

    @case('table')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path
                d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18" />
        </svg>
    @break

    @case('file-text')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
            <polyline points="14,2 14,8 20,8" />
            <line x1="16" y1="13" x2="8" y2="13" />
            <line x1="16" y1="17" x2="8" y2="17" />
            <polyline points="10,9 9,9 8,9" />
        </svg>
    @break

    @case('lock')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
            <circle cx="12" cy="16" r="1" />
            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
        </svg>
    @break

    @default
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <path d="m9 12 2 2 4-4" />
        </svg>
@endswitch
