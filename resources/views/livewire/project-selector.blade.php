<div class="relative" x-data="{ isOpen: @entangle('pickerOpen').live }" x-on:keydown.escape.window="$wire.closePicker()">
    <button
        type="button"
        wire:click="openPicker"
        class="inline-flex h-9 max-w-[34rem] items-center gap-2 rounded-lg border border-transparent px-2 text-slate-400 transition hover:bg-slate-800/40 hover:text-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
        aria-haspopup="dialog"
        :aria-expanded="isOpen"
    >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 text-slate-500">
            <rect x="4.5" y="4.5" width="15" height="15" rx="2" />
            <path stroke-linecap="round" d="M12 4.5v15" />
        </svg>

        <span class="truncate text-sm font-medium text-slate-300 sm:text-base">{{ $selectedProjectName !== '' ? $selectedProjectName : 'Select a project' }}</span>

        @if ($selectedProjectName !== '')
            <span class="hidden truncate rounded-md border border-slate-700 px-1.5 py-0.5 text-[10px] uppercase tracking-wide text-slate-400 lg:inline-flex">{{ $selectedEnvironment }}</span>
        @endif
    </button>

    <div
        x-show="isOpen"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 z-[90] bg-slate-950/70 backdrop-blur-sm"
        @click="$wire.closePicker()"
    ></div>

    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-180"
        x-transition:enter-start="translate-y-2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-140"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-2 opacity-0"
        x-cloak
        class="fixed left-1/2 top-22 z-[91] w-[min(54rem,92vw)] -translate-x-1/2 rounded-2xl border border-slate-700 bg-slate-900 p-4 shadow-2xl"
        role="dialog"
        aria-modal="true"
        @click.stop
    >
        <div class="mb-3 flex items-start justify-between gap-3">
            <div>
                <h3 class="text-sm font-semibold text-slate-100">Select Laravel Project</h3>
                <p class="mt-1 text-xs text-slate-400">Choose a project context before using Tinker Console.</p>
            </div>
            <button
                type="button"
                wire:click="closePicker"
                class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-slate-700 text-slate-400 transition hover:border-slate-500 hover:text-slate-200"
                aria-label="Close project picker"
            >
                ×
            </button>
        </div>

        <div class="grid gap-4 lg:grid-cols-[1fr_20rem]">
            <div>
                <div class="mb-2 flex items-center justify-between">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Detected projects</p>
                    <button
                        type="button"
                        wire:click="refreshProjects"
                        class="rounded-md border border-slate-700 px-2 py-1 text-[11px] text-slate-300 transition hover:border-slate-500"
                    >
                        Refresh
                    </button>
                </div>

                <div class="max-h-72 space-y-2 overflow-y-auto pr-1">
                    @forelse ($projects as $project)
                        <button
                            type="button"
                            wire:key="project-{{ md5($project['path']) }}"
                            wire:click="chooseProject(@js($project['path']))"
                            class="w-full rounded-xl border px-3 py-2.5 text-left transition {{ $selectedProjectPath === $project['path'] ? 'border-sky-500/50 bg-sky-500/10' : 'border-slate-700 bg-slate-800/60 hover:border-slate-500' }}"
                        >
                            <div class="flex items-center justify-between gap-2">
                                <p class="truncate text-sm font-medium text-slate-100">{{ $project['name'] }}</p>
                                <span class="rounded-md border border-slate-600 px-1.5 py-0.5 text-[10px] uppercase tracking-wide text-slate-300">{{ $project['environment'] }}</span>
                            </div>
                            <p class="mt-1 truncate font-mono text-[11px] text-slate-400">{{ $project['path'] }}</p>
                        </button>
                    @empty
                        <p class="rounded-xl border border-dashed border-slate-700 px-3 py-6 text-center text-xs text-slate-400">No Laravel projects found automatically.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-slate-700 bg-slate-800/40 p-3">
                <p class="text-xs uppercase tracking-wide text-slate-500">Custom path</p>
                <label class="mt-2 block">
                    <span class="sr-only">Custom project path</span>
                    <input
                        type="text"
                        wire:model="customPath"
                        placeholder="/Users/.../my-laravel-app"
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-3 py-2 text-xs text-slate-100 placeholder:text-slate-500 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30"
                    >
                </label>

                <button
                    type="button"
                    wire:click="selectCustomProject"
                    class="mt-2 w-full rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-900 transition hover:bg-white"
                >
                    Use this path
                </button>

                @if ($selectedProjectPath !== '')
                    <div class="mt-3 border-t border-slate-700 pt-3">
                        <p class="text-[11px] uppercase tracking-wide text-slate-500">Current</p>
                        <p class="mt-1 truncate text-xs text-slate-200">{{ $selectedProjectName }}</p>
                        <p class="truncate font-mono text-[11px] text-slate-400">{{ $selectedProjectPath }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
