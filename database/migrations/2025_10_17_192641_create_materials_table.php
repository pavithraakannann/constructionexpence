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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->foreignId('material_type_id')->nullable()->constrained()->onDelete('set null');
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
