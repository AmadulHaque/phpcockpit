<?php

namespace App\Livewire\TinkerConsole;

use Livewire\Attributes\On;
use Livewire\Component;

class Workbench extends Component
{
    public string $projectName;

    public string $projectPath;

    public string $environment;

    public string $connectionMode = 'Local';

    public function mount(?string $projectName = null, ?string $projectPath = null, ?string $environment = null, ?string $connectionMode = null): void
    {
        $saved = session('cockpit.selected_project');

        if (is_array($saved) && isset($saved['name'], $saved['path'], $saved['environment'])) {
            $this->projectName = (string) $saved['name'];
            $this->projectPath = (string) $saved['path'];
            $this->environment = $this->mapEnvironment((string) $saved['environment']);
            $this->connectionMode = $connectionMode ?? 'Local';

            return;
        }

        $this->projectName = $projectName ?? (string) config('app.name', 'NativePHP Cockpit');
        $this->projectPath = $projectPath ?? base_path();
        $this->environment = $this->mapEnvironment($environment ?? (string) config('app.env', 'dev'));
        $this->connectionMode = $connectionMode ?? 'Local';
    }

    #[On('project-context-updated')]
    public function updateProjectContext(string $projectName, string $projectPath, string $environment): void
    {
        $this->projectName = $projectName;
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
