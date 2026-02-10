<div class="flow-root">
    <ul role="list" class="-mb-8">
        @forelse($logs as $log)
        <li>
            <div class="relative pb-8">
                @if(!$loop->last)
                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-slate-800" aria-hidden="true"></span>
                @endif
                <div class="relative flex space-x-3">
                    <div>
                        <span class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center ring-8 ring-slate-950">
                            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                        <div>
                            <p class="text-sm text-gray-300">{{ $log->action }} <span class="text-gray-500">by {{ $log->user ?? 'System' }}</span></p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $log->details }}</p>
                        </div>
                        <div class="whitespace-nowrap text-right text-sm text-gray-500">
                            <time datetime="{{ $log->created_at }}">{{ $log->created_at->diffForHumans() }}</time>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        @empty
        <li class="py-4 text-center text-gray-500 text-sm">
            No audit activity recorded yet.
        </li>
        @endforelse
    </ul>
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
