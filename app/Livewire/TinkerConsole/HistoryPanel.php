<?php

namespace App\Livewire\TinkerConsole;

use Livewire\Attributes\On;
use Livewire\Component;

class HistoryPanel extends Component
{
    public string $search = '';

    public string $environmentFilter = 'all';

    public array $entries = [];

    public array $pinnedIds = [];

    public function mount(string $environment = 'DEV'): void
    {
        $this->entries = [
            [
                'id' => 'seed-1',
                'command' => 'php artisan about',
                'environment' => strtoupper($environment),
                'duration_ms' => 44,
                'timestamp' => now()->subMinutes(10)->format('H:i:s'),
                'status' => 'success',
            ],
            [
                'id' => 'seed-2',
                'command' => 'php artisan cache:clear',
                'environment' => strtoupper($environment),
                'duration_ms' => 125,
                'timestamp' => now()->subMinutes(6)->format('H:i:s'),
                'status' => 'success',
            ],
        ];
    }

    #[On('history-recorded')]
    public function appendHistory(array $entry): void
    {
        $this->entries = array_values([$entry, ...$this->entries]);
    }

    public function togglePin(string $entryId): void
    {
        if (in_array($entryId, $this->pinnedIds, true)) {
            $this->pinnedIds = array_values(array_filter($this->pinnedIds, fn (string $id) => $id !== $entryId));

            return;
        }

        $this->pinnedIds[] = $entryId;
    }

    public function replay(string $entryId): void
    {
        $entry = collect($this->entries)->firstWhere('id', $entryId);

        if (! $entry) {
            return;
        }

        $this->dispatch('history-replay', command: $entry['command']);
        $this->dispatch('toast', type: 'info', message: 'Command replayed into input.');
    }

    public function copy(string $entryId): void
    {
        $entry = collect($this->entries)->firstWhere('id', $entryId);

        if (! $entry) {
            return;
        }

        $this->dispatch('copy-to-clipboard', text: $entry['command']);
        $this->dispatch('toast', type: 'success', message: 'Command copied.');
    }

    protected function filteredEntries(): array
    {
        $entries = collect($this->entries)->filter(function (array $entry): bool {
            $matchesSearch = $this->search === ''
                || str_contains(strtolower($entry['command']), strtolower($this->search));

            $matchesEnvironment = $this->environmentFilter === 'all'
                || strtoupper($entry['environment']) === strtoupper($this->environmentFilter);

            return $matchesSearch && $matchesEnvironment;
        });

        return $entries
            ->sortByDesc(fn (array $entry) => in_array($entry['id'], $this->pinnedIds, true))
            ->values()
            ->all();
    }

    public function render()
    {
        return view('livewire.tinker-console.history-panel', [
            'filteredEntries' => $this->filteredEntries(),
        ]);
    }
}
