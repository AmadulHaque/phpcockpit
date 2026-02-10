<?php

namespace Tests\Feature\Livewire\Projects;

use App\Livewire\Projects\Show;
use App\Models\AuditLog;
use App\Models\Environment;
use App\Models\GitState;
use App\Models\Project;
use App\Models\RuntimeVersion;
use App\Models\SavedCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Str;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_successfully()
    {
        $project = Project::create([
            'id' => Str::uuid(),
            'name' => 'Test Project',
            'slug' => 'test-project',
            'local_path' => '/path/to/project',
            'framework' => 'Laravel',
        ]);

        Livewire::test(Show::class, ['project' => $project])
            ->assertStatus(200)
            ->assertSee('Test Project')
            ->assertSee('Overview');
    }

    public function test_displays_project_details()
    {
        $php = RuntimeVersion::create([
            'id' => Str::uuid(),
            'type' => 'php',
            'version' => '8.3',
            'source' => 'Homebrew',
        ]);

        $env = Environment::create([
            'id' => Str::uuid(),
            'name' => 'Local',
            'slug' => 'local',
            'type' => 'local',
        ]);

        $project = Project::create([
            'id' => Str::uuid(),
            'name' => 'Detail Project',
            'slug' => 'detail-project',
            'local_path' => '/code/detail',
            'framework' => 'Laravel',
            'php_version_id' => $php->id,
        ]);

        GitState::create([
            'project_id' => $project->id,
            'current_branch' => 'feature/login',
            'is_dirty' => true,
            'last_commit_hash' => 'abc1234',
            'last_synced_at' => now(),
        ]);

        SavedCommand::create([
            'id' => Str::uuid(),
            'project_id' => $project->id,
            'environment_id' => $env->id,
            'name' => 'Run Tests',
            'command' => 'php artisan test',
        ]);

        AuditLog::create([
            'id' => Str::uuid(),
            'project_id' => $project->id,
            'action' => 'Project Created',
        ]);

        Livewire::test(Show::class, ['project' => $project])
            ->assertSee('Detail Project')
            ->assertSee('feature/login')
            ->assertSee('Dirty')
            ->assertSee('8.3')
            ->assertSee('Run Tests')
            ->assertSee('Project Created');
    }

    public function test_can_switch_tabs()
    {
        $project = Project::create([
            'id' => Str::uuid(),
            'name' => 'Test Project',
            'slug' => 'test-project',
            'local_path' => '/path/to/project',
            'framework' => 'Laravel',
        ]);

        AuditLog::create([
            'id' => Str::uuid(),
            'project_id' => $project->id,
            'action' => 'Deployed to Production',
        ]);

        Livewire::test(Show::class, ['project' => $project])
            ->set('activeTab', 'tinker')
            ->assertSee('Interactive Shell')
            ->set('activeTab', 'database')
            ->assertSee('Query Editor')
            ->set('activeTab', 'ssh')
            ->assertSee('SSH Sessions')
            ->set('activeTab', 'notes')
            ->assertSee('Project Notes')
            ->set('activeTab', 'audit')
            ->assertSee('Deployed to Production');
    }
}
