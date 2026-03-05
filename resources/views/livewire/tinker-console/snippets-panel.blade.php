<section class="space-y-3 rounded-2xl border border-zinc-800 bg-zinc-950/70 p-3">
    <div class="flex items-center justify-between">
        <h2 class="text-xs font-semibold uppercase tracking-[0.14em] text-zinc-400">Saved Snippets</h2>
        <span class="text-[11px] text-zinc-500">{{ count($filteredSnippets) }}</span>
    </div>

    <label class="block">
        <span class="sr-only">Search snippets</span>
        <input
            id="snippet-search"
            x-on:focus-snippet-search.window="$el.focus()"
            wire:model.live.debounce.250ms="search"
            type="text"
            placeholder="Search snippets"
            class="w-full rounded-xl border border-zinc-800 bg-zinc-900 px-3 py-2 text-sm text-zinc-100 placeholder:text-zinc-500 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30"
        >
    </label>

    <div class="flex flex-wrap gap-1.5">
        <button
            type="button"
            wire:click="setActiveTag('all')"
            @class([
                'rounded-lg px-2 py-1 text-xs transition',
                'bg-zinc-100 text-zinc-900' => $activeTag === 'all',
                'bg-zinc-800 text-zinc-300 hover:bg-zinc-700' => $activeTag !== 'all',
            ])
        >
            all
        </button>
        @foreach ($availableTags as $tag)
            <button
                type="button"
                wire:click="setActiveTag('{{ $tag }}')"
                @class([
                    'rounded-lg px-2 py-1 text-xs transition',
                    'bg-zinc-100 text-zinc-900' => $activeTag === $tag,
                    'bg-zinc-800 text-zinc-300 hover:bg-zinc-700' => $activeTag !== $tag,
                ])
            >
                {{ $tag }}
            </button>
        @endforeach
    </div>

    <div class="max-h-64 space-y-2 overflow-y-auto pr-1">
        @foreach ($filteredSnippets as $snippet)
            <article wire:key="snippet-{{ $snippet['id'] }}" class="rounded-xl border border-zinc-800 bg-zinc-900/80 p-2.5">
                <div class="flex items-start justify-between gap-2">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium text-zinc-100">{{ $snippet['title'] }}</p>
                        <p class="mt-1 truncate font-mono text-xs text-zinc-400">{{ $snippet['command'] }}</p>
                    </div>
                    <button
                        type="button"
                        wire:click="insertSnippet('{{ $snippet['id'] }}')"
                        class="rounded-lg border border-zinc-700 px-2 py-1 text-xs text-zinc-200 transition hover:border-sky-500 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
                    >
                        Insert
                    </button>
                </div>

                <div class="mt-2 flex flex-wrap items-center gap-1.5">
                    @foreach ($snippet['tags'] as $tag)
                        <span class="rounded-md bg-zinc-800 px-1.5 py-0.5 text-[10px] uppercase tracking-wide text-zinc-400">{{ $tag }}</span>
                    @endforeach
                    @if ($snippet['destructive'])
                        <span class="rounded-md bg-rose-500/15 px-1.5 py-0.5 text-[10px] uppercase tracking-wide text-rose-300">Destructive</span>
                    @endif
                    @if ($snippet['requires_confirmation'])
                        <span class="rounded-md bg-amber-500/15 px-1.5 py-0.5 text-[10px] uppercase tracking-wide text-amber-300">Confirm</span>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>
