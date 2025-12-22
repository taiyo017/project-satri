<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Edit Email Campaign') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Update campaign: <span class="font-semibold">{{ $emailCampaign->subject }}</span>
                </p>
            </div>

            <a href="{{ route('admin.email-campaigns.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Campaigns
            </a>
        </div>
    </x-slot>

    <div class="space-y-6" x-data="{ 
        showPreview: false,
        previewContent: '',
        previewSubject: '',
        updatePreview() {
            this.previewSubject = document.getElementById('subject').value || 'Email Subject';
            this.previewContent = document.getElementById('content').value || '<p>Your email content will appear here...</p>';
        }
    }">
        <!-- Error Summary -->
        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-red-800 dark:text-red-300 font-semibold mb-2">Please fix the following errors:
                        </h3>
                        <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-400 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.email-campaigns.update', $emailCampaign) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content (Left - 2 columns) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Campaign Details -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Campaign Details</h3>
                            </div>
                        </div>

                        <div class="p-6 space-y-5">

                            <!-- Subject -->
                            <div>
                                <label for="subject"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Email Subject
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="subject" id="subject" required
                                        value="{{ old('subject', $emailCampaign->subject) }}"
                                        @input="updatePreview()"
                                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors"
                                        placeholder="e.g. New Job Opportunities This Week">
                                </div>
                                @error('subject')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                                    Make it compelling to increase open rates
                                </p>
                            </div>

                            <!-- Content -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label for="content"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Email Content (HTML)
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <button type="button" @click="showPreview = !showPreview; updatePreview()"
                                        class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span x-text="showPreview ? 'Hide Preview' : 'Show Preview'"></span>
                                    </button>
                                </div>
                                <textarea name="content" id="content" rows="15" required
                                    @input="updatePreview()"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors resize-none font-mono text-sm"
                                    placeholder="<h2>Hello!</h2><p>Your email content here...</p>">{{ old('content', $emailCampaign->content) }}</textarea>
                                @error('content')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                                    Use HTML tags for formatting. The content will be wrapped in email template
                                    automatically.
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Preview (Conditional) -->
                    <div x-show="showPreview" x-transition
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Email Preview</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div class="mb-3 pb-3 border-b border-gray-300 dark:border-gray-600">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Subject:</p>
                                    <p class="font-semibold text-gray-900 dark:text-white" x-text="previewSubject"></p>
                                </div>
                                <div class="prose prose-sm dark:prose-invert max-w-none" x-html="previewContent"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar (Right - 1 column) -->
                <div class="space-y-6">

                    <!-- Campaign Statistics -->
                    @if($emailCampaign->status === 'sent')
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">Performance</h3>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <div class="text-2xl font-bold text-blue-700 dark:text-blue-400">
                                        {{ $emailCampaign->sent_count }}
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Sent</div>
                                </div>
                                <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                    <div class="text-2xl font-bold text-green-700 dark:text-green-400">
                                        {{ $emailCampaign->open_rate }}%
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Opens</div>
                                </div>
                                <div class="text-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
                                    <div class="text-2xl font-bold text-purple-700 dark:text-purple-400">
                                        {{ $emailCampaign->click_rate }}%
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Clicks</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="text-2xl font-bold text-gray-700 dark:text-gray-300">
                                        {{ $emailCampaign->sent_at ? $emailCampaign->sent_at->diffForHumans() : 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Sent</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Target Audience -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">Target Audience</h3>
                            </div>
                        </div>

                        <div class="p-6">
                            <label for="subscription_topic_id"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Subscription Topic
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="subscription_topic_id" id="subscription_topic_id" required
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors">
                                <option value="">Select a topic</option>
                                @foreach ($topics as $topic)
                                    <option value="{{ $topic->id }}"
                                        {{ old('subscription_topic_id', $emailCampaign->subscription_topic_id) == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->name }} ({{ $topic->activeSubscribers()->count() }} subscribers)
                                    </option>
                                @endforeach
                            </select>
                            @error('subscription_topic_id')
                                <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                                Campaign will be sent to all active subscribers of this topic
                            </p>
                        </div>
                    </div>

                    <!-- Campaign Settings -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">Settings</h3>
                            </div>
                        </div>

                        <div class="p-6 space-y-5">

                            <!-- Status -->
                            <div>
                                <label for="status"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Campaign Status
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" required
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors">
                                    <option value="draft" {{ old('status', $emailCampaign->status) == 'draft' ? 'selected' : '' }}>Save as Draft
                                    </option>
                                    <option value="scheduled" {{ old('status', $emailCampaign->status) == 'scheduled' ? 'selected' : '' }}>
                                        Schedule for Later</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Scheduled Date (Conditional) -->
                            <div id="scheduled_at_field" style="display: none;">
                                <label for="scheduled_at"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Schedule For
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="scheduled_at" id="scheduled_at"
                                    value="{{ old('scheduled_at', $emailCampaign->scheduled_at ? $emailCampaign->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors">
                                @error('scheduled_at')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                                    Campaign will be sent automatically at this time
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98]"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Update Campaign
                        </button>

                        <a href="{{ route('admin.email-campaigns.show', $emailCampaign) }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- Toggle scheduled field -->
    <script>
        document.getElementById('status').addEventListener('change', function() {
            const scheduledField = document.getElementById('scheduled_at_field');
            const scheduledInput = document.getElementById('scheduled_at');
            if (this.value === 'scheduled') {
                scheduledField.style.display = 'block';
                scheduledInput.required = true;
            } else {
                scheduledField.style.display = 'none';
                scheduledInput.required = false;
            }
        });

        // Trigger on page load
        document.getElementById('status').dispatchEvent(new Event('change'));
    </script>
</x-app-layout>
