@props(['projectLabel' => 'Select a project'])

<header class="flex h-14 items-center justify-between border-b border-slate-700/70 px-3 sm:px-5">
    <livewire:project-selector />

    <div class="inline-flex items-center gap-1.5 rounded-md px-2 py-1 text-emerald-400">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75 6.75 6v6.16c0 2.994 1.926 5.649 4.78 6.584L12 18.9l.47-.156a6.93 6.93 0 0 0 4.78-6.584V6L12 3.75Z" />
        </svg>
        <span class="text-xs font-medium sm:text-sm">Safe</span>
    </div>
</header>
