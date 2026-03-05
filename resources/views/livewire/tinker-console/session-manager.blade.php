<section class="space-y-3">
    <div class="flex items-center justify-between">
        <h2 class="text-xs font-semibold uppercase tracking-[0.14em] text-zinc-400">Sessions</h2>
        <button
            type="button"
            wire:click="createSession"
            class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-zinc-700 bg-zinc-900 text-zinc-300 transition hover:border-zinc-500 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
            aria-label="Create new session"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                <path stroke-linecap="round" d="M12 5.5v13M5.5 12h13" />
            </svg>
        </button>
    </div>

    <div class="space-y-2">
        @foreach ($sessions as $session)
            <div
                wire:key="session-{{ $session['id'] }}"
                @class([
                    'group flex items-center gap-2 rounded-xl border px-2.5 py-2 text-sm transition',
                    'border-sky-500/40 bg-sky-500/10 text-zinc-100' => $activeSessionId === $session['id'],
                    'border-zinc-800 bg-zinc-900/70 text-zinc-300 hover:border-zinc-700 hover:bg-zinc-900' => $activeSessionId !== $session['id'],
                ])
            >
                <button
                    type="button"
                    wire:click="activateSession('{{ $session['id'] }}')"
                    class="flex min-w-0 flex-1 items-center gap-2 text-left focus-visible:outline-none"
                >
                    <span class="inline-flex h-2 w-2 shrink-0 rounded-full {{ $session['running'] ? 'bg-emerald-400 animate-pulse' : ($session['dirty'] ? 'bg-amber-400' : 'bg-zinc-500') }}"></span>
                    <span class="truncate">{{ $session['name'] }}</span>
                    <span class="rounded-md border border-zinc-700/80 px-1.5 py-0.5 text-[10px] uppercase tracking-wide text-zinc-400">{{ $session['env'] }}</span>
                </button>

                <button
                    type="button"
                    wire:click="closeSession('{{ $session['id'] }}')"
                    class="inline-flex h-6 w-6 items-center justify-center rounded-md text-zinc-500 transition hover:bg-zinc-800 hover:text-zinc-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
                    aria-label="Close session"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5">
                        <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
                    </svg>
                </button>
            </div>
        @endforeach
    </div>

    <p class="text-[11px] text-zinc-500">Active tab is persisted per project path.</p>
</section>
