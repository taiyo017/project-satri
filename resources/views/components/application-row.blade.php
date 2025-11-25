@props(['application'])

<tr
    class="transition-colors duration-150 {{ !$application->is_read ? 'bg-blue-50 dark:bg-blue-900/10' : 'hover:bg-gray-50 dark:hover:bg-gray-700/30' }}">

    <!-- Applicant Info -->
    <td class="px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-semibold text-white flex-shrink-0"
                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                {{ strtoupper(substr($application->name, 0, 1)) }}
            </div>
            <div class="flex flex-col min-w-0">
                <span
                    class="font-semibold text-gray-900 dark:text-white text-sm {{ !$application->is_read ? 'font-bold' : '' }}">
                    {{ $application->name }}
                </span>
                @if (!$application->is_read)
                    <span class="flex items-center gap-1 text-xs text-blue-600 dark:text-blue-400 mt-0.5">
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                        New Application
                    </span>
                @endif
            </div>
        </div>
    </td>

    <!-- Contact Info -->
    <td class="px-6 py-4">
        <div class="flex flex-col gap-1">
            <a href="mailto:{{ $application->email }}"
                class="text-sm text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                {{ Str::limit($application->email, 25) }}
            </a>
            <a href="tel:{{ $application->phone }}"
                class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                {{ $application->phone }}
            </a>
        </div>
    </td>

    <!-- Documents -->
    <td class="px-6 py-4">
        <div class="flex flex-col gap-2">
            @if ($application->resume)
                <button type="button"
                    @click="openPreviewModal('{{ asset('storage/' . $application->resume) }}', 'resume', '{{ $application->name }}')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-medium hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors w-fit">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Resume
                </button>
            @endif
            @if ($application->cover_letter)
                <button type="button"
                    @click="openPreviewModal('{{ asset('storage/' . $application->cover_letter) }}', 'cover', '{{ $application->name }}')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 text-xs font-medium hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors w-fit">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Cover Letter
                </button>
            @endif
            @if (!$application->resume && !$application->cover_letter)
                <span class="text-xs text-gray-400 dark:text-gray-500 italic">No documents</span>
            @endif
        </div>
    </td>

    <!-- Status -->
    <td class="px-6 py-4">
        @if ($application->is_read)
            <span
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                Read
            </span>
        @else
            <span
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-medium">
                <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                Unread
            </span>
        @endif
    </td>

    <!-- Actions -->
    <td class="px-6 py-4">
        <div class="flex items-center justify-end gap-2">
            <!-- Forward Email Button -->
            <button type="button"
                @click="openMailModal({{ $application->id }}, '{{ $application->email }}', '{{ $application->name }}')"
                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors text-xs font-medium"
                title="Forward Email">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="hidden sm:inline">Forward</span>
            </button>

        </div>
    </td>

</tr>
