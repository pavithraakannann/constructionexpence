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
        // First, drop the existing projects table if it exists
        Schema::dropIfExists('projects');
        
        // Then create it again with the correct structure
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_id', 10)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('budget', 15, 2);
            $table->string('status')->default('pending');
            $table->string('contact_name')->nullable();
            $table->string('contact_mobile', 10)->nullable();
            $table->string('reference_name')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
