<div class="h-[calc(100vh-16rem)] flex flex-col">
    <!-- Tinker Header -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Interactive Shell</h3>
        <button wire:click="run"
            class="inline-flex items-center rounded bg-green-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
            <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Run
        </button>
    </div>

    <!-- Terminal Area -->
    <div class="flex flex-1 gap-4 overflow-hidden">
        <!-- Input -->
        <div class="w-1/2 flex flex-col rounded-lg border border-slate-800 bg-slate-950">
            <textarea wire:model="command"
                class="flex-1 w-full bg-transparent p-4 font-mono text-sm text-gray-300 focus:outline-none resize-none placeholder:text-gray-700"
                placeholder="User::find(1);"></textarea>
        </div>

        <!-- Output -->
        <div class="w-1/2 flex flex-col">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Output</h4>
            <div
                class="flex-1 rounded-lg border border-slate-800 bg-slate-950 p-4 font-mono text-sm text-green-400 overflow-auto whitespace-pre">
                {{ $output }}
            </div>
        </div>
    </div>
</div>