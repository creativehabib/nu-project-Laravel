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
                <div class="mb-3">
                    <input type="text" id="department-search" class="form-control" placeholder="Search...">
                </div>
                <div class="table-responsive">
                    <table class="table table-centered" id="department-table">
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
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#departmentModal" data-url="{{ route('departments.update', $department) }}" data-name="{{ $department->name }}">Edit</button>
                                        <form method="POST" action="{{ route('departments.destroy', $department) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
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
    <script>
        $(function () {
            var createUrl = "{{ route('departments.store') }}";
            $('#departmentModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                var name = button.data('name');
                var modal = $(this);
                var form = modal.find('form');
                if (url) {
                    modal.find('.modal-title').text('Edit Department');
                    form.attr('action', url);
                    form.append('<input type="hidden" name="_method" value="PUT">');
                    form.find('input[name="name"]').val(name);
                } else {
                    modal.find('.modal-title').text('Add Department');
                    form.attr('action', createUrl);
                    form.find('input[name="_method"]').remove();
                    form.find('input[name="name"]').val('');
                }
            });

            $('#department-search').on('keyup', function () {
                var value = $(this).val().toLowerCase();
                $('#department-table tbody tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
@endsection
