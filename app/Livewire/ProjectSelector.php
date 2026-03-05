<?php

namespace App\Livewire;

use Livewire\Component;

class ProjectSelector extends Component
{
    public bool $pickerOpen = false;

    public array $projects = [];

    public string $customPath = '';

    public string $selectedProjectName = '';

    public string $selectedProjectPath = '';

    public string $selectedEnvironment = 'DEV';

    public function mount(): void
    {
        $this->refreshProjects();

        $saved = session('cockpit.selected_project');

        if (is_array($saved) && isset($saved['path'])) {
            $this->applySelection($saved, false);

            return;
        }

        $default = $this->buildProjectMetadata(base_path());

        if ($default) {
            $this->applySelection($default, false);
        }
    }

    public function openPicker(): void
    {
        $this->refreshProjects();
        $this->pickerOpen = true;
    }

    public function closePicker(): void
    {
        $this->pickerOpen = false;
        $this->customPath = '';
    }

    public function chooseProject(string $path): void
    {
        $metadata = $this->buildProjectMetadata($path);

        if (! $metadata) {
            $this->dispatch('toast', type: 'error', message: 'Selected directory is not a Laravel project.');

            return;
        }

        $this->applySelection($metadata, true);
    }

    public function selectCustomProject(): void
    {
        $metadata = $this->buildProjectMetadata($this->customPath);

        if (! $metadata) {
            $this->dispatch('toast', type: 'error', message: 'Path is invalid or not a Laravel project.');

            return;
        }

        $this->applySelection($metadata, true);
    }

    public function refreshProjects(): void
    {
        $this->projects = $this->discoverProjects();
    }

    protected function discoverProjects(): array
    {
        $roots = array_unique([
            base_path(),
            dirname(base_path()),
        ]);

        $discovered = [];

        foreach ($roots as $root) {
            if (! is_dir($root)) {
                continue;
            }

            $directories = [$root];
            $children = glob(rtrim($root, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR) ?: [];
            $directories = array_merge($directories, $children);

            foreach ($directories as $directory) {
                $metadata = $this->buildProjectMetadata($directory);

                if (! $metadata) {
                    continue;
                }

                $discovered[$metadata['path']] = $metadata;
            }
        }

        usort($discovered, fn (array $a, array $b) => strcmp($a['name'], $b['name']));

        return array_values($discovered);
    }

    protected function buildProjectMetadata(string $directory): ?array
    {
        $path = realpath(trim($directory));

        if (! $path || ! is_dir($path) || ! $this->isLaravelProject($path)) {
            return null;
        }

        return [
            'name' => basename($path),
            'path' => $path,
            'environment' => $this->detectEnvironment($path),
        ];
    }

    protected function isLaravelProject(string $path): bool
    {
        $composerFile = $path.DIRECTORY_SEPARATOR.'composer.json';

        if (! is_file($composerFile)) {
            return false;
        }

        $composer = json_decode((string) file_get_contents($composerFile), true);

        return is_array($composer)
            && isset($composer['require'])
            && is_array($composer['require'])
            && array_key_exists('laravel/framework', $composer['require']);
    }

    protected function detectEnvironment(string $path): string
    {
        $envFile = $path.DIRECTORY_SEPARATOR.'.env';

        if (! is_file($envFile)) {
            return 'DEV';
        }

        $environment = 'DEV';
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];

        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#') || ! str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);

            if (trim($key) !== 'APP_ENV') {
                continue;
            }

            $raw = strtoupper(trim(trim($value), "\"'"));
            $environment = match ($raw) {
                'PROD', 'PRODUCTION' => 'PROD',
                'STAGING', 'STAGE' => 'STAGING',
                default => 'DEV',
            };

            break;
        }

        return $environment;
    }

    protected function applySelection(array $metadata, bool $dispatchUpdate): void
    {
        $this->selectedProjectName = $metadata['name'];
        $this->selectedProjectPath = $metadata['path'];
        $this->selectedEnvironment = $metadata['environment'];

        session(['cockpit.selected_project' => $metadata]);

        if ($dispatchUpdate) {
            $this->dispatch(
                'project-context-updated',
                projectName: $metadata['name'],
                projectPath: $metadata['path'],
                environment: $metadata['environment'],
            );

            $this->dispatch('toast', type: 'success', message: 'Project switched to '.$metadata['name'].'.');
        }

        $this->closePicker();
    }

    public function render()
    {
        return view('livewire.project-selector');
    }
}
