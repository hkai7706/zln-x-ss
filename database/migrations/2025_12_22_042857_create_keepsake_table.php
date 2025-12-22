<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for keepsakes table
 * Compatible with both MySQL and PostgreSQL
 * Run: php artisan migrate
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keepsakes', function (Blueprint $table) {
            $table->id();
            
            // Basic keepsake information
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('memory_date');
            
            // Categorization
            $table->string('category', 50); // first_date, anniversary, trip, etc.
            $table->string('mood', 20)->nullable(); // emoji or mood text
            $table->json('tags')->nullable(); // Additional tags array
            
            // Media
            $table->text('image_path')->nullable(); // Stored image path
            $table->string('image_type', 10)->nullable(); // jpg, png, etc.
            
            // Privacy & Organization
            $table->boolean('is_favorite')->default(false);
            $table->boolean('is_private')->default(false);
            $table->string('password')->nullable(); // Hashed password for private keepsakes
            
            // Optional couple/user identification
            $table->string('created_by', 100)->nullable(); // User name(s)
            
            // Metadata
            $table->integer('view_count')->default(0);
            $table->timestamp('last_viewed_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Allow soft delete for trash/restore
            
            // Indexes for better performance
            $table->index('memory_date');
            $table->index('category');
            $table->index('is_favorite');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keepsakes');
    }
};