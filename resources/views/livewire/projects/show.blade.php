<div>
    <!-- Top Navigation for Project -->
    <x-slot name="header">
        <div class="flex flex-col w-full">
            <!-- Project Context Header -->
            <div class="flex items-center justify-between py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <h1 class="text-xl font-semibold text-white">{{ $project->name }}</h1>

                    <!-- Environment Toggles -->
                    <div class="ml-8 bg-slate-800 rounded-md p-1 flex items-center">
                        <button class="px-3 py-1 text-xs font-medium rounded bg-slate-700 text-white">Local</button>
                        <button
                            class="px-3 py-1 text-xs font-medium rounded text-gray-400 hover:text-white">Staging</button>
                        <button
                            class="px-3 py-1 text-xs font-medium rounded text-gray-400 hover:text-white">Production</button>
                    </div>
                </div>

                <!-- Branch Status -->
                <div class="flex items-center text-gray-400 text-sm">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <span>main</span>
                    <svg class="h-4 w-4 ml-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>

            <!-- Tabs -->
            <div class="border-b border-slate-800 px-4 sm:px-6 lg:px-8">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button wire:click="$set('activeTab', 'overview')"
                        class="{{ $activeTab === 'overview' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                        <svg class="{{ $activeTab === 'overview' ? 'text-indigo-400' : 'text-gray-500' }} -ml-0.5 mr-2 h-5 w-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Overview
                    </button>
                    <button wire:click="$set('activeTab', 'tinker')"
                        class="{{ $activeTab === 'tinker' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                        <span class="mr-2 font-mono text-lg leading-none">>_</span>
                        Tinker
                    </button>
                    <button wire:click="$set('activeTab', 'database')"
                        class="{{ $activeTab === 'database' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                        <svg class="{{ $activeTab === 'database' ? 'text-indigo-400' : 'text-gray-500' }} -ml-0.5 mr-2 h-5 w-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                        Database
                    </button>
                    <button wire:click="$set('activeTab', 'ssh')"
                        class="{{ $activeTab === 'ssh' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                        <svg class="{{ $activeTab === 'ssh' ? 'text-indigo-400' : 'text-gray-500' }} -ml-0.5 mr-2 h-5 w-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                        </svg>
                        SSH
                    </button>
                    <button wire:click="$set('activeTab', 'notes')"
                        class="{{ $activeTab === 'notes' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                        <svg class="{{ $activeTab === 'notes' ? 'text-indigo-400' : 'text-gray-500' }} -ml-0.5 mr-2 h-5 w-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Notes
                    </button>
                    <button wire:click="$set('activeTab', 'audit')"
                        class="{{ $activeTab === 'audit' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                        <svg class="{{ $activeTab === 'audit' ? 'text-indigo-400' : 'text-gray-500' }} -ml-0.5 mr-2 h-5 w-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Audit Log
                    </button>
                </nav>
            </div>
        </div>
    </x-slot>

    <!-- Overview Content -->
    @if($activeTab === 'overview')
        <div class="space-y-6">
            <!-- Project Info Header -->
            <div class="flex items-center space-x-4 mb-8">
                <h2 class="text-3xl font-bold text-white">{{ $project->name }}</h2>
                <span
                    class="inline-flex items-center rounded-md bg-slate-800 px-2 py-1 text-xs font-medium text-gray-400 ring-1 ring-inset ring-gray-500/10">
                    {{ $project->framework ?? 'Laravel' }}
                </span>
                <span class="text-gray-500 text-sm font-mono">{{ $project->local_path }}</span>
            </div>

            <!-- Status Cards Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Git Status -->
                <div class="bg-slate-900 overflow-hidden rounded-lg border border-slate-800">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Git Status</h3>
                            <svg class="h-5 w-5 {{ $project->gitState?->is_dirty ? 'text-yellow-500' : 'text-green-500' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Branch</span>
                                <span
                                    class="text-green-400 font-mono">{{ $project->gitState?->current_branch ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Status</span>
                                @if($project->gitState?->is_dirty)
                                    <span
                                        class="inline-flex items-center rounded-full bg-yellow-900/30 px-2 py-0.5 text-xs font-medium text-yellow-500">Dirty</span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-900/30 px-2 py-0.5 text-xs font-medium text-green-500">Clean</span>
                                @endif
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Last commit</span>
                                <span
                                    class="text-gray-400">{{ $project->gitState?->last_synced_at ? \Carbon\Carbon::parse($project->gitState->last_synced_at)->diffForHumans() : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Runtimes -->
                <div class="bg-slate-900 overflow-hidden rounded-lg border border-slate-800">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Runtimes</h3>
                            <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">PHP</span>
                                <span class="text-indigo-400 font-mono">{{ $project->phpVersion?->version ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Node.js</span>
                                <span class="text-indigo-400 font-mono">{{ $project->nodeVersion?->version ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Source</span>
                                <span class="text-gray-400">{{ $project->phpVersion?->source ?? 'System' }} /
                                    {{ $project->nodeVersion?->source ?? 'System' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Env -->
                <div class="bg-slate-900 overflow-hidden rounded-lg border border-slate-800">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Active Env</h3>
                            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Current</span>
                                <span class="text-green-500 font-medium">Local</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Security</span>
                                <span
                                    class="inline-flex items-center rounded-full bg-gray-800 px-2 py-0.5 text-xs font-medium text-gray-400">Standard</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saved Commands -->
            <div>
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Saved Commands</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($project->savedCommands as $command)
                        <div
                            class="group relative flex items-center justify-between space-x-3 rounded-lg border border-slate-800 bg-slate-900 px-6 py-4 shadow-sm hover:border-slate-700">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <span class="text-gray-500">>_</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <a href="#" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        <p class="text-sm font-medium text-white">{{ $command->command }}</p>
                                        <p class="truncate text-xs text-gray-500">{{ $command->name }}</p>
                                    </a>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-gray-600 group-hover:text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-4 text-gray-500 text-sm">
                            No saved commands found.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Audit Activity -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Audit Activity</h3>
                    <a href="#" class="text-xs font-medium text-indigo-400 hover:text-indigo-300">View History</a>
                </div>
                <div class="bg-slate-900 rounded-lg border border-slate-800 overflow-hidden">
                    <ul role="list" class="divide-y divide-slate-800">
                        @forelse($project->auditLogs as $log)
                            <li class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-2 w-2 rounded-full bg-green-500"></div>
                                        <p class="ml-4 text-sm font-medium text-gray-300">{{ $log->action }} <span
                                                class="text-gray-500">on</span> <span
                                                class="text-gray-400 bg-gray-800 px-1.5 py-0.5 rounded text-xs">{{ $log->environment_id ? 'Env' : 'System' }}</span>
                                        </p>
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $log->created_at->diffForHumans() }}</div>
                                </div>
                            </li>
                        @empty
                            <li class="px-6 py-4 text-center text-sm text-gray-500">
                                No audit activity recorded.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    @elseif($activeTab === 'tinker')
        <livewire:projects.tinker :project="$project" />
    @elseif($activeTab === 'database')
        <livewire:projects.database :project="$project" />
    @elseif($activeTab === 'ssh')
        <livewire:projects.ssh :project="$project" />
    @elseif($activeTab === 'notes')
        <livewire:projects.notes :project="$project" />
    @elseif($activeTab === 'audit')
        <livewire:projects.audit-log :project="$project" />
    @endif
</div>