@if ($environment === 'PROD')
    <div class="mb-4 rounded-2xl border border-rose-500/40 bg-rose-500/12 px-4 py-3 shadow-[0_10px_30px_rgba(244,63,94,0.15)]">
        <div class="flex items-start gap-3">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="mt-0.5 h-5 w-5 text-rose-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v3.75m0 3h.007M10.29 3.86 1.82 18A1.5 1.5 0 0 0 3.1 20.25h17.8A1.5 1.5 0 0 0 22.18 18L13.71 3.86a1.5 1.5 0 0 0-2.42 0Z" />
            </svg>
            <div>
                <p class="text-sm font-semibold text-rose-100">Production Environment Detected</p>
                <p class="mt-1 text-xs text-rose-200/90">Destructive commands require two-step confirmation and typing <span class="font-semibold tracking-wide">PRODUCTION</span>.</p>
            </div>
        </div>
    </div>
@else
    <div class="mb-4 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3">
        <p class="text-xs text-emerald-200">Safety checks active. You are running in <span class="font-semibold">{{ $environment }}</span>.</p>
    </div>
@endif
