@props(['activeKey' => 'tinker'])

@php
    $menuItems = [
        ['key' => 'databases', 'label' => 'Databases', 'icon' => 'circle-stack', 'route' => 'cockpit.databases'],
        ['key' => 'projects', 'label' => 'Projects', 'icon' => 'folder-open', 'route' => 'cockpit.projects'],
        ['key' => 'tinker', 'label' => 'Tinker', 'icon' => 'code-bracket', 'route' => 'cockpit.tinker'],
        ['key' => 'servers', 'label' => 'Servers', 'icon' => 'server-stack', 'route' => 'cockpit.servers'],
        ['key' => 'runtimes', 'label' => 'Runtimes', 'icon' => 'cpu-chip', 'route' => 'cockpit.runtimes'],
        ['key' => 'notes', 'label' => 'Notes', 'icon' => 'document', 'route' => 'cockpit.notes'],
        ['key' => 'commands', 'label' => 'Commands', 'icon' => 'bookmark-square', 'route' => 'cockpit.commands'],
        ['key' => 'audit-log', 'label' => 'Audit Log', 'icon' => 'clipboard-list', 'route' => 'cockpit.audit-log'],
    ];

    $icon = static function (string $name): string {
        return match ($name) {
            'folder-open' => <<<'SVG'
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5a2.25 2.25 0 0 1 2.25-2.25h4.379a2.25 2.25 0 0 1 1.59.659l.622.621a2.25 2.25 0 0 0 1.59.659H18a2.25 2.25 0 0 1 2.25 2.25v7.5A2.25 2.25 0 0 1 18 19.5H6A2.25 2.25 0 0 1 3.75 17.25V7.5Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 10.5h16.5" />
                </svg>
            SVG,
            'circle-stack' => <<<'SVG'
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 shrink-0">
                    <ellipse cx="12" cy="6" rx="7.25" ry="2.75" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.75 6v6c0 1.52 3.245 2.75 7.25 2.75s7.25-1.23 7.25-2.75V6" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.75 12v6c0 1.52 3.245 2.75 7.25 2.75s7.25-1.23 7.25-2.75v-6" />
                </svg>
            SVG,
            'code-bracket' => <<<'SVG'
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75 3.75 12l4.5 5.25M15.75 6.75 20.25 12l-4.5 5.25" />
                </svg>
            SVG,
            'server-stack' => <<<'SVG'
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 shrink-0">
                    <rect x="3.75" y="4.5" width="16.5" height="6" rx="1.5" />
                    <rect x="3.75" y="13.5" width="16.5" height="6" rx="1.5" />
                    <path stroke-linecap="round" d="M8.25 7.5h.01M8.25 16.5h.01" />
                </svg>
            SVG,
            'cpu-chip' => <<<'SVG'
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 shrink-0">
                    <rect x="7.5" y="7.5" width="9" height="9" rx="1.5" />
                    <path stroke-linecap="round" d="M12 3.75v2.25M12 18v2.25M3.75 12H6M18 12h2.25M5.25 5.25l1.5 1.5M17.25 17.25l1.5 1.5M18.75 5.25l-1.5 1.5M6.75 17.25l-1.5 1.5" />
                </svg>
            SVG,
            'document' => <<<'SVG'
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75h6.879c.597 0 1.17.237 1.592.659l3.62 3.62c.422.422.659.995.659 1.592V18A2.25 2.25 0 0 1 18 20.25H7.5A2.25 2.25 0 0 1 5.25 18V6A2.25 2.25 0 0 1 7.5 3.75Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 3.75V8.25H18.75" />
                </svg>
            SVG,
            'bookmark-square' => <<<'SVG'
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.25A2.25 2.25 0 0 1 7.5 3h9A2.25 2.25 0 0 1 18.75 5.25v13.5l-6.75-3-6.75 3V5.25Z" />
                </svg>
            SVG,
            'clipboard-list' => <<<'SVG'
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75h6a1.5 1.5 0 0 1 1.5 1.5v.75H7.5v-.75A1.5 1.5 0 0 1 9 3.75Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6h10.5A2.25 2.25 0 0 1 19.5 8.25V18a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 18V8.25A2.25 2.25 0 0 1 6.75 6Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 10.5h7.5M8.25 14.25h7.5" />
                </svg>
            SVG,
            default => '',
        };
    };
@endphp

<aside
    class="flex shrink-0 flex-col border-r border-slate-700/70 bg-[#040812] transition-[width] duration-200"
    :class="effectiveSidebarExpanded ? 'w-64' : 'w-16'"
>
    <div class="flex h-14 items-center border-b border-slate-700/70 px-2" :class="effectiveSidebarExpanded ? 'justify-between px-3' : 'justify-center'">
        <span class="text-xs font-semibold tracking-[0.18em] text-emerald-400" x-show="effectiveSidebarExpanded" x-cloak>DEVDOCK</span>

        <button
            type="button"
            @click="sidebarExpanded = !sidebarExpanded"
            class="hidden h-8 w-8 items-center justify-center rounded-md border border-slate-700/80 text-slate-300 transition hover:border-slate-500 hover:text-white lg:inline-flex"
            :aria-label="sidebarExpanded ? 'Collapse sidebar' : 'Expand sidebar'"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" :class="effectiveSidebarExpanded ? '' : 'rotate-180'">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 space-y-1 px-1.5 py-3">
        @foreach ($menuItems as $item)
            @php
                $isActive = request()->routeIs($item['route']) || $item['key'] === $activeKey;
            @endphp
            <a
                href="{{ route($item['route']) }}"
                @class([
                    'group flex items-center rounded-lg border py-2 text-sm transition',
                    'border-emerald-500/30 bg-slate-800/65 text-emerald-400 shadow-[inset_0_1px_0_rgba(255,255,255,0.03)]' => $isActive,
                    'border-transparent text-slate-400 hover:border-slate-700/80 hover:bg-slate-800/30 hover:text-slate-100' => ! $isActive,
                ])
                :class="effectiveSidebarExpanded ? 'justify-start gap-2.5 px-2.5' : 'justify-center px-0'"
                title="{{ $item['label'] }}"
                @if ($isActive)
                    aria-current="page"
                @endif
            >
                {!! $icon($item['icon']) !!}
                <span class="truncate" x-show="effectiveSidebarExpanded" x-cloak>{{ $item['label'] }}</span>
                <span class="sr-only">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="border-t border-slate-700/70 py-3" :class="effectiveSidebarExpanded ? 'px-3' : 'px-0'">
        <p class="text-[11px] tracking-[0.14em] text-slate-500" x-show="effectiveSidebarExpanded" x-cloak>NO PROJECT</p>
        <p class="text-center text-slate-500" x-show="!effectiveSidebarExpanded" x-cloak>•</p>
    </div>
</aside>
