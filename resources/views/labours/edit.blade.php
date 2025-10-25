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

                    <form action="{{ route('labours.update', $labour->id) }}" method="POST">
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
                            <input type="text" class="form-control" id="labour_category" 
                                   name="labour_category" value="{{ old('labour_category', $labour->labour_category) }}" required>
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

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('labours.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line"></i> Update Labour Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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