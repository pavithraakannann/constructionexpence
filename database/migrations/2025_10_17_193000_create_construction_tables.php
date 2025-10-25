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
        // 1. Create material_types table first (no dependencies)
        if (!Schema::hasTable('material_types')) {
            Schema::create('material_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('unit')->nullable();
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // 2. Create vendors table (no dependencies)
        if (!Schema::hasTable('vendors')) {
            Schema::create('vendors', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('contact_person')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('gst_number')->nullable();
                $table->text('address')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('country')->nullable();
                $table->string('pincode', 10)->nullable();
                $table->text('notes')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // 3. Create projects table (depends on users table which should exist from Laravel's default auth)
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->string('project_id')->unique()->nullable();
                $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null');
                $table->string('name');
                $table->text('description')->nullable();
                $table->date('start_date');
                $table->date('end_date')->nullable();
                $table->decimal('budget', 15, 2)->default(0);
                $table->enum('status', ['planned', 'in_progress', 'on_hold', 'completed', 'cancelled'])->default('planned');
                $table->string('location')->nullable();
                $table->string('contact_name')->nullable();
                $table->string('contact_mobile')->nullable();
                $table->string('reference_name')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // 4. Create materials table (depends on projects, material_types, and vendors)
        if (!Schema::hasTable('materials')) {
            Schema::create('materials', function (Blueprint $table) {
                $table->id();
                $table->date('date');
                $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
                $table->string('name');
                $table->foreignId('material_type_id')->nullable()->constrained('material_types')->onDelete('set null');
                $table->foreignId('vendor_id')->nullable()->constrained('vendors')->onDelete('set null');
                $table->string('bill_invoice_no')->nullable();
                $table->decimal('quantity', 10, 2);
                $table->string('unit');
                $table->decimal('rate_per_unit', 10, 2);
                $table->decimal('total_amount', 10, 2);
                $table->string('payment_mode')->nullable();
                $table->text('remarks')->nullable();
                $table->string('upload_bill')->nullable();
                $table->timestamps();
                $table->softDeletes();
                
                // Add indexes for better performance
                $table->index(['project_id', 'date']);
                $table->index('material_type_id');
                $table->index('vendor_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_tables');
    }
};
