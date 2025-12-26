<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $page->title }} - Page Builder
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Build and customize your page sections
                </p>
            </div>
            <a href="{{ route('pages.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Pages
            </a>
        </div>
    </x-slot>

    <div class="space-y-6" x-data="pageBuilder()" x-init="init()">

        {{-- Toast Notification --}}
        <div x-show="toast.show" x-transition @click="toast.show = false"
            :class="{
                'bg-green-500': toast.type === 'success',
                'bg-red-500': toast.type === 'error',
                'bg-blue-500': toast.type === 'info',
                'bg-yellow-500': toast.type === 'warning'
            }"
            class="fixed top-6 right-6 px-6 py-4 text-white rounded-xl shadow-2xl cursor-pointer z-50 max-w-md">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-medium" x-text="toast.message"></p>
            </div>
        </div>

        {{-- Loading Overlay --}}
        <div x-show="loading" x-cloak
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl text-center">
                <div
                    class="animate-spin rounded-full h-16 w-16 border-4 border-blue-200 border-t-blue-600 mx-auto mb-4">
                </div>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Processing...</p>
            </div>
        </div>

        {{-- Add New Section Card --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-white dark:from-gray-800 dark:to-gray-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Section
                </h3>
            </div>
            <div class="p-6">
                <form @submit.prevent="addSection" class="flex flex-col sm:flex-row gap-3">
                    <select x-model="newSectionType" required
                        class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                        <option value="">Select Section Type</option>
                        @foreach ($sectionTypes as $key => $template)
                            <option value="{{ $key }}">{{ $template['name'] }}</option>
                        @endforeach
                    </select>
                    <button type="submit" :disabled="loading || !newSectionType"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-white font-semibold rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <div x-show="loading"
                            class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        <span x-text="loading ? 'Adding...' : 'Add Section'"></span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Sections List --}}
        <div class="space-y-6" x-show="sections.length > 0">
            <template x-for="(section, sectionIndex) in sections" :key="section.id">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-2 border-gray-200 dark:border-gray-700 hover:border-blue-400 transition-all overflow-hidden">

                    {{-- Section Header --}}
                    <div
                        class="flex flex-wrap items-center justify-between gap-4 p-5 bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-xl flex items-center justify-center bg-blue-100 dark:bg-blue-900/30">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8h16M4 16h16" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg"
                                    x-text="getSectionName(section.section_type)"></h3>
                                <div class="flex items-center gap-3 text-xs mt-1">
                                    <span
                                        class="px-2 py-0.5 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                                        #<span x-text="sectionIndex + 1"></span>
                                    </span>
                                    <span x-show="section.modified"
                                        class="px-2 py-0.5 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 font-medium">
                                        Modified
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button @click="moveSectionUp(sectionIndex)" x-show="sectionIndex > 0"
                                :disabled="loading"
                                class="p-2 rounded-lg text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all disabled:opacity-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                            </button>

                            <button @click="moveSectionDown(sectionIndex)" x-show="sectionIndex < sections.length - 1"
                                :disabled="loading"
                                class="p-2 rounded-lg text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all disabled:opacity-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600"></div>

                            <button @click="toggleEdit(section)" :disabled="loading"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg transition-all"
                                :class="section.isEditing ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' :
                                    'bg-green-100 text-green-700 hover:bg-green-200'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path x-show="!section.isEditing" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    <path x-show="section.isEditing" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <button @click="deleteSection(section.id, sectionIndex)" :disabled="loading"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Edit Mode --}}
                    <div x-show="section.isEditing" x-transition class="p-6 space-y-6">
                        <template x-for="(field, fieldIndex) in section.fields"
                            :key="`field-${section.id}-${field.id}`">
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                                    <span x-text="formatFieldLabel(field.field_key)"></span>
                                    <span x-show="field.field_type" class="text-xs text-gray-500 font-normal ml-auto"
                                        x-text="'(' + field.field_type + ')'"></span>
                                </label>

                                {{-- Text/URL Input --}}
                                <template x-if="field.field_type === 'text' || field.field_type === 'url'">
                                    <input :type="field.field_type === 'url' ? 'url' : 'text'"
                                        x-model="field.field_value" @input="markSectionModified(section)"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                                </template>

                                {{-- Textarea --}}
                                <template x-if="field.field_type === 'textarea'">
                                    <textarea x-model="field.field_value" @input="markSectionModified(section)" rows="4"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600"></textarea>
                                </template>

                                {{-- WYSIWYG --}}
                                <template x-if="field.field_type === 'wysiwyg'">
                                    <textarea x-model="field.field_value" @input="markSectionModified(section)" rows="8"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 font-mono text-sm"
                                        placeholder="Enter HTML content..."></textarea>
                                </template>

                                {{-- Icon --}}
                                <template x-if="field.field_type === 'icon'">
                                    <input type="text" x-model="field.field_value"
                                        @input="markSectionModified(section)"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600"
                                        placeholder="e.g., fa-home or <svg>...</svg>">
                                </template>

                                {{-- Checkbox --}}
                                <template x-if="field.field_type === 'checkbox'">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                            :checked="field.field_value === '1' || field.field_value === 1 || field.field_value === true"
                                            @change="field.field_value = $event.target.checked ? '1' : '0'; markSectionModified(section)"
                                            class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300" x-text="(field.field_value === '1' || field.field_value === 1 || field.field_value === true) ? 'Yes' : 'No'"></span>
                                    </label>
                                </template>

                                {{-- Image/File Upload --}}
                                <template x-if="field.field_type === 'image' || field.field_type === 'file'">
                                    <div class="space-y-3">
                                        <div class="flex gap-3">
                                            <input type="file" @change="uploadFile($event, section, field)"
                                                :accept="field.field_type === 'image' ? 'image/*' : '*'"
                                                :disabled="field.uploading"
                                                class="flex-1 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer disabled:opacity-50">

                                            <button type="button" x-show="field.field_value"
                                                @click="clearFile(field, section)" :disabled="field.uploading"
                                                class="px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-colors disabled:opacity-50">
                                                Remove
                                            </button>
                                        </div>

                                        <!-- Upload Progress -->
                                        <div x-show="field.uploading" class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full transition-all"
                                                :style="`width: ${field.uploadPercent || 0}%`"></div>
                                        </div>

                                        <!-- Image Preview -->
                                        <template x-if="field.field_value && field.field_type === 'image'">
                                            <img :src="`/storage/${field.field_value}`"
                                                class="max-w-xs rounded-lg border-2 border-gray-200 shadow-sm"
                                                alt="Preview Image">
                                        </template>

                                        <!-- File Preview -->
                                        <template x-if="field.field_value && field.field_type === 'file'">
                                            <a :href="`/storage/${field.field_value}`" target="_blank"
                                                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                                </svg>
                                                View File
                                            </a>
                                        </template>
                                    </div>
                                </template>

                                {{-- Group Fields --}}
                                <template x-if="field.field_type === 'group'">
                                    <div
                                        class="p-5 bg-blue-50 dark:bg-gray-700 rounded-xl border-2 border-blue-200 dark:border-gray-600 space-y-4">
                                        <template x-for="(subfield, subIndex) in getGroupFields(field, section)"
                                            :key="`group-${field.id}-${subIndex}`">
                                            <div class="space-y-2">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                                    x-text="formatFieldLabel(subfield.key)"></label>

                                                <template x-if="subfield.type === 'text' || subfield.type === 'url'">
                                                    <input :type="subfield.type === 'url' ? 'url' : 'text'"
                                                        x-model="field.field_value[subfield.key]"
                                                        @input="markSectionModified(section)"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20">
                                                </template>

                                                <template x-if="subfield.type === 'textarea'">
                                                    <textarea x-model="field.field_value[subfield.key]" @input="markSectionModified(section)" rows="3"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20"></textarea>
                                                </template>

                                                <template x-if="subfield.type === 'wysiwyg'">
                                                    <textarea x-model="field.field_value[subfield.key]" @input="markSectionModified(section)" rows="6"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 font-mono text-sm"></textarea>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                {{-- Repeater Fields --}}
                                <template x-if="field.field_type === 'repeater'">
                                    <div class="space-y-4">
                                        <template x-for="(item, itemIdx) in field.field_value"
                                            :key="`repeater-${field.id}-${itemIdx}`">
                                            <div
                                                class="p-5 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600">
                                                <div class="flex items-center justify-between mb-4">
                                                    <span
                                                        class="text-sm font-semibold text-gray-700 dark:text-gray-300">Item
                                                        #<span x-text="itemIdx + 1"></span></span>
                                                    <button type="button"
                                                        @click="removeRepeaterItem(field, itemIdx, section)"
                                                        class="px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                        Remove
                                                    </button>
                                                </div>
                                                <div class="space-y-3">
                                                    <template
                                                        x-for="(subfield, subIdx) in getRepeaterFields(field, section)"
                                                        :key="`repeater-field-${field.id}-${itemIdx}-${subIdx}`">
                                                        <div class="space-y-1.5">
                                                            <label
                                                                class="block text-sm font-medium text-gray-600 dark:text-gray-400"
                                                                x-text="formatFieldLabel(subfield.key)"></label>

                                                            <template
                                                                x-if="subfield.type === 'text' || subfield.type === 'url'">
                                                                <input
                                                                    :type="subfield.type === 'url' ? 'url' : 'text'"
                                                                    x-model="item[subfield.key]"
                                                                    @input="markSectionModified(section)"
                                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 text-sm">
                                                            </template>

                                                            <template x-if="subfield.type === 'textarea'">
                                                                <textarea x-model="item[subfield.key]" @input="markSectionModified(section)" rows="3"
                                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 text-sm"></textarea>
                                                            </template>

                                                            <template x-if="subfield.type === 'wysiwyg'">
                                                                <textarea x-model="item[subfield.key]" @input="markSectionModified(section)" rows="6"
                                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 text-sm font-mono"></textarea>
                                                            </template>

                                                            <template x-if="subfield.type === 'icon'">
                                                                <input type="text" x-model="item[subfield.key]"
                                                                    @input="markSectionModified(section)"
                                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 text-sm"
                                                                    placeholder="e.g., fa-home">
                                                            </template>

                                                            <template x-if="subfield.type === 'image'">
                                                                <div class="space-y-2">
                                                                    <input type="file"
                                                                        @change="uploadRepeaterImage($event, field, item, subfield.key, section)"
                                                                        accept="image/*"
                                                                        :disabled="item[`${subfield.key}_uploading`]"
                                                                        class="w-full text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer disabled:opacity-50">

                                                                    <div x-show="item[`${subfield.key}_uploading`]"
                                                                        class="w-full bg-gray-200 rounded-full h-2">
                                                                        <div class="bg-blue-600 h-2 rounded-full transition-all"
                                                                            :style="`width: ${item[`${subfield.key}_percent`] || 0}%`">
                                                                        </div>
                                                                    </div>

                                                                    <template x-if="item[subfield.key]">
                                                                        <div class="flex items-start gap-3">
                                                                            <img :src="item[subfield.key]"
                                                                                class="w-24 h-24 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                                                            <button type="button"
                                                                                @click="clearRepeaterImage(item, subfield.key, section)"
                                                                                class="px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                                                Remove
                                                                            </button>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>

                                        <button type="button" @click="addRepeaterItem(field, section)"
                                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Add Item
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </template>

                        {{-- Save Button --}}
                        <div
                            class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" @click="toggleEdit(section)"
                                class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                                Cancel
                            </button>
                            <button type="button" @click="saveSection(section)"
                                :disabled="!section.modified || loading"
                                class="px-8 py-3 text-white font-semibold rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                                :class="section.modified && !loading ?
                                    'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800' :
                                    'bg-gray-400'">
                                <span x-text="section.modified ? 'Save Changes' : 'No Changes'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Locked View --}}
                    <div x-show="!section.isEditing" x-transition class="p-12 text-center">
                        <div
                            class="w-20 h-20 mx-auto mb-4 rounded-2xl flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2">Section Locked</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Click the Edit button to modify this
                            section</p>
                    </div>
                </div>
            </template>
        </div>

        {{-- Empty State --}}
        <div x-show="sections.length === 0" x-transition
            class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700">
            <div
                class="w-20 h-20 mx-auto mb-6 rounded-2xl flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Sections Yet</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Get started by adding your first section</p>
        </div>
    </div>

    @push('scripts')
        <script>
            function pageBuilder() {
                return {
                    sections: @json($sections),
                    newSectionType: '',
                    loading: false,
                    toast: {
                        show: false,
                        message: '',
                        type: 'success'
                    },
                    sectionTemplates: @json($sectionTypes),

                    // Initialize
                    init() {
                        const csrf = document.querySelector('meta[name="csrf-token"]');
                        if (csrf) axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf.content;
                        this.sections.forEach(section => this.initSection(section));
                    },

                    initSection(section) {
                        section.modified = false;
                        section.isEditing = false;
                        section.backup = null;
                        if (section.fields) {
                            section.fields.forEach(field => {
                                this.initializeFieldValue(field);
                                field.uploading = false;
                                field.uploadPercent = 0;
                            });
                        }
                    },

                    initializeFieldValue(field) {
                        if (field.field_type === 'repeater' && typeof field.field_value === 'string') {
                            try {
                                field.field_value = JSON.parse(field.field_value) || [];
                            } catch (e) {
                                field.field_value = [];
                            }
                        } else if (field.field_type === 'group' && typeof field.field_value === 'string') {
                            try {
                                field.field_value = JSON.parse(field.field_value) || {};
                            } catch (e) {
                                field.field_value = {};
                            }
                        }
                        if (field.field_value == null) field.field_value = '';
                    },

                    // Utility Functions
                    getSectionName(type) {
                        return this.sectionTemplates[type]?.name || type;
                    },

                    formatFieldLabel(key) {
                        return key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    },

                    showToast(message, type = 'success') {
                        this.toast = {
                            show: true,
                            message,
                            type
                        };
                        setTimeout(() => this.toast.show = false, 4000);
                    },

                    markSectionModified(section) {
                        section.modified = true;
                    },

                    // Edit Toggle
                    toggleEdit(section) {
                        if (section.isEditing) {
                            if (section.modified && !confirm('Discard unsaved changes?')) return;
                            if (section.backup) {
                                section.fields = JSON.parse(section.backup);
                                section.fields.forEach(field => this.initializeFieldValue(field));
                                section.modified = false;
                            }
                        } else {
                            section.backup = JSON.stringify(section.fields);
                        }
                        section.isEditing = !section.isEditing;
                    },

                    // Template Field Helpers
                    getRepeaterFields(field, section) {
                        const template = this.sectionTemplates[section.section_type];
                        if (template?.fields) {
                            const templateField = template.fields.find(f => f.key === field.field_key);
                            if (templateField?.fields) return templateField.fields;
                        }
                        return field.fields || [];
                    },

                    getGroupFields(field, section) {
                        const template = this.sectionTemplates[section.section_type];
                        if (template?.fields) {
                            const templateField = template.fields.find(f => f.key === field.field_key);
                            if (templateField?.fields) return templateField.fields;
                        }
                        return field.fields || [];
                    },

                    // Repeater Management
                    addRepeaterItem(field, section) {
                        if (!field.field_value) field.field_value = [];
                        const newItem = {};
                        const fields = this.getRepeaterFields(field, section);
                        fields.forEach(f => {
                            newItem[f.key] = f.type === 'repeater' ? [] : '';
                        });
                        field.field_value.push(newItem);
                        this.markSectionModified(section);
                    },

                    removeRepeaterItem(field, itemIdx, section) {
                        if (confirm('Remove this item?')) {
                            field.field_value.splice(itemIdx, 1);
                            this.markSectionModified(section);
                        }
                    },

                    // Section Management
                    async addSection() {
                        if (!this.newSectionType) {
                            this.showToast('Please select a section type', 'warning');
                            return;
                        }

                        this.loading = true;
                        try {
                            const res = await axios.post('{{ route('pages.sections.store', $page) }}', {
                                type: this.newSectionType
                            });

                            if (res.data.section) {
                                const section = res.data.section;
                                this.initSection(section);
                                this.sections.push(section);
                                this.newSectionType = '';
                                this.showToast('Section added successfully!');
                            }
                        } catch (error) {
                            console.error('Add section error:', error);
                            this.showToast(error.response?.data?.message || 'Failed to add section', 'error');
                        } finally {
                            this.loading = false;
                        }
                    },

                    async saveSection(section) {
                        if (!section.modified) return;

                        this.loading = true;
                        try {
                            const fieldsData = section.fields.map(field => ({
                                id: field.id,
                                field_value: (field.field_type === 'repeater' || field.field_type ===
                                        'group') && typeof field.field_value === 'object' ?
                                    JSON.stringify(field.field_value) : field.field_value
                            }));

                            await axios.put(`/admin/sections/${section.id}`, {
                                fields: fieldsData
                            });

                            section.modified = false;
                            section.isEditing = false;
                            section.backup = null;
                            this.showToast('Section saved successfully!');
                        } catch (error) {
                            console.error('Save section error:', error);
                            this.showToast(error.response?.data?.message || 'Failed to save section', 'error');
                        } finally {
                            this.loading = false;
                        }
                    },

                    async deleteSection(id, index) {
                        if (!confirm('Delete this section? This cannot be undone.')) return;

                        this.loading = true;
                        try {
                            await axios.delete(`/admin/sections/${id}`);
                            this.sections.splice(index, 1);
                            this.showToast('Section deleted successfully!');
                        } catch (error) {
                            console.error('Delete error:', error);
                            this.showToast(error.response?.data?.message || 'Failed to delete section', 'error');
                        } finally {
                            this.loading = false;
                        }
                    },

                    // Section Ordering
                    moveSectionUp(index) {
                        if (index > 0 && !this.loading) {
                            [this.sections[index], this.sections[index - 1]] = [this.sections[index - 1], this.sections[index]];
                            this.updateOrder(this.sections[index], index);
                            this.updateOrder(this.sections[index - 1], index - 1);
                        }
                    },

                    moveSectionDown(index) {
                        if (index < this.sections.length - 1 && !this.loading) {
                            [this.sections[index], this.sections[index + 1]] = [this.sections[index + 1], this.sections[index]];
                            this.updateOrder(this.sections[index], index);
                            this.updateOrder(this.sections[index + 1], index + 1);
                        }
                    },

                    async updateOrder(section, newOrder) {
                        try {
                            await axios.post(`/admin/sections/${section.id}/reorder`, {
                                order_index: newOrder
                            });
                            section.order_index = newOrder;
                        } catch (error) {
                            console.error('Failed to reorder:', error);
                            this.showToast('Failed to update order', 'error');
                        }
                    },

                    async uploadFile(event, section, field) {
                        const file = event.target.files?.[0];
                        if (!file) return;

                        // Validate image type
                        if (field.field_type === 'image' && !file.type.startsWith('image/')) {
                            this.showToast('Please select an image file', 'error');
                            event.target.value = '';
                            return;
                        }

                        // Validate file size (5MB)
                        const maxSize = 5 * 1024 * 1024;
                        if (file.size > maxSize) {
                            this.showToast('File size must be less than 5MB', 'error');
                            event.target.value = '';
                            return;
                        }

                        field.uploading = true;
                        field.uploadPercent = 0;

                        try {
                            const formData = new FormData();
                            formData.append('image', file);

                            const response = await axios.post(
                                `/admin/sections/fields/${field.id}/upload`,
                                formData, {
                                    onUploadProgress: (progressEvent) => {
                                        if (progressEvent.total) {
                                            field.uploadPercent = Math.round((progressEvent.loaded * 100) /
                                                progressEvent.total);
                                        }
                                    }
                                }
                            );

                            if (response.data && response.data.path) {
                                field.field_value = response.data.path;
                                this.markSectionModified(section);
                                this.showToast('File uploaded successfully!');
                            } else {
                                throw new Error('Invalid response format from server');
                            }

                        } catch (error) {
                            console.error('Upload error:', error);
                            const errorMsg = error.response?.data?.message ||
                                (error.response?.data?.errors ?
                                    Object.values(error.response.data.errors).flat().join(', ') :
                                    'Failed to upload file');
                            this.showToast(errorMsg, 'error');
                        } finally {
                            field.uploading = false;
                            field.uploadPercent = 0;
                            event.target.value = '';
                        }
                    },



                    clearFile(field, section) {
                        field.field_value = '';
                        this.markSectionModified(section);
                    },


                    async uploadRepeaterImage(event, field, item, key, section) {
                        const file = event.target.files?.[0];
                        if (!file) return;

                        // Validate image type
                        if (!file.type.startsWith('image/')) {
                            this.showToast('Please select an image file', 'error');
                            event.target.value = '';
                            return;
                        }

                        // Validate file size (5MB)
                        const maxSize = 5 * 1024 * 1024;
                        if (file.size > maxSize) {
                            this.showToast('File size must be less than 5MB', 'error');
                            event.target.value = '';
                            return;
                        }

                        // Initialize upload tracking
                        item[`${key}_uploading`] = true;
                        item[`${key}_percent`] = 0;

                        try {
                            const formData = new FormData();
                            formData.append('image', file);

                            const response = await axios.post(
                                `/admin/sections/fields/${field.id}/upload`,
                                formData, {
                                    onUploadProgress: (progressEvent) => {
                                        if (progressEvent.total) {
                                            item[`${key}_percent`] = Math.round((progressEvent.loaded * 100) /
                                                progressEvent.total);
                                        }
                                    }
                                }
                            );

                            if (response.data && response.data.path) {
                                item[key] = response.data.path;
                                this.markSectionModified(section);
                                this.showToast('Image uploaded successfully!');
                            } else {
                                throw new Error('Invalid response format from server');
                            }

                        } catch (error) {
                            console.error('Repeater upload error:', error);
                            const errorMsg = error.response?.data?.message ||
                                (error.response?.data?.errors ? Object.values(error.response.data.errors).flat().join(
                                    ', ') : null) ||
                                'Failed to upload image';
                            this.showToast(errorMsg, 'error');
                        } finally {
                            // Reset upload status
                            item[`${key}_uploading`] = false;
                            item[`${key}_percent`] = 0;
                            event.target.value = '';
                        }
                    },



                    clearRepeaterImage(item, key, section) {
                        item[key] = '';
                        this.markSectionModified(section);
                    }
                }
            }
        </script>
    @endpush

    @push('styles')
        <style>
            [x-cloak] {
                display: none !important;
            }

            input:focus,
            textarea:focus,
            select:focus {
                scroll-margin-top: 100px;
            }

            html {
                scroll-behavior: smooth;
            }
        </style>
    @endpush
</x-app-layout>
