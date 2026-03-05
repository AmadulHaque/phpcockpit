@php
    $latestOutput = collect($outputBlocks)->last();
    $outputText = $latestOutput['output'] ?? $placeholderOutput;
    $outputLines = explode("\n", $outputText);
@endphp

<section class="flex h-full flex-col overflow-hidden rounded-b-2xl bg-[#24283b] text-zinc-100">
    <div class="flex items-center justify-between border-b border-[#343950] px-3 py-1.5 text-[11px] text-zinc-400">
        <div class="flex items-center gap-2">
            <button type="button" class="inline-flex h-4 w-4 items-center justify-center rounded border border-[#4a5068] text-[10px] leading-none">▷</button>
            <span>Snippet Runner</span>
            <span class="text-zinc-500">{{ $environment }}</span>
            @if ($running)
                <span class="inline-flex items-center gap-1 text-emerald-300">
                    <svg class="h-3 w-3 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" d="M12 3.75a8.25 8.25 0 1 1-5.834 2.416" />
                    </svg>
                    running
                </span>
            @endif
        </div>

        <div class="flex items-center gap-1.5">
            <button
                type="button"
                wire:click="copyLatestOutput"
                class="rounded border border-[#4a5068] px-1.5 py-0.5 text-zinc-300 transition hover:bg-[#2f3550]"
            >
                Copy Output
            </button>
            <button
                type="button"
                wire:click="clearConsole"
                class="rounded border border-[#4a5068] px-1.5 py-0.5 text-zinc-300 transition hover:bg-[#2f3550]"
            >
                Clear
            </button>
        </div>
    </div>

    <div class="grid h-full min-h-0 grid-rows-[1fr_auto_1fr]">
        <div
            x-data="tinkerEditor()"
            x-init="syncFromValue($refs.editor.value)"
            class="relative min-h-0 border-b border-[#343950]"
        >
            <div class="absolute inset-0 flex">
                <div x-ref="gutter" class="w-10 shrink-0 overflow-hidden bg-[#262b40] px-2 py-2 text-right font-mono text-[11px] leading-7 text-zinc-500">
                    <template x-for="n in lineCount" :key="n">
                        <div x-text="n"></div>
                    </template>
                </div>

                <textarea
                    x-ref="editor"
                    wire:model.defer="commandInput"
                    @input="syncFromValue($el.value, $refs.gutter, $el)"
                    @scroll="$refs.gutter.scrollTop = $el.scrollTop"
                    @keydown.tab.prevent="insertTab($event)"
                    @keydown.meta.enter.prevent="$wire.runCommand()"
                    @keydown.ctrl.enter.prevent="$wire.runCommand()"
                    @keydown.up="if (!$el.value.includes('\n') || $el.selectionStart === 0) { $event.preventDefault(); $wire.historyUp(); }"
                    @keydown.down="if (!$el.value.includes('\n') || $el.selectionStart === $el.value.length) { $event.preventDefault(); $wire.historyDown(); }"
                    spellcheck="false"
                    class="h-full min-h-0 w-full resize-none bg-[#24283b] px-3 py-2 font-mono text-[13px] leading-7 text-zinc-100 outline-none"
                    aria-label="PHP code editor"
                ></textarea>
            </div>
        </div>

        <div class="flex items-center justify-between border-b border-[#343950] bg-[#24283b] px-3 py-1 text-[11px] text-zinc-400">
            <div class="flex items-center gap-2">
                <span>Run with</span>
                <span class="rounded border border-[#4a5068] px-1.5 py-0.5 text-zinc-300">Cmd/Ctrl + Enter</span>
                <span class="rounded border border-[#4a5068] px-1.5 py-0.5 text-zinc-300">{{ $currentClassification }}</span>
            </div>

            <div class="flex items-center gap-2">
                @if ($running)
                    <button
                        type="button"
                        wire:click="cancelCommand"
                        class="rounded border border-rose-400/60 px-2 py-0.5 text-rose-200 transition hover:bg-rose-500/20"
                    >
                        Cancel
                    </button>
                @endif

                <button
                    type="button"
                    wire:click="runCommand"
                    class="rounded border border-emerald-400/60 px-2 py-0.5 text-emerald-200 transition hover:bg-emerald-500/20"
                >
                    Run
                </button>
            </div>
        </div>

        <div class="relative min-h-0">
            <div class="absolute inset-0 flex overflow-hidden">
                <div class="w-10 shrink-0 overflow-hidden bg-[#262b40] px-2 py-2 text-right font-mono text-[11px] leading-7 text-zinc-500">
                    @foreach ($outputLines as $index => $line)
                        <div>{{ $index + 1 }}</div>
                    @endforeach
                </div>

                <pre
                    x-data="consoleStream(@entangle('autoScroll').live)"
                    x-on:console-output-updated.window="onOutputUpdated()"
                    x-ref="output"
                    class="h-full min-h-0 w-full overflow-auto bg-[#24283b] px-3 py-2 font-mono text-[13px] leading-7 text-zinc-200"
                >{{ $outputText }}</pre>
            </div>
        </div>
    </div>
</section>
