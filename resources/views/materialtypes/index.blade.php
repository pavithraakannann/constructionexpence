@extends('layouts.app')

@section('content')

<div class="e-commerce-dashboard">
    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0" id="contacts">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-sm-between gap-3 flex-wrap">
                        <h5 class="card-title mb-0">Material Types</h5>
                        <!-- Search Input -->
                        <input type="text" class="form-control max-w-300px" placeholder="Search contact" id="search-input">
                        <button class="btn btn-primary" id="add-material-type">Create</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="sort">ID</th>
                                <th class="sort" data-sort="name">Name</th>
                                <th class="sort" data-sort="description">Description</th>
                                <th class="sort" data-sort="unit">Unit</th>
                                <!-- <th class="sort" data-sort="status">Status</th> -->
                                <!-- <th class="sort" data-sort="actions">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($materialTypes as $type)
                            <tr>
                                <td class="id">{{ $type->id }}</td>
                                <td class="name">{{ $type->name }}</td>
                                <td class="description">{{ $type->description ?? 'N/A' }}</td>
                                <td class="unit">{{ $type->unit }}</td>
                                <!-- <td class="status">
                                    <span class="badge {{ $type->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $type->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td> -->
                                <!-- <td>
                                    <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $type->id }}">
                                        <i class="ri-edit-2-line"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $type->id }}">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </td> -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="materialTypeModal" tabindex="-1" aria-labelledby="materialTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="materialTypeModalLabel">Add Material Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="materialTypeForm" onsubmit="event.preventDefault(); submitMaterialTypeForm();">
                @csrf
                @method('POST')
                <input type="hidden" name="id" id="material_type_id">
                <input type="hidden" name="is_active" id="is_active_hidden" value="0">
                <div class="modal-body">
                    <div id="form-errors" class="alert alert-danger d-none"></div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback">Please provide a name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="unit" name="unit" required>
                        <div class="invalid-feedback">Please provide a unit.</div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </form>

            @push('scripts')
            <!-- Load Bootstrap JS first -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                // Make sure Bootstrap is loaded
                if (typeof bootstrap === 'undefined') {
                    console.error('Bootstrap JS is not loaded!');
                }

                // Function to clear form
                function resetForm() {
                    document.getElementById('materialTypeForm').reset();
                    document.getElementById('material_type_id').value = '';
                    document.getElementById('form-errors').classList.add('d-none');
                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                }

                // Function to handle form submission
                async function submitMaterialTypeForm() {
                    const form = document.getElementById('materialTypeForm');
                    const submitBtn = document.getElementById('submitBtn');
                    const formData = new FormData(form);
                    const url = form.dataset.url || "{{ route('materialtypes.store') }}";
                    const method = form.dataset.method || 'POST';

                    // Handle checkbox state
                    const isActiveCheckbox = document.getElementById('is_active');
                    const isActiveHidden = document.getElementById('is_active_hidden');
                    isActiveHidden.value = isActiveCheckbox.checked ? '1' : '0';

                    // Convert FormData to JSON
                    const data = {};
                    formData.forEach((value, key) => {
                        data[key] = value;
                    });

                    // Reset previous errors
                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    document.getElementById('form-errors').classList.add('d-none');

                    try {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw data;
                        }

                        // Create and show success toast
                        const toastContainer = document.createElement('div');
                        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                        toastContainer.style.zIndex = '1100';
                        const toastId = 'success-toast-' + Date.now();

                        toastContainer.innerHTML = `
                            <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header bg-success text-white">
                                    <strong class="me-auto">Success</strong>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    ${data.message || 'Operation completed successfully'}
                                </div>
                            </div>
                        `;

                        document.body.appendChild(toastContainer);

                        // Initialize and show the toast
                        const toastEl = document.getElementById(toastId);
                        const toast = new bootstrap.Toast(toastEl);
                        toast.show();

                        // Clean up after toast is hidden
                        toastEl.addEventListener('hidden.bs.toast', function() {
                            toastEl.remove();
                            toastContainer.remove();
                        });

                        // Auto-hide after 3 seconds
                        setTimeout(() => {
                            toast.hide();
                        }, 3000);

                        // Reset form and close modal if using Bootstrap
                        if (typeof bootstrap !== 'undefined') {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('materialTypeModal'));
                            if (modal) modal.hide();
                        }

                        // Reload the page or update the table
                        window.location.reload();

                    } catch (error) {
                        console.error('Error:', error);

                        // Handle validation errors
                        if (error.errors) {
                            const errorContainer = document.getElementById('form-errors');
                            errorContainer.innerHTML = '';

                            for (const [field, messages] of Object.entries(error.errors)) {
                                const input = form.querySelector(`[name="${field}"]`);
                                if (input) {
                                    input.classList.add('is-invalid');
                                    const feedback = input.nextElementSibling;
                                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                                        feedback.textContent = messages[0];
                                    }
                                }

                                // Add error messages to error container
                                messages.forEach(message => {
                                    const errorElement = document.createElement('div');
                                    errorElement.textContent = message;
                                    errorContainer.appendChild(errorElement);
                                });
                            }

                            if (errorContainer.children.length > 0) {
                                errorContainer.classList.remove('d-none');
                            }
                        } else {
                            alert(error.message || 'An error occurred. Please try again.');
                        }
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Submit';
                    }
                }

                // Function to load material type data for editing
                async function editMaterialType(id) {
                    try {
                        const response = await fetch(`/material-types/${id}/edit`);
                        if (!response.ok) {
                            throw new Error('Failed to fetch material type data');
                        }
                        const data = await response.json();

                        // Reset form and remove any existing method spoofing
                        resetForm();

                        // Set form action and method for update
                        const form = document.getElementById('materialTypeForm');
                        form.action = `/material-types/${id}`;
                        form.method = 'POST';

                        // Remove any existing method spoofing input
                        const existingMethod = form.querySelector('input[name="_method"]');
                        if (existingMethod) {
                            existingMethod.remove();
                        }

                        // Add method spoofing for PUT request
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT';
                        form.appendChild(methodInput);

                        // Populate form fields
                        document.getElementById('material_type_id').value = data.id;
                        document.getElementById('name').value = data.name || '';
                        document.getElementById('description').value = data.description || '';
                        document.getElementById('unit').value = data.unit || '';
                        document.getElementById('is_active').checked = data.is_active == 1;

                        // Update modal title
                        document.getElementById('materialTypeModalLabel').textContent = 'Edit Material Type';

                        // Show the modal using jQuery (since we're already using it)
                        const $modal = $('#materialTypeModal');

                        // Initialize modal if not already initialized
                        if (typeof $modal.modal === 'function') {
                            $modal.modal('show');

                            // Focus on the first input field for better UX
                            setTimeout(() => {
                                $modal.find('input:not([type="hidden"]):first').focus();
                            }, 100);
                        } else {
                            console.error('Bootstrap modal not properly initialized');
                            alert('Error: Could not open the edit form. Please refresh the page and try again.');
                        }

                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error loading material type data: ' + error.message);
                    }
                }
                // Initialize when document is ready
                $(document).ready(function() {
                    // Handle edit button clicks using event delegation
                    $(document).on('click', '.edit-btn', function() {
                        const materialTypeId = $(this).data('id');
                        editMaterialType(materialTypeId);
                    });

                    // Handle add button click
                    $('#add-material-type').on('click', function() {
                        // Reset form
                        resetForm();

                        // Reset form action and method
                        const $form = $('#materialTypeForm');
                        $form.find('input[name="_method"]').remove();
                        $form.attr('action', "{{ route('materialtypes.store') }}")
                            .attr('method', 'POST');

                        // Update modal title
                        $('#materialTypeModalLabel').text('Add Material Type');

                        // Show the modal
                        const modal = new bootstrap.Modal(document.getElementById('materialTypeModal'));
                        modal.show();
                    });

                    // Handle modal hidden event
                    $('#materialTypeModal').on('hidden.bs.modal', function() {
                        resetForm();
                    });
                });
            </script>
            @endpush
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<!-- <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this material type?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div> -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        // Show add modal
        $('#add-material-type').click(function() {
            $('#materialTypeForm')[0].reset();
            $('#materialTypeModalLabel').text('Add Material Type');
            $('#material_type_id').val('');
            $('#materialTypeModal').modal('show');
        });

        // Edit material type
        $('.edit-btn').click(function() {
            var id = $(this).data('id');

            // Fetch material type data
            $.get('/materials/types/' + id, function(data) {
                $('#materialTypeModalLabel').text('Edit Material Type');
                $('#material_type_id').val(data.id);
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#unit').val(data.unit);
                $('#is_active').prop('checked', data.is_active);
                $('#materialTypeModal').modal('show');
            });
        });

        // Delete material type
        var deleteId;
        $('.delete-btn').click(function() {
            deleteId = $(this).data('id');
            $('#deleteModal').modal('show');
        });

        // Confirm delete
        $('#confirmDelete').click(function() {
            $.ajax({
                url: '/materials/types/' + deleteId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    showAlert('success', response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    showAlert('danger', xhr.responseJSON.message || 'An error occurred');
                }
            });
        });

        // Form submission
        $('#materialTypeForm').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const originalBtnText = $submitBtn.html();

            // Show loading state
            $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            const formData = $form.serialize();
            const id = $('#material_type_id').val();
            const url = id ? `/materials/types/${id}` : '{{ route("materialtypes.store") }}';
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    // Hide the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('materialTypeModal'));
                    if (modal) modal.hide();

                    // Show success message
                    showAlert('success', response.message || 'Operation completed successfully');

                    // Reload the page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    let errorMessage = 'An error occurred. Please try again.';

                    if (response && response.errors) {
                        // Handle validation errors
                        const errorContainer = document.getElementById('form-errors');
                        if (errorContainer) {
                            errorContainer.innerHTML = '';
                            for (const [field, messages] of Object.entries(response.errors)) {
                                messages.forEach(message => {
                                    const errorElement = document.createElement('div');
                                    errorElement.textContent = message;
                                    errorContainer.appendChild(errorElement);
                                });
                            }
                            errorContainer.classList.remove('d-none');
                        }
                        errorMessage = 'Please fix the errors in the form.';
                    } else if (response && response.message) {
                        errorMessage = response.message;
                    }

                    showAlert('danger', errorMessage);
                },
                complete: function() {
                    // Reset button state
                    $submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });
        });

        // Show alert function
        function showAlert(type, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;

            // Find or create alert container
            let $alertContainer = $('.alert-container');
            if ($alertContainer.length === 0) {
                $alertContainer = $('<div class="container mt-3 alert-container"></div>').prependTo('main');
            }

            // Add alert and auto-remove after 5 seconds
            $(alertHtml).appendTo($alertContainer).delay(5000).fadeOut(400, function() {
                $(this).alert('close');
            });
        }
    });
    
    // Show alert function
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
            
        // Find or create alert container
        let $alertContainer = $('.alert-container');
        if ($alertContainer.length === 0) {
            $alertContainer = $('<div class="container mt-3 alert-container"></div>').prependTo('main');
        }
        
        // Add alert and auto-remove after 5 seconds
        $(alertHtml).appendTo($alertContainer).delay(5000).fadeOut(400, function() {
            $(this).alert('close');
        });
    }
</script>
@endpush