@extends('layouts.app')

@section('content')
<div class="e-commerce-dashboard">
    <div class="row g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h5 class="card-title mb-0">Add New Labour Record</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('labours.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Date -->
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                       id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required>
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

                            <!-- Labour Category -->
                            <div class="col-md-6">
                                <label for="labour_category" class="form-label">Labour Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('labour_category') is-invalid @enderror" 
                                        id="labour_category" name="labour_category" required>
                                    <option value="">Select Category</option>
                                    @foreach($labourTypes as $labourType)
                                        <option value="{{ $labourType->id }}" {{ old('labour_category') == $labourType->id ? 'selected' : '' }}>
                                            {{ $labourType->name }} ({{ $labourType->standard_rate }} ₹/{{ $labourType->unit }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('labour_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Labour Name -->
                            <div class="col-md-6">
                                <label for="labour_name" class="form-label">Labour Name</label>
                                <input type="text" class="form-control @error('labour_name') is-invalid @enderror" 
                                       id="labour_name" name="labour_name" 
                                       value="{{ old('labour_name') }}" placeholder="Enter labour name">
                                @error('labour_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Number of Workers -->
                            <div class="col-md-6">
                                <label for="num_workers" class="form-label">Number of Workers <span class="text-danger">*</span></label>
                                <input type="number" min="1" class="form-control @error('num_workers') is-invalid @enderror" 
                                       id="num_workers" name="num_workers" 
                                       value="{{ old('num_workers', 1) }}" required>
                                @error('num_workers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Wage per Worker -->
                            <div class="col-md-6">
                                <label for="wage_per_worker" class="form-label">Wage per Worker (₹) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="0.01" min="0" 
                                           class="form-control @error('wage_per_worker') is-invalid @enderror" 
                                           id="wage_per_worker" name="wage_per_worker" 
                                           value="{{ old('wage_per_worker') }}" required>
                                    @error('wage_per_worker')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Payment Mode -->
                            <div class="col-md-6">
                                <label for="payment_mode" class="form-label">Payment Mode <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_mode') is-invalid @enderror" 
                                        id="payment_mode" name="payment_mode" required>
                                    <option value="">Select Payment Mode</option>
                                    @foreach($paymentModes as $mode)
                                        <option value="{{ $mode }}" {{ old('payment_mode') == $mode ? 'selected' : '' }}>
                                            {{ $mode }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_mode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Attachments -->
                            <div class="col-12">
                                <label for="attachments" class="form-label">Attachments (Optional)</label>
                                <input type="file" class="form-control @error('attachments') is-invalid @enderror" 
                                       id="attachments" name="attachments[]" multiple 
                                       accept="image/*,.pdf,.doc,.docx">
                                <div class="form-text">
                                    Max file size: 2MB per file. Allowed types: jpg, jpeg, png, pdf, doc, docx.
                                    You can select multiple files.
                                </div>
                                @error('attachments.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="filePreview" class="mt-2 row g-2"></div>
                            </div>

                            <!-- Remarks -->
                            <div class="col-12">
                                <label for="remarks" class="form-label">Remarks (Optional)</label>
                                <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                          id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('labours.index') }}" class="btn btn-light">
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

@push('styles')
<style>
    .file-preview {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }
    .file-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .remove-file {
        position: absolute;
        top: 2px;
        right: 2px;
        background: rgba(0,0,0,0.5);
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .file-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-calculate total wage
        const numWorkers = document.getElementById('num_workers');
        const wagePerWorker = document.getElementById('wage_per_worker');
        const totalWage = document.getElementById('total_wage');

        function calculateTotal() {
            if (numWorkers && wagePerWorker && numWorkers.value && wagePerWorker.value) {
                const total = parseFloat(numWorkers.value) * parseFloat(wagePerWorker.value);
                if (totalWage) {
                    totalWage.value = total.toFixed(2);
                }
            }
        }

        if (numWorkers && wagePerWorker) {
            numWorkers.addEventListener('change', calculateTotal);
            numWorkers.addEventListener('input', calculateTotal);
            wagePerWorker.addEventListener('change', calculateTotal);
            wagePerWorker.addEventListener('input', calculateTotal);
        }

        // File preview functionality
        const fileInput = document.getElementById('attachments');
        const filePreview = document.getElementById('filePreview');
        const filesArray = [];

        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const files = e.target.files;
                filePreview.innerHTML = '';
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    
                    if (!file.type.match('image.*')) {
                        continue;
                    }
                    
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const previewContainer = document.createElement('div');
                        previewContainer.className = 'col-6 col-sm-4 col-md-3 col-lg-2';
                        
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'file-preview';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'remove-file';
                        removeBtn.innerHTML = '&times;';
                        removeBtn.onclick = function() {
                            // Remove the file from the file input
                            const dt = new DataTransfer();
                            const input = fileInput;
                            const { files } = input;
                            
                            for (let j = 0; j < files.length; j++) {
                                if (j !== i) {
                                    dt.items.add(files[j]);
                                }
                            }
                            
                            input.files = dt.files;
                            previewContainer.remove();
                            
                            // Trigger change event to update the file list
                            const event = new Event('change');
                            fileInput.dispatchEvent(event);
                        };
                        
                        previewDiv.appendChild(img);
                        previewDiv.appendChild(removeBtn);
                        previewContainer.appendChild(previewDiv);
                        filePreview.appendChild(previewContainer);
                    };
                    
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endpush

@endsection