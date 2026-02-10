<?php

namespace App\Livewire\Projects;

use App\Models\Note;
use App\Models\Project;
use Livewire\Component;

class Notes extends Component
{
    public Project $project;
    public $content = '';

    public function mount(Project $project)
    {
        $this->project = $project;
        $note = $project->scratchpad;
        $this->content = $note ? $note->content : '';
    }

    public function save()
    {
        $note = $this->project->scratchpad;
        
        if ($note) {
            $note->update(['content' => $this->content]);
        } else {
            $this->project->notes()->create(['content' => $this->content]);
            // Refresh relationship
            $this->project->load('scratchpad');
        }

        session()->flash('message', 'Notes saved successfully.');
    }

    public function render()
    {
        return view('livewire.projects.notes');
    }
}
