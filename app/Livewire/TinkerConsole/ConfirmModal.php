<?php

namespace App\Livewire\TinkerConsole;

use Livewire\Attributes\On;
use Livewire\Component;

class ConfirmModal extends Component
{
    public bool $isOpen = false;

    public int $step = 1;

    public string $command = '';

    public string $classification = 'safe';

    public string $environment = 'DEV';

    public bool $requiresPhrase = false;

    public string $phraseInput = '';

    #[On('request-confirmation')]
    public function openForConfirmation(string $command, string $classification, string $environment, bool $requiresPhrase = false): void
    {
        $this->resetErrorBag();
        $this->isOpen = true;
        $this->step = 1;
        $this->command = $command;
        $this->classification = $classification;
        $this->environment = strtoupper($environment);
        $this->requiresPhrase = $requiresPhrase;
        $this->phraseInput = '';
    }

    #[On('close-confirm-modal')]
    public function cancel(): void
    {
        $this->isOpen = false;
        $this->step = 1;
        $this->phraseInput = '';
    }

    public function continueToSecondStep(): void
    {
        $this->step = 2;
    }

    public function approve(): void
    {
        if ($this->requiresPhrase && strtoupper(trim($this->phraseInput)) !== 'PRODUCTION') {
            $this->addError('phraseInput', 'Type PRODUCTION to continue.');

            return;
        }

        $this->dispatch(
            'execute-approved',
            command: $this->command,
            classification: $this->classification,
        );

        $this->cancel();
    }

    public function render()
    {
        return view('livewire.tinker-console.confirm-modal');
    }
}
