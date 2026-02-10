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
        Schema::create('servers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->string('name');
            $table->string('host');
            $table->integer('port')->default(22);
            $table->string('username');
            $table->string('auth_type')->default('key'); // key | agent
            $table->string('ssh_key_ref')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
