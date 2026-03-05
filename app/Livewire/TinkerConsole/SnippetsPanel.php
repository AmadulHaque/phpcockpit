<?php

namespace App\Livewire\TinkerConsole;

use Livewire\Component;

class SnippetsPanel extends Component
{
    public string $search = '';

    public string $activeTag = 'all';

    public array $snippets = [];

    public function mount(): void
    {
        $this->snippets = [
            [
                'id' => 'cache-clear',
                'title' => 'Clear app cache',
                'command' => 'php artisan optimize:clear',
                'tags' => ['maintenance', 'cache'],
                'destructive' => false,
                'requires_confirmation' => false,
            ],
            [
                'id' => 'migrate-status',
                'title' => 'Migration status',
                'command' => 'php artisan migrate:status',
                'tags' => ['database'],
                'destructive' => false,
                'requires_confirmation' => false,
            ],
            [
                'id' => 'queue-restart',
                'title' => 'Restart queue workers',
                'command' => 'php artisan queue:restart',
                'tags' => ['queue', 'maintenance'],
                'destructive' => false,
                'requires_confirmation' => true,
            ],
            [
                'id' => 'fresh-migrate',
                'title' => 'Fresh migrate seed',
                'command' => 'php artisan migrate:fresh --seed',
                'tags' => ['database', 'destructive'],
                'destructive' => true,
                'requires_confirmation' => true,
            ],
        ];
    }

    public function insertSnippet(string $snippetId): void
    {
        $snippet = collect($this->snippets)->firstWhere('id', $snippetId);

        if (! $snippet) {
            return;
        }

        $this->dispatch(
            'snippet-selected',
            command: $snippet['command'],
            destructive: (bool) $snippet['destructive'],
            requiresConfirmation: (bool) $snippet['requires_confirmation'],
        );

        $this->dispatch('toast', type: 'success', message: 'Snippet inserted into command input.');
    }

    public function setActiveTag(string $tag): void
    {
        $this->activeTag = $tag;
    }

    protected function availableTags(): array
    {
        return collect($this->snippets)
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    protected function filteredSnippets(): array
    {
        return collect($this->snippets)
            ->filter(function (array $snippet): bool {
                $matchesSearch = $this->search === ''
                    || str_contains(strtolower($snippet['title'].' '.$snippet['command']), strtolower($this->search));

                $matchesTag = $this->activeTag === 'all'
                    || in_array($this->activeTag, $snippet['tags'], true);

                return $matchesSearch && $matchesTag;
            })
            ->values()
            ->all();
    }

    public function render()
    {
        return view('livewire.tinker-console.snippets-panel', [
            'availableTags' => $this->availableTags(),
            'filteredSnippets' => $this->filteredSnippets(),
        ]);
    }
}
