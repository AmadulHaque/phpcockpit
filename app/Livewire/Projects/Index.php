<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // Create Project Form
    public $showCreateModal = false;
    public $name = '';
    public $local_path = '';
    public $framework = 'laravel';

    protected $rules = [
        'name' => 'required|min:3',
        'local_path' => 'required|string',
        'framework' => 'required|in:laravel,lumen,generic',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function create()
    {
        $this->validate();

        $slug = \Illuminate\Support\Str::slug($this->name);
        
        // Simple slug uniqueness check
        if (Project::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . uniqid();
        }

        Project::create([
            'name' => $this->name,
            'slug' => $slug,
            'local_path' => $this->local_path,
            'framework' => $this->framework,
        ]);

        $this->reset(['name', 'local_path', 'framework', 'showCreateModal']);
        
        session()->flash('message', 'Project created successfully.');
    }

    public function render()
    {
        $projects = Project::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('local_path', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        return view('livewire.projects.index', [
            'projects' => $projects,
        ]);
    }
}
