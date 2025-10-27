@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Labour Record</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('labours.update', $labour->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" 
                                   value="{{ old('date', $labour->date ? $labour->date->format('Y-m-d') : '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="project_id" class="form-label">Project</label>
                            <select class="form-select" id="project_id" name="project_id" required>
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ $labour->project_id == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="labour_category" class="form-label">Labour Category</label>
                            <select class="form-select" id="labour_category" name="labour_category" required>
                                <option value="">Select Category</option>
                                @foreach($labourTypes as $labourType)
                                    <option value="{{ $labourType->id }}" 
                                        {{ old('labour_category', $labour->labour_type_id) == $labourType->id ? 'selected' : '' }}>
                                        {{ $labourType->name }} ({{ $labourType->standard_rate }} ₹/{{ $labourType->unit }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="labour_name" class="form-label">Labour Name</label>
                            <input type="text" class="form-control" id="labour_name" 
                                   name="labour_name" value="{{ old('labour_name', $labour->labour_name) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="num_workers" class="form-label">Number of Workers</label>
                                    <input type="number" class="form-control" id="num_workers" 
                                           name="num_workers" value="{{ old('num_workers', $labour->num_workers) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="wage_per_worker" class="form-label">Wage per Worker (₹)</label>
                                    <input type="number" step="0.01" class="form-control" id="wage_per_worker" 
                                           name="wage_per_worker" value="{{ old('wage_per_worker', $labour->wage_per_worker) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="total_wage" class="form-label">Total Wage (₹)</label>
                            <input type="number" step="0.01" class="form-control" id="total_wage" 
                                   name="total_wage" value="{{ old('total_wage', $labour->total_wage) }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="payment_mode" class="form-label">Payment Mode</label>
                            <select class="form-select" id="payment_mode" name="payment_mode" required>
                                <option value="Cash" {{ $labour->payment_mode == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Bank" {{ $labour->payment_mode == 'Bank' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="Cheque" {{ $labour->payment_mode == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="UPI" {{ $labour->payment_mode == 'UPI' ? 'selected' : '' }}>UPI</option>
                                <option value="Other" {{ $labour->payment_mode == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="2">{{ old('remarks', $labour->remarks) }}</textarea>
                        </div>

                        <!-- Existing Attachments -->
                        <div class="mb-4">
                            <label class="form-label">Current Attachments</label>
                            @if($labour->attachments->count() > 0)
                                <div class="row g-2" id="existingAttachments">
                                    @foreach($labour->attachments as $attachment)
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2" id="attachment-{{ $attachment->id }}">
                                        <div class="file-preview">
                                            @if(Str::startsWith($attachment->file_type, 'image/'))
                                                <img src="{{ asset('storage/' . $attachment->file_path) }}" class="img-thumbnail w-100" style="height: 100px; object-fit: cover;" alt="Attachment">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center bg-light" style="height: 100px;">
                                                    <i class="fas fa-file-alt fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                            <button type="button" class="remove-file" data-id="{{ $attachment->id }}">
                                                &times;
                                            </button>
                                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="view-file" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                        <small class="d-block text-truncate" title="{{ $attachment->file_name }}">
                                            {{ $attachment->file_name }}
                                        </small>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No attachments found.</p>
                            @endif
                        </div>

                        <!-- New Attachments -->
                        <div class="mb-3">
                            <label for="attachments" class="form-label">Add More Attachments</label>
                            <input type="file" class="form-control @error('attachments.*') is-invalid @enderror" 
                                   id="attachments" name="attachments[]" multiple 
                                   accept="image/*,.pdf,.doc,.docx">
                            @error('attachments.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Max file size: 2MB per file. Allowed types: jpg, jpeg, png, pdf, doc, docx.
                            </div>
                            <div id="filePreview" class="row g-2 mt-2"></div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('labours.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Record
                            </button>
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
        width: 100%;
        height: 100px;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }
    .file-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .remove-file, .view-file {
        position: absolute;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 50%;
        color: white;
        cursor: pointer;
    }
    .remove-file {
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.8);
    }
    .view-file {
        bottom: 5px;
        right: 5px;
        background: rgba(13, 110, 253, 0.8);
        text-decoration: none;
    }
    .view-file:hover {
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    // Remove attachment
    document.addEventListener('DOMContentLoaded', function() {
        // Handle removal of existing attachments
        document.querySelectorAll('.remove-file').forEach(button => {
            button.addEventListener('click', function() {
                const attachmentId = this.dataset.id;
                if (confirm('Are you sure you want to delete this attachment?')) {
                    fetch(`/labours/attachments/${attachmentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('.col-6').remove();
                        }
                    });
                }
            });
        });
    });

    // File preview for new attachments
    document.getElementById('attachments')?.addEventListener('change', function(e) {
        const preview = document.getElementById('filePreview');
        
        Array.from(this.files).forEach((file, index) => {
            if (!file.type.match('image.*')) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const fileId = 'new-file-' + Date.now() + '-' + index;
                const col = document.createElement('div');
                col.className = 'col-6 col-sm-4 col-md-3 col-lg-2';
                col.id = fileId;
                col.innerHTML = `
                    <div class="file-preview">
                        <img src="${e.target.result}" class="img-thumbnail">
                        <button type="button" class="remove-file" data-file-id="${fileId}">
                            &times;
                        </button>
                    </div>
                    <small class="d-block text-truncate" title="${file.name}">
                        ${file.name}
                    </small>
                `;
                preview.appendChild(col);
                
                // Add event listener for the remove button
                col.querySelector('.remove-file').addEventListener('click', function() {
                    // Remove the file from the file input
                    const dt = new DataTransfer();
                    const input = document.getElementById('attachments');
                    const { files } = input;
                    
                    for (let i = 0; i < files.length; i++) {
                        if (i !== index) {
                            dt.items.add(files[i]);
                        }
                    }
                    
                    input.files = dt.files;
                    col.remove();
                });
            };
            reader.readAsDataURL(file);
        });
    });
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Calculate total wage when number of workers or wage per worker changes
    document.addEventListener('DOMContentLoaded', function() {
        const numWorkers = document.getElementById('num_workers');
        const wagePerWorker = document.getElementById('wage_per_worker');
        const totalWage = document.getElementById('total_wage');

        function calculateTotalWage() {
            const workers = parseFloat(numWorkers.value) || 0;
            const wage = parseFloat(wagePerWorker.value) || 0;
            totalWage.value = (workers * wage).toFixed(2);
        }

        numWorkers.addEventListener('input', calculateTotalWage);
        wagePerWorker.addEventListener('input', calculateTotalWage);

        // Calculate on page load
        calculateTotalWage();
    });
</script>
@endpush

@endsection