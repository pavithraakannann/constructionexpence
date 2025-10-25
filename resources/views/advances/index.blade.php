@extends('layouts.app')

@section('content')
<div class="e-commerce-dashboard">
    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="card-title mb-0">Advance Management</h5>
                        <a href="{{ route('advances.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Add Advance Record
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success m-3">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger m-3">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table align-middle table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Project</th>
                                <th>Amount (₹)</th>
                                <th>Received From</th>
                                <th>Received By</th>
                                <th>Payment Mode</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($advances as $advance)
                                <tr>
                                    <td>{{ $advance->date->format('d-M-Y') }}</td>
                                    <td>{{ $advance->project->name ?? 'N/A' }}</td>
                                    <td class="text-end">{{ number_format($advance->amount_received, 2) }}</td>
                                    <td>{{ $advance->received_from ?? 'N/A' }}</td>
                                    <td>{{ $advance->received_by ?? 'N/A' }}</td>
                                    <td>{{ $advance->payment_mode }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('advances.edit', $advance->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="Edit">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            <form action="{{ route('advances.destroy', $advance->id) }}" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                            <!-- @if($advance->attachment)
                                            <a href="{{ Storage::url($advance->attachment) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-info" 
                                               title="View Attachment">
                                                <i class="fas fa-paperclip"></i>
                                            </a>
                                            @endif -->
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No advance records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($advances->hasPages())
                    <div class="card-footer">
                        {{ $advances->links() }}
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