<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProjectsTable
 *
 * This class handles the migration for creating the 'projects' table.
 * It includes methods for running and reversing the migration.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method is called when the migration is executed. It creates the 'projects' table
     * with the necessary columns and indexes.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            # Create an auto-incrementing primary key
            $table->uuid('id')->primary();

            # Name of the project
            $table->string('name');

            # Detailed description of the project, can be null
            $table->text('description')->default('')->nullable();

            $table->foreignId('owner_id')->constrained('users');

            # Status of the project with a default value of 'active'
            $table->enum('status', ['active', 'inactive'])->default('active');

            # Timestamp columns: 'created_at' and 'updated_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method is called when the migration is rolled back. It drops the 'projects' table.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
