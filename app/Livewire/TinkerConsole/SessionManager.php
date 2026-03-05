<?php

namespace App\Livewire\TinkerConsole;

use Illuminate\Support\Str;
use Livewire\Component;

class SessionManager extends Component
{
    public string $projectPath = '';

    public string $environment = 'DEV';

    public array $sessions = [];

    public ?string $activeSessionId = null;

    public function mount(string $projectPath, string $environment = 'DEV'): void
    {
        $this->projectPath = $projectPath;
        $this->environment = strtoupper($environment);

        $this->sessions = [
            [
                'id' => (string) Str::uuid(),
                'name' => 'Main Console',
                'env' => $this->environment,
                'dirty' => false,
                'running' => false,
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Migration Check',
                'env' => $this->environment,
                'dirty' => true,
                'running' => false,
            ],
        ];

        $sessionKey = $this->sessionStoreKey();
        $persistedSessionId = (string) session($sessionKey, $this->sessions[0]['id']);

        $this->activeSessionId = collect($this->sessions)->contains(fn (array $session) => $session['id'] === $persistedSessionId)
            ? $persistedSessionId
            : $this->sessions[0]['id'];

        session([$sessionKey => $this->activeSessionId]);
        $this->dispatchActiveSessionEvent();
    }

    public function createSession(): void
    {
        $newSession = [
            'id' => (string) Str::uuid(),
            'name' => 'Session '.(count($this->sessions) + 1),
            'env' => $this->environment,
            'dirty' => false,
            'running' => false,
        ];

        $this->sessions[] = $newSession;
        $this->activateSession($newSession['id']);
        $this->dispatch('toast', type: 'success', message: 'New session created.');
    }

    public function activateSession(string $sessionId): void
    {
        if (! collect($this->sessions)->contains(fn (array $session) => $session['id'] === $sessionId)) {
            return;
        }

        $this->activeSessionId = $sessionId;
        session([$this->sessionStoreKey() => $sessionId]);
        $this->dispatchActiveSessionEvent();
    }

    public function closeSession(string $sessionId): void
    {
        if (count($this->sessions) === 1) {
            $this->dispatch('toast', type: 'warn', message: 'At least one session is required.');

            return;
        }

        $this->sessions = array_values(array_filter($this->sessions, fn (array $session) => $session['id'] !== $sessionId));

        if ($this->activeSessionId === $sessionId) {
            $this->activeSessionId = $this->sessions[0]['id'];
            session([$this->sessionStoreKey() => $this->activeSessionId]);
            $this->dispatchActiveSessionEvent();
        }

        $this->dispatch('toast', type: 'info', message: 'Session closed.');
    }

    protected function dispatchActiveSessionEvent(): void
    {
        $session = collect($this->sessions)->firstWhere('id', $this->activeSessionId);

        if (! $session) {
            return;
        }

        $this->dispatch('session-switched', sessionId: $session['id'], session: $session);
    }

    protected function sessionStoreKey(): string
    {
        return 'tinker-console.active-session.'.md5($this->projectPath);
    }

    public function render()
    {
        return view('livewire.tinker-console.session-manager');
    }
}
