@php
    $activeKey = trim($__env->yieldContent('active_key')) ?: 'tinker';
    $pageTitle = trim($__env->yieldContent('page_title')) ?: 'Tinker Console';
    $pageSubtitle = trim($__env->yieldContent('page_subtitle')) ?: 'Select a project first.';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            [x-cloak] {
                display: none !important;
            }

            :root {
                color-scheme: dark;
            }

            body {
                font-family: 'Space Grotesk', sans-serif;
                background:
                    radial-gradient(1000px 700px at -20% -10%, rgb(18 30 46 / 45%), transparent),
                    radial-gradient(900px 600px at 110% -20%, rgb(3 26 29 / 55%), transparent),
                    #05060b;
            }

            .cockpit-scroll::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            .cockpit-scroll::-webkit-scrollbar-thumb {
                background-color: rgb(71 85 105 / 35%);
                border-radius: 9999px;
            }
        </style>
    </head>

    <body class="min-h-screen text-slate-100 antialiased">
        <div x-data="appShell()" x-init="init()" class="h-screen p-2 sm:p-3">
            <div class="mx-auto h-full max-w-[1880px] overflow-hidden rounded-2xl border border-slate-700/60 bg-[#050913] shadow-[0_1px_0_0_rgba(148,163,184,0.08),0_25px_80px_rgba(2,6,23,0.7)]">
                <div class="flex h-full">
                    <x-layouts.sidebar :active-key="$activeKey" />

                    <div class="flex min-w-0 flex-1 flex-col">
                        <x-layouts.navbar project-label="Select a project" />

                        <main class="cockpit-scroll flex-1 overflow-y-auto ">
                            @hasSection('content')
                                @yield('content')
                            @else
                                <h1 class="text-2xl font-semibold tracking-tight text-slate-100 sm:text-3xl">{{ $pageTitle }}</h1>
                                <p class="mt-3 text-sm text-slate-400 sm:text-base">{{ $pageSubtitle }}</p>
                            @endif
                        </main>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('appShell', () => ({
                    sidebarExpanded: true,
                    isDesktop: window.matchMedia('(min-width: 1024px)').matches,
                    get effectiveSidebarExpanded() {
                        return this.isDesktop && this.sidebarExpanded;
                    },
                    init() {
                        const savedSidebarState = localStorage.getItem('cockpit.sidebarExpanded');

                        if (savedSidebarState !== null) {
                            this.sidebarExpanded = savedSidebarState === 'true';
                        }

                        this.$watch('sidebarExpanded', (isExpanded) => {
                            localStorage.setItem('cockpit.sidebarExpanded', isExpanded);
                        });

                        const mediaQuery = window.matchMedia('(min-width: 1024px)');
                        const syncDeviceMode = (event) => {
                            this.isDesktop = event.matches;
                        };

                        mediaQuery.addEventListener('change', syncDeviceMode);
                    },
                }));
            });
        </script>
        @livewireScriptConfig
    </body>
</html>
