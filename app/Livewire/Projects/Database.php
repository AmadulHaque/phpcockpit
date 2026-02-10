<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class Database extends Component
{
    public Project $project;
    public $search = '';

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.database', [
            'tables' => [
                'users', 'posts', 'comments', 'failed_jobs', 'migrations', 'personal_access_tokens', 'sessions', 'password_reset_tokens'
            ],
            'rows' => collect(range(1, 10))->map(function ($i) {
                return [
                    'id' => $i,
                    'email' => "user_{$i}@example.com",
                    'name' => "Development User {$i}",
                    'created_at' => now()->subDays($i)->toDateTimeString()
                ];
            })
        ]);
    }
}
