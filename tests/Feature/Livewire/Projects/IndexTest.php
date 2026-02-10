<?php

use App\Livewire\Projects\Index;
use App\Models\Project;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the project index page', function () {
    $this->get(route('projects.index'))
        ->assertStatus(200)
        ->assertSeeLivewire(Index::class);
});

it('displays projects', function () {
    Project::create([
        'name' => 'Test Project',
        'slug' => 'test-project',
        'local_path' => '/path/to/project',
        'framework' => 'laravel',
    ]);

    Livewire::test(Index::class)
        ->assertSee('Test Project')
        ->assertSee('/path/to/project');
});

it('can create a project', function () {
    Livewire::test(Index::class)
        ->set('name', 'New Project')
        ->set('local_path', '/new/project')
        ->set('framework', 'laravel')
        ->call('create');

    $this->assertDatabaseHas('projects', [
        'name' => 'New Project',
        'local_path' => '/new/project',
    ]);
});

it('validates project creation', function () {
    Livewire::test(Index::class)
        ->set('name', '')
        ->set('local_path', '')
        ->call('create')
        ->assertHasErrors(['name', 'local_path']);
});

it('can search projects', function () {
    Project::create([
        'name' => 'Alpha Project',
        'slug' => 'alpha',
        'local_path' => '/alpha',
        'framework' => 'laravel',
    ]);
    
    Project::create([
        'name' => 'Beta Project',
        'slug' => 'beta',
        'local_path' => '/beta',
        'framework' => 'laravel',
    ]);

    Livewire::test(Index::class)
        ->set('search', 'Alpha')
        ->assertSee('Alpha Project')
        ->assertDontSee('Beta Project');
});
