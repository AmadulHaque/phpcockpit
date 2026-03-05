<section class="space-y-3 rounded-2xl border border-zinc-800 bg-zinc-950/70 p-3">
    <div class="flex items-center justify-between">
        <h2 class="text-xs font-semibold uppercase tracking-[0.14em] text-zinc-400">Command History</h2>
        <span class="text-[11px] text-zinc-500">{{ count($filteredEntries) }}</span>
    </div>

    <div class="grid gap-2 sm:grid-cols-[1fr_auto]">
        <label class="block">
            <span class="sr-only">Search history</span>
            <input
                id="history-search"
                x-on:focus-history-search.window="$el.focus()"
                wire:model.live.debounce.250ms="search"
                type="text"
                placeholder="Search history"
                class="w-full rounded-xl border border-zinc-800 bg-zinc-900 px-3 py-2 text-sm text-zinc-100 placeholder:text-zinc-500 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30"
            >
        </label>

        <label class="block">
            <span class="sr-only">Filter by environment</span>
            <select
                wire:model.live="environmentFilter"
                class="w-full rounded-xl border border-zinc-800 bg-zinc-900 px-3 py-2 text-sm text-zinc-100 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30"
            >
                <option value="all">All env</option>
                <option value="DEV">DEV</option>
                <option value="STAGING">STAGING</option>
                <option value="PROD">PROD</option>
            </select>
        </label>
    </div>

    <div class="max-h-[26rem] space-y-2 overflow-y-auto pr-1">
        @forelse ($filteredEntries as $entry)
            @php
                $isPinned = in_array($entry['id'], $pinnedIds, true);
            @endphp
            <article wire:key="history-{{ $entry['id'] }}" class="rounded-xl border border-zinc-800 bg-zinc-900/80 p-2.5">
                <div class="flex items-start justify-between gap-2">
                    <div class="min-w-0">
                        <p class="truncate font-mono text-xs text-zinc-200">{{ $entry['command'] }}</p>
                        <div class="mt-1 flex flex-wrap gap-1.5 text-[10px] text-zinc-500">
                            <span>{{ $entry['timestamp'] }}</span>
                            <span>{{ $entry['duration_ms'] }}ms</span>
                            <span class="uppercase">{{ $entry['environment'] }}</span>
                            <span class="{{ $entry['status'] === 'success' ? 'text-emerald-300' : 'text-rose-300' }}">{{ $entry['status'] }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-1">
                        <button
                            type="button"
                            wire:click="togglePin('{{ $entry['id'] }}')"
                            @class([
                                'rounded-md p-1 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500',
                                'text-amber-300' => $isPinned,
                                'text-zinc-500 hover:bg-zinc-800 hover:text-zinc-200' => ! $isPinned,
                            ])
                            aria-label="Pin command"
                        >
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m15 4.5 4.5 4.5-3 1.5v5.625l-4.5-2.25-4.5 2.25V10.5L4.5 9 9 4.5h6Z" />
                            </svg>
                        </button>
                        <button
                            type="button"
                            wire:click="copy('{{ $entry['id'] }}')"
                            class="rounded-md p-1 text-zinc-500 transition hover:bg-zinc-800 hover:text-zinc-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
                            aria-label="Copy command"
                        >
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5">
                                <rect x="9" y="9" width="11" height="11" rx="2" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 15V6A2.5 2.5 0 0 1 8 3.5h9" />
                            </svg>
                        </button>
                        <button
                            type="button"
                            wire:click="replay('{{ $entry['id'] }}')"
                            class="rounded-md p-1 text-zinc-500 transition hover:bg-zinc-800 hover:text-zinc-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
                            aria-label="Replay command"
                        >
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6.75v4.5H12M16.5 11.25A6.75 6.75 0 1 0 12 18.75" />
                            </svg>
                        </button>
                    </div>
                </div>
            </article>
        @empty
            <p class="rounded-xl border border-dashed border-zinc-800 px-3 py-5 text-center text-xs text-zinc-500">No history found for current filters.</p>
        @endforelse
    </div>
</section>
