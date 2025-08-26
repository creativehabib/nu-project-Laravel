@extends('layouts.vertical', ['subtitle' => 'Designations'])
@section('content')
    @include('layouts.partials/page-title', ['title' => 'Nu Module', 'subtitle' => 'Designations'])
    <div class="card">
        <div class="card-header">
            <div class="flex-box justify-content-between">
                <h5 class="card-title">Designations</h5>
                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#designationModal">Add New</button>
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
                        @forelse($designations as $designation)
                            <tr>
                                <td>{{ $designations->firstItem()+$loop->index }}</td>
                                <td>{{ $designation->name }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('designations.destroy', $designation) }}">
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
                {{ $designations->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="designationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('designations.store') }}" class="modal-content">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Add Designation</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
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
