<?php

namespace App\Livewire\TinkerConsole;

use Livewire\Attributes\On;
use Livewire\Component;

class Workbench extends Component
{
    public string $projectPath;

    public string $environment;

    public function mount(?string $projectPath = null, ?string $environment = null): void
    {
        $saved = session('cockpit.selected_project');

        if (is_array($saved) && isset($saved['name'], $saved['path'], $saved['environment'])) {
            $this->projectPath = (string) $saved['path'];
            $this->environment = $this->mapEnvironment((string) $saved['environment']);

            return;
        }

        $this->projectPath = $projectPath ?? base_path();
        $this->environment = $this->mapEnvironment($environment ?? (string) config('app.env', 'dev'));
    }

    #[On('project-context-updated')]
    public function updateProjectContext(string $projectName, string $projectPath, string $environment): void
    {
        $this->projectPath = $projectPath;
        $this->environment = $this->mapEnvironment($environment);
    }

    protected function mapEnvironment(string $environment): string
    {
        $mappedEnvironment = strtoupper($environment);

        return match ($mappedEnvironment) {
            'PRODUCTION', 'PROD' => 'PROD',
            'STAGING', 'STAGE' => 'STAGING',
            default => 'DEV',
        };
    }

    public function render()
    {
        return view('livewire.tinker-console.workbench');
    }
}
