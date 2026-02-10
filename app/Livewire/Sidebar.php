<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        return view('livewire.sidebar', [
            'projects' => Project::orderBy('name')->get()
        ]);
    }
}
