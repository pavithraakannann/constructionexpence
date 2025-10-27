@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Labour Record Details</h5>
                    <div>
                        <a href="{{ route('labours.edit', $labour->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('labours.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Basic Information</h6>
                            <dl class="row mb-0">
                                <dt class="col-sm-5">Date:</dt>
                                <dd class="col-sm-7">{{ $labour->date->format('d M, Y') }}</dd>
                                
                                <dt class="col-sm-5">Project:</dt>
                                <dd class="col-sm-7">{{ $labour->project->name }}</dd>
                                
                                <dt class="col-sm-5">Labour Type:</dt>
                                <dd class="col-sm-7">{{ $labour->labourType->name ?? 'N/A' }}</dd>
                                
                                <dt class="col-sm-5">Labour Name:</dt>
                                <dd class="col-sm-7">{{ $labour->labour_name ?? 'N/A' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Payment Details</h6>
                            <dl class="row mb-0">
                                <dt class="col-sm-5">Number of Workers:</dt>
                                <dd class="col-sm-7">{{ $labour->num_workers }}</dd>
                                
                                <dt class="col-sm-5">Wage per Worker:</dt>
                                <dd class="col-sm-7">₹{{ number_format($labour->wage_per_worker, 2) }}</dd>
                                
                                <dt class="col-sm-5">Total Wage:</dt>
                                <dd class="col-sm-7 fw-bold">₹{{ number_format($labour->total_wage, 2) }}</dd>
                                
                                <dt class="col-sm-5">Payment Mode:</dt>
                                <dd class="col-sm-7">{{ $labour->payment_mode }}</dd>
                            </dl>
                        </div>
                    </div>

                    @if($labour->remarks)
                    <div class="mb-4">
                        <h6 class="text-muted">Remarks</h6>
                        <div class="border rounded p-3 bg-light">
                            {{ $labour->remarks }}
                        </div>
                    </div>
                    @endif

                    @if($labour->attachments->count() > 0)
                    <div class="mb-3">
                        <h6 class="text-muted">Attachments ({{ $labour->attachments->count() }})</h6>
                        <div class="row g-3">
                            @foreach($labour->attachments as $attachment)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="card h-100">
                                    <div class="position-relative" style="height: 120px; overflow: hidden;">
                                        @if(str_contains($attachment->file_type, 'image'))
                                            <img src="{{ $attachment->url }}" class="card-img-top h-100 w-100 object-fit-cover" alt="Attachment">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                                <i class="fas fa-file-alt fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute bottom-0 end-0 m-2">
                                            <a href="{{ $attachment->url }}" target="_blank" class="btn btn-sm btn-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('update', $labour)
                                            <button type="button" class="btn btn-sm btn-danger delete-attachment" 
                                                    data-id="{{ $attachment->id }}" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="card-footer p-2 bg-white border-top-0">
                                        <small class="text-muted d-block text-truncate" title="{{ $attachment->file_name }}">
                                            {{ $attachment->file_name }}
                                        </small>
                                        <small class="text-muted">
                                            {{ number_format($attachment->file_size / 1024, 1) }} KB
                                        </small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer text-muted">
                    <small>
                        Created: {{ $labour->created_at->format('d M, Y h:i A') }} | 
                        Updated: {{ $labour->updated_at->format('d M, Y h:i A') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .object-fit-cover {
        object-fit: cover;
    }
    .delete-attachment {
        transition: opacity 0.2s;
    }
    .card:hover .delete-attachment {
        opacity: 1;
    }
    @media (max-width: 576px) {
        .delete-attachment {
            opacity: 1 !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle attachment deletion
        document.querySelectorAll('.delete-attachment').forEach(button => {
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
                            // Show success message
                            const alert = document.createElement('div');
                            alert.className = 'alert alert-success alert-dismissible fade show';
                            alert.innerHTML = `
                                Attachment deleted successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            `;
                            document.querySelector('.card-body').prepend(alert);
                            // Remove alert after 3 seconds
                            setTimeout(() => alert.remove(), 3000);
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

@endsection
