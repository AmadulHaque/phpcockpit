<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class Ssh extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.ssh', [
            'sessions' => [
                [
                    'id' => 1,
                    'user' => 'forge',
                    'host' => '192.168.1.100',
                    'status' => 'connected',
                    'last_activity' => '2 mins ago'
                ],
                [
                    'id' => 2,
                    'user' => 'root',
                    'host' => '192.168.1.101',
                    'status' => 'disconnected',
                    'last_activity' => '1 day ago'
                ]
            ]
        ]);
    }
}
