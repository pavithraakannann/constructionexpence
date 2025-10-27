@extends('layouts.app')

@section('content')
<div class="e-commerce-dashboard">
    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="card-title mb-0">Labour Management</h5>
                        <a href="{{ route('labours.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Add Labour Record
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success m-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table align-middle table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Project</th>
                                <th>Category</th>
                                <th>Labour Name</th>
                                <th>Workers</th>
                                <th>Wage/Worker</th>
                                <th>Total</th>
                                <th>Payment Mode</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($labours as $labour)
                                <tr>
                                    <td>{{ $labour->date->format('d-M-Y') }}</td>
                                    <td>{{ $labour->project->name ?? 'N/A' }}</td>
                                    <td>{{ $labour->labour_category }}</td>
                                    <td>{{ $labour->labour_name ?? 'N/A' }}</td>
                                    <td class="text-end">{{ $labour->num_workers }}</td>
                                    <td class="text-end">{{ number_format($labour->wage_per_worker, 2) }}</td>
                                    <td class="text-end">{{ number_format($labour->total_wage, 2) }}</td>
                                    <td>{{ $labour->payment_mode }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                               <a href="{{ route('labours.view', $labour->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('labours.edit', $labour->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="Edit">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            <form action="{{ route('labours.destroy', $labour->id) }}" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No labour records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($labours->hasPages())
                    <div class="card-footer">
                        {{ $labours->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .text-end {
        text-align: right;
    }
</style>
@endpush

@endsection