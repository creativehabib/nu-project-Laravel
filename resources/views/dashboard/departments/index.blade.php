@extends('layouts.vertical', ['subtitle' => 'Departments'])
@section('content')
    @include('layouts.partials/page-title', ['title' => 'Nu Module', 'subtitle' => 'Departments'])
    <div class="card">
        <div class="card-header">
            <div class="flex-box justify-content-between">
                <h5 class="card-title">Departments</h5>
                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#departmentModal">Add New</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $department)
                            <tr>
                                <td>{{ $departments->firstItem()+$loop->index }}</td>
                                <td>{{ $department->name }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('departments.destroy', $department) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">No data found</td></tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $departments->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="departmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('departments.store') }}" class="modal-content">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Add Department</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
