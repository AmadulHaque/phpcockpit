<?php

namespace App\Livewire\TinkerConsole;

use Livewire\Component;

class SafetyBanner extends Component
{
    public string $environment = 'DEV';

    public function mount(string $environment = 'DEV'): void
    {
        $this->environment = strtoupper($environment);
    }

    public function render()
    {
        return view('livewire.tinker-console.safety-banner');
    }
}
