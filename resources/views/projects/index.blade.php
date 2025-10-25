@extends('layouts.app')
@section('content')


<div class="e-commerce-dashboard">
    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0" id="contacts">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-sm-between gap-3 flex-wrap">
                        <h5 class="card-title mb-0">Projects List</h5>
                        <input type="text" class="form-control max-w-300px" placeholder="Search contact" id="search-input">
                        <a href="{{ route('projects.create') }}" class="btn btn-primary" id="add-btn">Create</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="sort">Project ID</th>
                                <th class="sort" data-sort="name">Project Name</th>
                                <th class="sort" data-sort="start-date">Start Date</th>
                                <th class="sort" data-sort="end-date">End Date</th>
                                <th class="sort" data-sort="status">Status</th>
                                <th colspan="2" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($projects as $project)
                            <tr>
                                <td class="id">{{ $project->project_id }}</td>
                                <td class="name">{{ $project->name }}</td>
                                <td class="start-date">{{ $project->start_date ? $project->start_date->format('Y-m-d') : 'N/A' }}</td>
                                <td class="end-date">{{ $project->end_date ? $project->end_date->format('Y-m-d') : 'N/A' }}</td>
                                <td class="status">{{ ucfirst($project->status) }}</td>
                                <td class="w-200px">
                                    <div class="hstack justify-content-center">

                                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary btn-sm"><i class="ri-eye-line"></i></a>
                                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary btn-sm mx-2"><i class="ri-edit-2-line"></i></a>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this project?')"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="ri-information-line me-1"></i> No projects found.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($projects->hasPages())
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-end">
                                    {{ $projects->links() }}
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection