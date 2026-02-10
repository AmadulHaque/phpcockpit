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
        Schema::create('databases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('environment_id')->constrained('environments')->cascadeOnDelete();
            $table->string('name');
            $table->string('driver'); // mysql | pgsql | sqlite
            $table->string('host');
            $table->integer('port');
            $table->string('database');
            $table->string('username');
            $table->string('password_ref')->nullable();
            $table->boolean('is_readonly')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databases');
    }
};
