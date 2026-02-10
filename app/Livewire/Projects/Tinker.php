<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class Tinker extends Component
{
    public Project $project;
    public $output = '';
    public $command = '';

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function run()
    {
        // Mock output for now
        $this->output = json_encode([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'created_at' => now()->toDateTimeString()
        ], JSON_PRETTY_PRINT);
    }

    public function render()
    {
        return view('livewire.projects.tinker');
    }
}
