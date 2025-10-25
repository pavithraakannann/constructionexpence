@extends('layouts.app')

@section('content')

<div class="e-commerce-dashboard">
    <div class="row g-4">
        <div class="col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="avatar-lg avatar-item border-0 flex-shrink-0"><i class="ri-stack-line fs-20 lh-1"></i></span>
                        <div class="hstack justify-content-between gap-2 flex-grow-1">
                            <div class="flex-grow-1">
                                <h5 class="fw-semibold mb-0 lh-base text-truncate-2">{{ $project->name }}</h5>
                                <span class="badge bg-{{ $project->status == 'completed' ? 'success' : ($project->status == 'in_progress' ? 'primary' : 'secondary') }}">
                                    {{ ucfirst(str_replace('_', ' ', $project->status ?? 'not set')) }}
                                </span>
                                <div class="text-muted fs-12 d-inline-block">
                                    <span class="bullet bg-{{ $remainingBudget < 0 ? 'danger' : 'success' }} mx-2"></span>
                                    {{ $remainingBudget < 0 ? 'Over Budget' : 'On Budget' }}
                                </div>
                            </div>
                            <div class="dropdown flex-shrink-0">
                                <a aria-label="anchor" href="#!" class="btn btn-light-primary rounded-pill icon-btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-line"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('projects.edit', $project->id) }}">
                                            <i class="ri-edit-line align-middle me-1 d-inline-block"></i>Edit Project
                                        </a>
                                    </li>
                                    <li>
                                        <form id="delete-project" action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this project?')) { document.getElementById('delete-project').submit(); }">
                                            <i class="ri-delete-bin-line me-1 align-middle d-inline-block"></i>Delete Project
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Project Overview</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="avatar avatar-lg bg-light p-2 rounded">
                                        <i class="ri-map-pin-line fs-4"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted">Location</p>
                                        <p class="mb-0 fw-medium">{{ $project->location ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="avatar avatar-lg bg-light p-2 rounded">
                                        <i class="ri-calendar-line fs-4"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted">Duration</p>
                                        <p class="mb-0 fw-medium">
                                            {{ $project->start_date->format('M d, Y') }} -
                                            {{ $project->end_date ? $project->end_date->format('M d, Y') : 'Ongoing' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="avatar avatar-lg bg-light p-2 rounded">
                                        <i class="ri-money-dollar-circle-line fs-4"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted">Budget</p>
                                        <p class="mb-0 fw-medium">₹{{ number_format($project->budget, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="avatar avatar-lg bg-light p-2 rounded">
                                        <i class="ri-money-cny-circle-line fs-4"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted">Expenses</p>
                                        <p class="mb-0 fw-medium">₹{{ number_format($totalExpenses, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6>Budget Utilization</h6>
                        <div class="progress mb-2" style="height: 10px;">
                            <div class="progress-bar bg-{{ $budgetUtilization > 100 ? 'danger' : 'success' }}"
                                role="progressbar"
                                style="width: {{ min($budgetUtilization ?? 0, 100) }}%"
                                aria-valuenow="{{ $budgetUtilization ?? 0 }}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">0%</span>
                            <span class="text-muted">{{ number_format($budgetUtilization, 1) }}% Utilized</span>
                            <span class="text-muted">100%</span>
                        </div>
                    </div>

                    <div class="nav-tabs-style-1">
                        <ul class="nav nav-tabs mb-4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#labours" type="button" role="tab" aria-selected="true">
                                    <i class="ri-team-line me-1"></i> Labours
                                    <span class="badge bg-primary rounded-pill ms-1">{{ $project->labours->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#materials" type="button" role="tab" aria-selected="false">
                                    <i class="ri-box-3-line me-1"></i> Materials
                                    <span class="badge bg-success rounded-pill ms-1">{{ $project->materials->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#advances" type="button" role="tab" aria-selected="false">
                                    <i class="ri-hand-coin-line me-1"></i> Advances
                                    <span class="badge bg-info rounded-pill ms-1">{{ $project->advances->count() }}</span>
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Labours Tab -->
                            <div class="tab-pane fade show active" id="labours" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Category</th>
                                                <th>Labour Name</th>
                                                <th class="text-end">Workers</th>
                                                <th class="text-end">Wage/Worker</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($project->labours as $labour)
                                            <tr>
                                                <td>{{ $labour->date->format('d M Y') }}</td>
                                                <td>{{ $labour->labour_category }}</td>
                                                <td>{{ $labour->labour_name }}</td>
                                                <td class="text-end">{{ $labour->num_workers }}</td>
                                                <td class="text-end">₹{{ number_format($labour->wage_per_worker, 2) }}</td>
                                                <td class="text-end fw-medium">₹{{ number_format($labour->total_wage, 2) }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">No labour records found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th colspan="5" class="text-end">Total Labour Cost:</th>
                                                <th class="text-end">₹{{ number_format($labourTotal, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="text-end mt-3">
                                    <a href="{{ route('labours.create', ['project_id' => $project->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="ri-add-line me-1"></i> Add Labour
                                    </a>
                                </div>
                            </div>

                            <!-- Materials Tab -->
                            <div class="tab-pane fade" id="materials" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Material</th>
                                                <th>Vendor</th>
                                                <th class="text-end">Qty</th>
                                                <th class="text-end">Unit Price</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($project->materials as $material)
                                            <tr>
                                                <td>{{ $material->purchase_date->format('d M Y') }}</td>
                                                <td>
                                                    {{ $material->material_name }}
                                                    @if($material->materialType)
                                                    <span class="badge bg-light text-muted ms-1">{{ $material->materialType->name }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $material->vendor_name ?? 'N/A' }}</td>
                                                <td class="text-end">{{ $material->quantity }} {{ $material->unit }}</td>
                                                <td class="text-end">₹{{ number_format($material->unit_price, 2) }}</td>
                                                <td class="text-end fw-medium">₹{{ number_format($material->total_cost, 2) }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">No material records found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th colspan="5" class="text-end">Total Material Cost:</th>
                                                <th class="text-end">₹{{ number_format($materialTotal, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="text-end mt-3">
                                    <a href="{{ route('materials.create', ['project_id' => $project->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="ri-add-line me-1"></i> Add Material
                                    </a>
                                </div>
                            </div>

                            <!-- Advances Tab -->
                            <div class="tab-pane fade" id="advances" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Received From</th>
                                                <th>Received By</th>
                                                <th>Payment Mode</th>
                                                <th class="text-end">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($project->advances as $advance)
                                            <tr>
                                                <td>{{ $advance->date->format('d M Y') }}</td>
                                                <td>{{ $advance->received_from }}</td>
                                                <td>{{ $advance->received_by }}</td>
                                                <td>{{ $advance->payment_mode }}</td>
                                                <td class="text-end fw-medium">₹{{ number_format($advance->amount_received, 2) }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">No advance records found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th colspan="4" class="text-end">Total Advances Received:</th>
                                                <th class="text-end">₹{{ number_format($advanceTotal, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="text-end mt-3">
                                    <a href="{{ route('advances.create', ['project_id' => $project->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="ri-add-line me-1"></i> Record Advance
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-xl-3">
            <!-- Summary Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Financial Summary</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Budget</span>
                        <span class="fw-medium">₹{{ number_format($project->budget, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Expenses</span>
                        <span class="fw-medium text-danger">- ₹{{ number_format($totalExpenses, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Advances Received</span>
                        <span class="fw-medium text-success">+ ₹{{ number_format($advanceTotal, 2) }}</span>
                    </div>
                    <div class="border-top my-3"></div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="fw-semibold">Remaining Budget</span>
                        <span class="fw-bold {{ $remainingBudget < 0 ? 'text-danger' : 'text-success' }}">
                            ₹{{ number_format(abs($remainingBudget), 2) }}
                            @if($remainingBudget < 0)
                                (Over Budget)
                                @endif
                                </span>
                    </div>
                </div>
            </div>

            <!-- Project Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Project Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="mb-1 text-muted">Project ID</p>
                        <p class="mb-0 fw-medium">{{ $project->project_id ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1 text-muted">Status</p>
                        <span class="badge bg-{{ $project->status == 'completed' ? 'success' : ($project->status == 'in_progress' ? 'primary' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $project->status ?? 'not set')) }}
                        </span>
                    </div>
                    @if($project->contact_name || $project->contact_mobile)
                    <div class="mb-3">
                        <p class="mb-1 text-muted">Contact Person</p>
                        <p class="mb-0 fw-medium">
                            {{ $project->contact_name ?? 'N/A' }}
                            @if($project->contact_mobile)
                            <br>
                            <a href="tel:{{ $project->contact_mobile }}" class="text-primary">{{ $project->contact_mobile }}</a>
                            @endif
                        </p>
                    </div>
                    @endif
                    @if($project->reference_name)
                    <div class="mb-3">
                        <p class="mb-1 text-muted">Reference</p>
                        <p class="mb-0 fw-medium">{{ $project->reference_name }}</p>
                    </div>
                    @endif
                    @if($project->description)
                    <div class="mb-0">
                        <p class="mb-1 text-muted">Description</p>
                        <p class="mb-0">{{ $project->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('labours.create', ['project_id' => $project->id]) }}" class="btn btn-outline-primary btn-sm mb-2">
                            <i class="ri-team-line me-1"></i> Add Labour
                        </a>
                        <a href="{{ route('materials.create', ['project_id' => $project->id]) }}" class="btn btn-outline-primary btn-sm mb-2">
                            <i class="ri-box-3-line me-1"></i> Add Material
                        </a>
                        <a href="{{ route('advances.create', ['project_id' => $project->id]) }}" class="btn btn-outline-primary btn-sm">
                            <i class="ri-hand-coin-line me-1"></i> Record Advance
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush