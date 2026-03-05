<div
    x-data="{ isOpen: @entangle('isOpen').live }"
    x-show="isOpen"
    x-transition.opacity
    x-cloak
    class="fixed inset-0 z-[80] flex items-center justify-center bg-zinc-950/70 px-4 backdrop-blur-sm"
    x-on:keydown.escape.window="$wire.cancel()"
>
    <div class="w-full max-w-lg rounded-2xl border border-zinc-700 bg-zinc-900 p-5 shadow-2xl" x-transition.scale.90>
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-base font-semibold text-zinc-100">Confirm Command Execution</h3>
            <span class="rounded-md bg-zinc-800 px-2 py-1 text-[10px] uppercase tracking-wide text-zinc-400">Step {{ $step }} / 2</span>
        </div>

        <div class="space-y-3">
            <div class="rounded-xl border border-zinc-800 bg-zinc-950/80 p-3">
                <p class="text-xs uppercase tracking-wide text-zinc-500">Command</p>
                <p class="mt-1 font-mono text-sm text-zinc-200">{{ $command }}</p>
            </div>

            <div class="flex items-center gap-2 text-xs">
                <span @class([
                    'rounded-md px-2 py-1 uppercase tracking-wide',
                    'bg-zinc-700 text-zinc-200' => $classification === 'safe',
                    'bg-amber-500/20 text-amber-200' => $classification === 'warn',
                    'bg-rose-500/20 text-rose-200' => $classification === 'hard-danger',
                ])>{{ $classification }}</span>
                <span class="rounded-md bg-zinc-800 px-2 py-1 uppercase tracking-wide text-zinc-300">{{ $environment }}</span>
            </div>

            @if ($step === 1)
                <p class="text-sm text-zinc-300">Review the command context and continue to final confirmation.</p>
            @else
                <div class="space-y-2">
                    <p class="text-sm text-zinc-300">Final confirmation required before execution.</p>

                    @if ($requiresPhrase)
                        <label class="block">
                            <span class="mb-1 block text-xs text-zinc-400">Type <span class="font-semibold tracking-wide">PRODUCTION</span> to override</span>
                            <input
                                wire:model.live="phraseInput"
                                type="text"
                                class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-zinc-100 focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-500/30"
                            >
                            @error('phraseInput')
                                <span class="mt-1 block text-xs text-rose-300">{{ $message }}</span>
                            @enderror
                        </label>
                    @endif
                </div>
            @endif
        </div>

        <div class="mt-5 flex items-center justify-end gap-2">
            <button
                type="button"
                wire:click="cancel"
                class="rounded-xl border border-zinc-700 px-3 py-2 text-sm text-zinc-300 transition hover:border-zinc-500 hover:text-zinc-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
            >
                Cancel
            </button>

            @if ($step === 1)
                <button
                    type="button"
                    wire:click="continueToSecondStep"
                    class="rounded-xl bg-zinc-100 px-3 py-2 text-sm font-semibold text-zinc-900 transition hover:bg-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
                >
                    Continue
                </button>
            @else
                <button
                    type="button"
                    wire:click="approve"
                    class="rounded-xl bg-rose-500 px-3 py-2 text-sm font-semibold text-white transition hover:bg-rose-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-300"
                >
                    Confirm & Run
                </button>
            @endif
        </div>
    </div>
</div>
