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
        Schema::create('runtime_versions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type'); // php | node
            $table->string('version');
            $table->string('source'); // brew | asdf | nvm | system
            $table->boolean('is_global')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('runtime_versions');
    }
};
