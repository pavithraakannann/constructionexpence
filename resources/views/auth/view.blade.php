@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('My Profile') }}</span>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> {{ __('Edit') }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5 class="text-muted">{{ __('Personal Information') }}</h5>
                        <hr>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">{{ __('Name') }}:</div>
                            <div class="col-md-8">{{ $user->name }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">{{ __('Email Address') }}:</div>
                            <div class="col-md-8">{{ $user->email }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">{{ __('Account Created') }}:</div>
                            <div class="col-md-8">{{ $user->created_at->format('F j, Y') }}</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="text-muted">{{ __('Account Actions') }}</h5>
                        <hr>
                        <div class="d-grid gap-2 d-md-flex">
                            <!-- <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="fas fa-user-edit me-1"></i> {{ __('Edit Profile') }}
                            </a>
                           <a href="{{ route('password.request') }}" class="btn btn-outline-secondary"> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection