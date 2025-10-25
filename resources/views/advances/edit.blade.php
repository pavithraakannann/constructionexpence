@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Advance Record</h5>
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

                    <form action="{{ route('advances.update', $advance->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" 
                                   value="{{ old('date', $advance->date ? $advance->date->format('Y-m-d') : '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="project_id" class="form-label">Project</label>
                            <select class="form-select" id="project_id" name="project_id" required>
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ $advance->project_id == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount_received" class="form-label">Amount Received</label>
                            <input type="number" step="0.01" class="form-control" id="amount_received" 
                                   name="amount_received" value="{{ old('amount_received', $advance->amount_received) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="received_from" class="form-label">Received From</label>
                            <input type="text" class="form-control" id="received_from" 
                                   name="received_from" value="{{ old('received_from', $advance->received_from) }}">
                        </div>

                        <div class="mb-3">
                            <label for="received_by" class="form-label">Received By</label>
                            <input type="text" class="form-control" id="received_by" 
                                   name="received_by" value="{{ old('received_by', $advance->received_by) }}">
                        </div>

                        <div class="mb-3">
                            <label for="payment_mode" class="form-label">Payment Mode</label>
                            <select class="form-select" id="payment_mode" name="payment_mode" required>
                                <option value="Cash" {{ $advance->payment_mode == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Bank" {{ $advance->payment_mode == 'Bank' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="Cheque" {{ $advance->payment_mode == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="UPI" {{ $advance->payment_mode == 'UPI' ? 'selected' : '' }}>UPI</option>
                                <option value="Other" {{ $advance->payment_mode == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="2">{{ old('remarks', $advance->remarks) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="attachment" class="form-label">Attachment</label>
                            @if($advance->attachment)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($advance->attachment) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View Current Attachment
                                    </a>
                                    <!-- <a href="{{ route('advances.attachment.download', $advance->id) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-download"></i> Download
                                    </a> -->
                                </div>
                            @endif
                            <input type="file" class="form-control" id="attachment" name="attachment">
                            <div class="form-text">Leave empty to keep existing attachment. Max 2MB. Allowed types: jpg, jpeg, png, pdf, doc, docx</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('advances.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Advance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection