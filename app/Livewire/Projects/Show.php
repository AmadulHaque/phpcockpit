<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class Show extends Component
{
    public Project $project;
    public $activeTab = 'overview';

    public function mount(Project $project)
    {
        $this->project = $project->load([
            'gitState',
            'phpVersion',
            'nodeVersion',
            'savedCommands',
            'auditLogs' => function ($query) {
                $query->take(5);
            }
        ]);
    }

    public function render()
    {
        return view('livewire.projects.show');
    }
}
