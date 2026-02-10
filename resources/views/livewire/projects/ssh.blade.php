<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-white">SSH Sessions</h3>
        <button class="inline-flex items-center rounded bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-500">
            <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            New Session
        </button>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($sessions as $session)
        <div class="relative flex items-center space-x-3 rounded-lg border border-slate-800 bg-slate-900 px-6 py-5 shadow-sm hover:border-slate-700">
            <div class="flex-shrink-0">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-800">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </span>
            </div>
            <div class="min-w-0 flex-1">
                <div class="focus:outline-none">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-white">{{ $session['user'] }}@<span class="text-indigo-400">{{ $session['host'] }}</span></p>
                    <p class="truncate text-sm text-gray-500">{{ $session['last_activity'] }}</p>
                </div>
            </div>
            <div>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $session['status'] === 'connected' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $session['status'] }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
</div>
