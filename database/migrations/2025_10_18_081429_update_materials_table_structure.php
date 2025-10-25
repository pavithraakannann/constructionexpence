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
        Schema::table('materials', function (Blueprint $table) {
            // Drop existing columns that are no longer needed
            $table->dropColumn(['name', 'description', 'supplier_id', 'status', 'notes']);
            
            // Add new columns
            $table->string('material_name');
            $table->string('invoice_number')->nullable();
            $table->string('vendor_name');
            $table->date('purchase_date');
            $table->enum('payment_type', ['Cash', 'Bank', 'UPI', 'Credit', 'Cheque', 'Other']);
            $table->string('upload_bill')->nullable();
            $table->text('payment_notes')->nullable();
            
            // Update existing columns
            $table->decimal('unit_price', 10, 2)->change();
            $table->decimal('quantity', 10, 2)->change();
            $table->decimal('total_cost', 10, 2)->change();
            
            // Add foreign key for material type
            $table->foreignId('material_type_id')->constrained('material_types');
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            // Recreate dropped columns
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained();
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            
            // Drop new columns
            $table->dropColumn([
                'material_name',
                'invoice_number',
                'vendor_name',
                'purchase_date',
                'payment_type',
                'upload_bill',
                'payment_notes',
                'material_type_id'
            ]);
        });
    }
};
