@extends('layouts.app')
@section('content')

<div class="e-commerce-dashboard">
    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0" id="contacts">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-sm-between gap-3 flex-wrap">
                        <h5 class="card-title mb-0">Materials List</h5>
                        <a href="{{ route('materials.create') }}" class="btn btn-primary">Add New Material</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Project</th>
                                <th>Material</th>
                                <th>Vendor</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Unit Price</th>
                                <th>Total Cost</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materials as $material)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $material->project->name ?? 'N/A' }}</td>
                                <td>{{ $material->materialType->name ?? 'N/A' }}</td>
                                <td>{{ $material->vendor_name }}</td>
                                <td>{{ number_format($material->quantity, 2) }}</td>
                                <td>{{ $material->unit }}</td>
                                <td>₹{{ number_format($material->unit_price, 2) }}</td>
                                <td>₹{{ number_format($material->total_cost, 2) }}</td>
                                <td>{{ $material->purchase_date->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="ri-edit-2-line"></i>
                                        </a>
                                        <button type="button" 
                                            class="btn btn-sm btn-danger delete-btn" 
                                            title="Delete"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal"
                                            data-url="{{ route('materials.destroy', $material->id) }}">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                        <!-- @if($material->bill_path)
                                        <a href="{{ Storage::url($material->bill_path) }}" target="_blank" class="btn btn-sm btn-info" title="View Bill">
                                            <i class="ti ti-file-invoice"></i>
                                        </a>
                                        @endif -->
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">No materials found. <a href="{{ route('materials.create') }}">Add your first material</a></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($materials->hasPages())
                <div class="card-footer">
                    {{ $materials->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this material? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteForm = document.getElementById('deleteForm');
    
    // Add click event to each delete button
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the delete URL from data-url attribute
            const deleteUrl = this.getAttribute('data-url');
            // Update the form action with the correct URL
            deleteForm.action = deleteUrl;
        });
    });
    
    // Handle form submission
    deleteForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...';
        
        // Get the form data
        const formData = new FormData();
        formData.append('_method', 'DELETE');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        // Submit the form via AJAX
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(handleResponse)
        .then(data => handleSuccess(data, submitBtn))
        .catch(error => handleError(error, submitBtn));
    });
    
    function handleResponse(response) {
        if (!response.ok) {
            return response.json().then(err => { 
                throw new Error(err.message || 'An error occurred');
            });
        }
        return response.json();
    }
    
    function handleSuccess(data, submitBtn) {
        // Close the modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        if (modal) {
            modal.hide();
        }
        
        // Show success message
        const toastEl = document.getElementById('successToast');
        const toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 3000 });
        const toastBody = toastEl.querySelector('.toast-body');
        toastBody.textContent = data.message || 'Material deleted successfully';
        toast.show();
        
        // Reload the page after a short delay
        setTimeout(() => {
            window.location.reload();
        }, 1500);
    }
    
    function handleError(error, submitBtn) {
        console.error('Error:', error);
        
        // Reset button state
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Delete';
        }
        
        // Show error message
        const toastEl = document.getElementById('errorToast');
        const toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 5000 });
        const toastBody = toastEl.querySelector('.toast-body');
        toastBody.textContent = error.message || 'An error occurred while deleting the material';
        toast.show();
        
        // Close the modal if it's still open
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        if (modal) {
            modal.hide();
        }
    }
});
</script>
@endpush

<!-- Success Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>

<!-- Error Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>

@endsection