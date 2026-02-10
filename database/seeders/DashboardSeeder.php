<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Environment;
use App\Models\GitState;
use App\Models\Project;
use App\Models\RuntimeVersion;
use App\Models\SavedCommand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        // Runtimes
        $php83 = RuntimeVersion::create([
            'id' => Str::uuid(),
            'type' => 'php',
            'version' => '8.3',
            'source' => 'Homebrew',
            'is_global' => true,
        ]);

        $node20 = RuntimeVersion::create([
            'id' => Str::uuid(),
            'type' => 'node',
            'version' => '20.11',
            'source' => 'NVM',
            'is_global' => true,
        ]);

        // Environments
        $localEnv = Environment::create([
            'id' => Str::uuid(),
            'name' => 'Local',
            'slug' => 'local',
            'type' => 'local',
            'is_protected' => false,
        ]);

        $stagingEnv = Environment::create([
            'id' => Str::uuid(),
            'name' => 'Staging',
            'slug' => 'staging',
            'type' => 'remote',
            'is_protected' => true,
        ]);

        $prodEnv = Environment::create([
            'id' => Str::uuid(),
            'name' => 'Production',
            'slug' => 'production',
            'type' => 'remote',
            'is_protected' => true,
        ]);

        // Create LDCC Core Project
        $project = Project::create([
            'id' => Str::uuid(),
            'name' => 'LDCC Core',
            'slug' => 'ldcc-core',
            'local_path' => '/code/ldcc-core',
            'framework' => 'Laravel',
            'php_version_id' => $php83->id,
            'node_version_id' => $node20->id,
        ]);

        // Git State
        GitState::create([
            'project_id' => $project->id,
            'current_branch' => 'main',
            'is_dirty' => false,
            'last_commit_hash' => Str::random(7),
            'last_synced_at' => now()->subMinutes(34),
        ]);

        // Saved Commands
        SavedCommand::create([
            'id' => Str::uuid(),
            'project_id' => $project->id,
            'environment_id' => $localEnv->id,
            'name' => 'Run Migrations',
            'command' => 'php artisan migrate',
            'requires_confirmation' => true,
        ]);

        SavedCommand::create([
            'id' => Str::uuid(),
            'project_id' => $project->id,
            'environment_id' => $localEnv->id,
            'name' => 'Tail Logs',
            'command' => 'tail -f storage/logs/laravel.log',
            'requires_confirmation' => false,
        ]);

        SavedCommand::create([
            'id' => Str::uuid(),
            'project_id' => $project->id,
            'environment_id' => $prodEnv->id,
            'name' => 'Backup DB',
            'command' => 'php artisan backup:run',
            'requires_confirmation' => true,
        ]);

        // Audit Logs
        AuditLog::create([
            'id' => Str::uuid(),
            'project_id' => $project->id,
            'environment_id' => $prodEnv->id,
            'action' => 'Deployed to Production',
            'metadata' => json_encode(['user' => 'Jane Doe', 'details' => 'Deployment #1234 successful']),
            'created_at' => now()->subHours(2),
        ]);

        AuditLog::create([
            'id' => Str::uuid(),
            'project_id' => $project->id,
            'environment_id' => $localEnv->id,
            'action' => 'Environment Variable Changed',
            'metadata' => json_encode(['user' => 'John Smith', 'details' => 'Updated APP_DEBUG to false']),
            'created_at' => now()->subHours(5),
        ]);

        // Create Client API Project
        Project::create([
            'id' => Str::uuid(),
            'name' => 'Client API',
            'slug' => 'client-api',
            'local_path' => '/code/client-api',
            'framework' => 'Laravel',
        ]);
    }
}
