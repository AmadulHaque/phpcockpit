<div class="w-64 flex-shrink-0 flex flex-col bg-slate-900 border-r border-slate-800">
    <!-- Logo -->
    <div class="flex items-center h-16 flex-shrink-0 px-4 bg-slate-900">
        <div class="flex items-center gap-2">
            <div class="h-8 w-8 bg-indigo-600 rounded flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <span class="text-xl font-bold text-white tracking-wider">LDCC</span>
        </div>
    </div>

    <!-- Search -->
    <div class="px-3 mt-2">
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" class="block w-full rounded-md border-0 bg-slate-800 py-1.5 pl-10 text-gray-300 placeholder:text-gray-500 focus:bg-slate-700 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Quick search...">
        </div>
    </div>

    <!-- Projects List -->
    <div class="flex-1 overflow-y-auto px-3 mt-6">
        <div class="flex items-center justify-between px-2 mb-2">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Projects</h3>
            <button class="text-gray-500 hover:text-white">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
        
        <nav class="space-y-1">
            @foreach($projects as $project)
                <a href="{{ route('projects.show', $project) }}" 
                   class="{{ request()->route('project')?->id === $project->id ? 'bg-slate-800 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-800' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <div class="mr-3 flex-shrink-0 h-6 w-6 rounded bg-slate-800 text-gray-400 flex items-center justify-center border border-slate-700 group-hover:border-slate-600">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    {{ $project->name }}
                </a>
            @endforeach
        </nav>
    </div>

    <!-- Bottom Links -->
    <div class="flex-shrink-0 border-t border-slate-800 p-4">
        <div class="space-y-1">
            <a href="#" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-400 rounded-md hover:text-white hover:bg-slate-800">
                <svg class="mr-3 h-6 w-6 flex-shrink-0 text-gray-500 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Settings
            </a>
            <a href="#" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-400 rounded-md hover:text-white hover:bg-slate-800">
                <svg class="mr-3 h-6 w-6 flex-shrink-0 text-gray-500 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Support
            </a>
        </div>
    </div>
</div>
