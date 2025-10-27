@extends('layouts.app')

@section('content')
<div class="e-commerce-dashboard">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Labour Type</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('labourtypes.update', $labourtype->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $labourtype->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                     id="description" name="description" rows="3">{{ old('description', $labourtype->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="standard_rate" class="form-label">Standard Rate (₹) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('standard_rate') is-invalid @enderror" 
                                           id="standard_rate" name="standard_rate" value="{{ old('standard_rate', $labourtype->standard_rate) }}" required>
                                    @error('standard_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                                    <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                        <option value="hour" {{ old('unit', $labourtype->unit) == 'hour' ? 'selected' : '' }}>Hour</option>
                                        <option value="day" {{ old('unit', $labourtype->unit) == 'day' ? 'selected' : '' }}>Day</option>
                                        <option value="week" {{ old('unit', $labourtype->unit) == 'week' ? 'selected' : '' }}>Week</option>
                                        <option value="month" {{ old('unit', $labourtype->unit) == 'month' ? 'selected' : '' }}>Month</option>
                                    </select>
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                       id="is_active" name="is_active" value="1" {{ old('is_active', $labourtype->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('labourtypes.index') }}" class="btn btn-light">
                                <i class="ri-arrow-left-line align-middle me-1"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line align-middle me-1"></i> Update Labour Type
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
