<?php

namespace App\Livewire\TinkerConsole;

use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class ConsoleRunner extends Component
{
    public string $projectPath = '';

    public string $environment = 'DEV';

    public bool $prodLocked = true;

    public bool $readOnly = false;

    public bool $autoScroll = true;

    public bool $running = false;

    public string $commandInput = '';

    public string $placeholderOutput = '';

    public array $outputBlocks = [];

    public array $commandHistory = [];

    public int $historyCursor = -1;

    public function mount(string $environment = 'DEV', string $projectPath = ''): void
    {
        $this->environment = strtoupper($environment);
        $this->projectPath = $projectPath;
        $this->prodLocked = $this->environment === 'PROD';
        $this->commandInput = '';
        $this->placeholderOutput = '';
    }

    #[On('project-context-updated')]
    public function onProjectContextUpdated(string $projectName, string $projectPath, string $environment): void
    {
        $this->projectPath = $projectPath;
        $this->environment = strtoupper($environment);
        $this->prodLocked = $this->environment === 'PROD';
    }

    #[On('run-command')]
    public function runFromShortcut(): void
    {
        $this->runCommand();
    }

    #[On('clear-console-shortcut')]
    public function clearFromShortcut(): void
    {
        $this->clearConsole();
    }

    #[On('history-cycle-up')]
    public function historyUp(): void
    {
        $this->cycleHistory('up');
    }

    #[On('history-cycle-down')]
    public function historyDown(): void
    {
        $this->cycleHistory('down');
    }

    public function runCommand(): void
    {
        if ($this->running) {
            return;
        }

        $command = trim($this->commandInput);

        if ($command === '') {
            $this->dispatch('toast', type: 'warn', message: 'Write PHP/Laravel snippet first.');

            return;
        }

        $classification = $this->classifyCommand($command);

        if ($this->readOnly && $classification !== 'safe') {
            $this->dispatch('toast', type: 'error', message: 'Read-only mode blocks non-safe commands.');

            return;
        }

        if ($this->environment === 'PROD' && $classification === 'hard-danger' && $this->prodLocked) {
            $this->dispatch('toast', type: 'error', message: 'Prod lock is enabled. Hard-danger commands are blocked.');

            return;
        }

        $this->executeCommand($command, $classification);
    }

    public function cancelCommand(): void
    {
        if (! $this->running) {
            return;
        }

        $this->running = false;
        $this->dispatch('toast', type: 'warn', message: 'Execution cancelled.');
    }

    public function clearConsole(): void
    {
        $this->outputBlocks = [];
        $this->dispatch('console-output-updated');
        $this->dispatch('toast', type: 'info', message: 'Output cleared.');
    }

    public function copyLatestOutput(): void
    {
        $output = collect($this->outputBlocks)->last()['output'] ?? $this->placeholderOutput;
        $this->dispatch('copy-to-clipboard', text: $output);
        $this->dispatch('toast', type: 'success', message: 'Output copied.');
    }

    public function cycleHistory(string $direction): void
    {
        $historyCount = count($this->commandHistory);

        if ($historyCount === 0) {
            return;
        }

        if ($direction === 'up' && $this->historyCursor < $historyCount - 1) {
            $this->historyCursor++;
        }

        if ($direction === 'down' && $this->historyCursor > -1) {
            $this->historyCursor--;
        }

        if ($this->historyCursor === -1) {
            return;
        }

        $this->commandInput = $this->commandHistory[$historyCount - 1 - $this->historyCursor];
    }

    protected function executeCommand(string $command, string $classification): void
    {
        $this->running = true;

        $startedAt = microtime(true);
        usleep(140000);

        $status = preg_match('/(fail|error|exception)/i', $command) ? 'fail' : 'success';
        $durationMs = (int) round((microtime(true) - $startedAt) * 1000);

        $this->outputBlocks[] = [
            'id' => (string) Str::uuid(),
            'command' => $command,
            'status' => $status,
            'classification' => $classification,
            'timestamp' => now()->format('H:i:s'),
            'duration_ms' => $durationMs,
            'output' => $this->generateOutput($command, $status, $classification),
        ];

        $this->commandHistory[] = $command;
        $this->historyCursor = -1;

        $this->dispatch('console-output-updated');
        $this->dispatch('toast', type: $status === 'success' ? 'success' : 'error', message: 'Snippet executed (simulated).');

        $this->running = false;
    }

    protected function classifyCommand(string $command): string
    {
        $normalized = strtolower(trim($command));

        if ($normalized === '') {
            return 'safe';
        }

        $hardDangerPatterns = [
            '/\brm\s+-rf\b/',
            '/\b(migrate:fresh|db:wipe)\b/',
            '/\b(drop|truncate)\b.*\b(database|table)\b/',
        ];

        foreach ($hardDangerPatterns as $pattern) {
            if (preg_match($pattern, $normalized)) {
                return 'hard-danger';
            }
        }

        $warnPatterns = [
            '/\b(delete|update|truncate|drop)\b/',
            '/\bmigrate(?!:status)\b/',
            '/\b(queue:restart|cache:clear|optimize:clear)\b/',
        ];

        foreach ($warnPatterns as $pattern) {
            if (preg_match($pattern, $normalized)) {
                return 'warn';
            }
        }

        return 'safe';
    }

    protected function generateOutput(string $command, string $status, string $classification): string
    {
        if (str_contains($command, 'Http::withHeaders')) {
            return <<<'OUT'
Illuminate\Http\Client\Response {#2386
  #response: GuzzleHttp\Psr7\Response {#2420
    -reasonPhrase: "No Content"
    -statusCode: 204
    -headers: [
      "Server" => [
        "nginx",
      ],
      "Connection" => [
        "keep-alive",
      ],
      "Cache-Control" => [
        "no-cache, private",
      ],
    ]
  }
}
OUT;
        }

        $lines = [
            'Snippet context',
            'Project: '.$this->projectPath,
            'Environment: '.$this->environment,
            'Classification: '.$classification,
            $status === 'success' ? 'Result: execution finished successfully.' : 'Result: execution failed.',
        ];

        return implode(PHP_EOL, $lines);
    }

    public function render()
    {
        return view('livewire.tinker-console.console-runner', [
            'currentClassification' => $this->classifyCommand($this->commandInput),
        ]);
    }
}
