@extends('layouts.app')

@section('content')
<div class="e-commerce-dashboard">
    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="card-title mb-0">Labour Types</h5>
                        <a href="{{ route('labourtypes.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-middle me-1"></i> Add New Labour Type
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Standard Rate</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($labourTypes as $labourType)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $labourType->name }}</td>
                                    <td>{{ Str::limit($labourType->description, 30) }}</td>
                                    <td>₹{{ number_format($labourType->standard_rate, 2) }}</td>
                                    <td>{{ $labourType->unit }}</td>
                                    <td>
                                        <span class="badge bg-{{ $labourType->is_active ? 'success' : 'danger' }}">
                                            {{ $labourType->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('labourtypes.edit', $labourType->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="Edit">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            <form action="{{ route('labourtypes.destroy', $labourType->id) }}" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this labour type?')">
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
                                    <td colspan="7" class="text-center">No labour types found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($labourTypes->hasPages())
                    <div class="mt-3">
                        {{ $labourTypes->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
