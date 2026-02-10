<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('git_state', function (Blueprint $table) {
            $table->foreignUuid('project_id')->primary()->constrained('projects')->cascadeOnDelete();
            $table->string('current_branch');
            $table->boolean('is_dirty')->default(false);
            $table->string('last_commit_hash');
            $table->timestamp('last_synced_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('git_state');
    }
};
