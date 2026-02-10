<div class="h-[calc(100vh-16rem)] flex flex-col">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-white">Project Notes</h3>
        <div>
            @if (session()->has('message'))
                <span class="mr-3 text-sm text-green-400" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                    {{ session('message') }}
                </span>
            @endif
            <button wire:click="save" class="inline-flex items-center rounded bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-500">
                <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Save Notes
            </button>
        </div>
    </div>

    <div class="flex-1 rounded-lg border border-slate-800 bg-slate-900 overflow-hidden">
        <textarea 
            wire:model="content"
            class="h-full w-full bg-transparent p-6 font-mono text-sm text-gray-300 focus:outline-none resize-none placeholder:text-gray-700" 
            placeholder="Write your project notes here... Markdown supported."></textarea>
    </div>
</div>
