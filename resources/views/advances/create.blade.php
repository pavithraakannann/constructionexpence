@extends('layouts.app')

@section('content')
<div class="e-commerce-dashboard">
    <div class="row g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h5 class="card-title mb-0">Add New Advance Record</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('advances.store') }}" method="POST" enctype="multipart/form-data" id="advanceForm">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Date -->
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       id="date" 
                                       name="date" 
                                       value="{{ old('date', now()->format('Y-m-d')) }}" 
                                       required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Project Selection -->
                            <div class="col-md-6">
                                <label for="project_id" class="form-label">Project <span class="text-danger">*</span></label>
                                <select class="form-select @error('project_id') is-invalid @enderror" 
                                        id="project_id" name="project_id" required>
                                    <option value="">Select Project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Amount Received -->
                            <div class="col-md-6">
                                <label for="amount_received" class="form-label">Amount Received (₹) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="0.01" min="0" 
                                           class="form-control @error('amount_received') is-invalid @enderror" 
                                           id="amount_received" 
                                           name="amount_received" 
                                           value="{{ old('amount_received') }}" 
                                           required>
                                    @error('amount_received')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Received From -->
                            <div class="col-md-6">
                                <label for="received_from" class="form-label">Received From</label>
                                <input type="text" 
                                       class="form-control @error('received_from') is-invalid @enderror" 
                                       id="received_from" 
                                       name="received_from" 
                                       value="{{ old('received_from') }}" 
                                       placeholder="Person/Organization name">
                                @error('received_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Received By -->
                            <div class="col-md-6">
                                <label for="received_by" class="form-label">Received By</label>
                                <input type="text" 
                                       class="form-control @error('received_by') is-invalid @enderror" 
                                       id="received_by" 
                                       name="received_by" 
                                       value="{{ old('received_by') }}" 
                                       placeholder="Received by person name">
                                @error('received_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Mode -->
                            <div class="col-md-6">
                                <label for="payment_mode" class="form-label">Payment Mode <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_mode') is-invalid @enderror" 
                                        id="payment_mode" name="payment_mode" required>
                                    <option value="">Select Payment Mode</option>
                                    @foreach(['Cash', 'Bank', 'Cheque', 'UPI', 'Other'] as $mode)
                                        <option value="{{ $mode }}" {{ old('payment_mode') == $mode ? 'selected' : '' }}>
                                            {{ $mode }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_mode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Attachment -->
                            <div class="col-md-6">
                                <label for="attachment" class="form-label">Attachment (Optional)</label>
                                <input type="file" 
                                       class="form-control @error('attachment') is-invalid @enderror" 
                                       id="attachment" 
                                       name="attachment" 
                                       accept="image/*,.pdf,.doc,.docx">
                                <div class="form-text">Max file size: 2MB. Allowed types: jpg, jpeg, png, pdf, doc, docx</div>
                                @error('attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div class="col-12">
                                <label for="remarks" class="form-label">Remarks (Optional)</label>
                                <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                          id="remarks" 
                                          name="remarks" 
                                          rows="3">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('advances.index') }}" class="btn btn-light">
                                        <i class="fas fa-arrow-left me-1"></i> Back to List
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Save Record
                                    </button>
                                </div>
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
        const form = document.getElementById('advanceForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Format date to ensure it's in YYYY-MM-DD format
                const dateInput = document.getElementById('date');
                if (dateInput && dateInput.value) {
                    const date = new Date(dateInput.value);
                    dateInput.value = date.toISOString().split('T')[0];
                }
            });
        }
    });
</script>
@endpush

@endsection