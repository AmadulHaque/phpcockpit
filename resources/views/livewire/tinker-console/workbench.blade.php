<div class="relative overflow-hidden  bg-[#d7d7dd]">
    <div class="mx-auto w-full overflow-hidden border border-[#4f5369] bg-[#202336] shadow-[0_24px_60px_rgba(0,0,0,0.35)]">
        <div class="flex min-h-[700px]">
            <div class="flex min-w-0 flex-1 flex-col">
                <livewire:tinker-console.console-runner
                    :environment="$environment"
                    :project-path="$projectPath"
                    :wire:key="'editor-'.md5($projectPath.'|'.$environment)"
                />
            </div>
        </div>
    </div>
</div>
