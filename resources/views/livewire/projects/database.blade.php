<div class="h-[calc(100vh-16rem)] flex gap-6">
    <!-- Sidebar: Tables List -->
    <div class="w-64 flex flex-col border-r border-slate-800 pr-6">
        <div class="mb-4">
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" wire:model.live="search" class="block w-full rounded-md border-0 bg-slate-800 py-1.5 pl-10 text-gray-300 placeholder:text-gray-500 focus:bg-slate-700 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Filter tables...">
            </div>
        </div>
        
        <div class="flex-1 overflow-y-auto space-y-1">
            @foreach($tables as $table)
                <button class="{{ $loop->first ? 'bg-slate-800 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-800' }} group flex w-full items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="{{ $loop->first ? 'text-indigo-400' : 'text-gray-500' }} mr-3 h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                    {{ $table }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Main Content: Data View -->
    <div class="flex-1 flex flex-col min-w-0">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-white">
                Table: <span class="text-indigo-400">users</span> 
                <span class="ml-2 text-sm text-gray-500 font-normal">(1,248 records)</span>
            </h3>
            <div class="flex items-center space-x-2">
                <button class="inline-flex items-center rounded bg-slate-800 px-3 py-1.5 text-xs font-medium text-white hover:bg-slate-700 border border-slate-700">
                    Export CSV
                </button>
                <button class="inline-flex items-center rounded bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-500">
                    Query Editor
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-hidden rounded-lg border border-slate-800 bg-slate-900">
            <div class="overflow-x-auto h-full">
                <table class="min-w-full divide-y divide-slate-800 text-left">
                    <thead class="bg-slate-950 sticky top-0">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">id</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">email</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">name</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">created_at</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 bg-slate-900">
                        @foreach($rows as $row)
                        <tr class="hover:bg-slate-800/50">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-300 font-mono">{{ $row['id'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-indigo-400 font-mono">{{ $row['email'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-300">{{ $row['name'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 font-mono">{{ $row['created_at'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
