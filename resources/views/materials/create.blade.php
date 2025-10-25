@extends('layouts.app')

@section('content')
<div class="e-commerce-dashboard">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add New Material</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <!-- Purchase Date -->
                            <div class="col-md-6">
                                <label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="purchase_date" name="purchase_date" required>
                            </div>

                            <!-- Project Selection -->
                            <div class="col-md-6">
                                <label for="project_id" class="form-label">Project <span class="text-danger">*</span></label>
                                <select class="form-select" id="project_id" name="project_id" required>
                                    <option value="">Select Project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Material Type -->
                            <div class="col-md-6">
                                <label for="material_type_id" class="form-label">Material Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="material_type_id" name="material_type_id" required>
                                    <option value="">Select Material Type</option>
                                    @foreach(\App\Models\MaterialType::all() as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->unit }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Material Name -->
                            <div class="col-md-6">
                                <label for="material_name" class="form-label">Material Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="material_name" name="material_name" required>
                            </div>

                            <!-- Vendor Name -->
                            <div class="col-md-6">
                                <label for="vendor_name" class="form-label">Vendor Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
                            </div>

                            <!-- Invoice Number -->
                            <div class="col-md-6">
                                <label for="invoice_number" class="form-label">Bill/Invoice No.</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number">
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-4">
                                <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" required>
                            </div>

                            <!-- Unit -->
                            <div class="col-md-4">
                                <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                                <select class="form-select" id="unit" name="unit" required>
                                    <option value="">Select Unit</option>
                                    <option value="kg">Kilogram (kg)</option>
                                    <option value="g">Gram (g)</option>
                                    <option value="l">Liter (l)</option>
                                    <option value="ml">Milliliter (ml)</option>
                                    <option value="pcs">Pieces (pcs)</option>
                                    <option value="m">Meter (m)</option>
                                    <option value="cm">Centimeter (cm)</option>
                                    <option value="box">Box</option>
                                    <option value="packet">Packet</option>
                                </select>
                            </div>

                            <!-- Unit Price -->
                            <div class="col-md-4">
                                <label for="unit_price" class="form-label">Rate per Unit <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="0.01" class="form-control" id="unit_price" name="unit_price" required>
                                </div>
                            </div>

                            <!-- Total Cost (Auto-calculated) -->
                            <div class="col-md-6">
                                <label class="form-label">Total Cost</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" id="total_cost" name="total_cost" readonly>
                                </div>
                            </div>

                            <!-- Payment Type -->
                            <div class="col-md-6">
                                <label for="payment_type" class="form-label">Payment Mode <span class="text-danger">*</span></label>
                                <select class="form-select" id="payment_type" name="payment_type" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank Transfer</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Credit">Credit</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <!-- Payment Notes -->
                            <div class="col-12">
                                <label for="payment_notes" class="form-label">Remarks</label>
                                <textarea class="form-control" id="payment_notes" name="payment_notes" rows="2" placeholder="Any additional notes or comments"></textarea>
                            </div>

                            <!-- File Upload -->
                            <div class="col-12">
                                <label for="upload_bill" class="form-label">Upload Bill (PDF/Image/Excel - Max 10MB)</label>
                                <input class="form-control" type="file" id="upload_bill" name="upload_bill" accept=".pdf,.jpg,.jpeg,.png,.xlsx,.xls">
                                <div class="form-text">Supported formats: PDF, JPG, PNG, XLSX (Max 10MB)</div>
                            </div>

                            <!-- Hidden field for total cost calculation -->
                            <input type="hidden" id="total_cost_hidden" name="total_cost">

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">Save Material</button>
                                <a href="{{ route('materials.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantity = document.getElementById('quantity');
        const unitPrice = document.getElementById('unit_price');
        const totalCost = document.getElementById('total_cost');
        const totalCostHidden = document.getElementById('total_cost_hidden');

        function calculateTotal() {
            const qty = parseFloat(quantity.value) || 0;
            const price = parseFloat(unitPrice.value) || 0;
            const total = (qty * price).toFixed(2);
            totalCost.value = total;
            totalCostHidden.value = total;
        }

        quantity.addEventListener('input', calculateTotal);
        unitPrice.addEventListener('input', calculateTotal);

        // Auto-fill material name and unit when material type is selected
        const materialTypeSelect = document.getElementById('material_type_id');
        const materialNameInput = document.getElementById('material_name');
        const unitSelect = document.getElementById('unit');

        materialTypeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const parts = selectedOption.text.split(' (');
                if (parts.length >= 2) {
                    const materialName = parts[0];
                    const unit = parts[1].replace(')', '');
                    materialNameInput.value = materialName;
                    
                    // Find and select the unit in the dropdown
                    for (let i = 0; i < unitSelect.options.length; i++) {
                        if (unitSelect.options[i].value === unit) {
                            unitSelect.selectedIndex = i;
                            break;
                        }
                    }
                }
            }
        });
    });
</script>
@endpush

@endsection