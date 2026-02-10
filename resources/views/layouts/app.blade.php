<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Laravel Dev Control Center' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased text-slate-400 bg-slate-900">
    <div class="flex h-full">
        <!-- Global Sidebar -->
        <livewire:sidebar />

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden bg-black">
            <!-- Top Navigation (Context Aware) -->
            @if(isset($header))
                <header class="flex-shrink-0 bg-slate-900 relative z-10">
                    {{ $header }}
                </header>
            @endif

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>