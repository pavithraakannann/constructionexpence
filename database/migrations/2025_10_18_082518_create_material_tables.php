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
        // Create materials table
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            
            // Foreign key to projects table
            $table->unsignedBigInteger('project_id');
            
            // Foreign key to material_types table
            $table->unsignedBigInteger('material_type_id');
            
            $table->string('name');
            $table->string('vendor_name');
            $table->string('invoice_number')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->string('unit', 20);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->enum('payment_type', ['Cash', 'Bank', 'UPI', 'Credit', 'Cheque', 'Other']);
            $table->text('payment_notes')->nullable();
            $table->string('bill_path')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Add foreign key constraints
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('cascade');
                  
            $table->foreign('material_type_id')
                  ->references('id')
                  ->on('material_types')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
