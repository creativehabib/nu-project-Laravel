@extends('layouts.vertical', ['subtitle' => 'Blood Group'])
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
@endsection
@section('content')

    @include('layouts.partials/page-title', ['title' => 'Nu Module', 'subtitle' => 'Blood Group'])

    <div class="card">
        <div class="card-header">
            <div class="flex-box justify-content-between">
                <h5 class="card-title">Blood Group List</h5>
                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#bloodModal">Add New</button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Blood Name</th>
                        <th scope="col">Created Ad</th>
                        <th scope="col">Updated At</th>
                        <th width="200" class="text-center" scope="col">Status</th>
                        <th width="250" scope="col" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($bloods as $blood)
                        <tr>
                            <th scope="row">{{ $bloods->firstItem()+$loop->index }}</th>
                            <td>{{ $blood->name }}</td>
                            <td>{{ $blood->created_at->toDateString() }}</td>
                            <td>{{ $blood->updated_at->toDateString() }}</td>
                            <td class="text-center"><input class="form-check-input bloodStatus" type="checkbox" role="switch" data-id="{{ $blood->id }}" {{ $blood->status ? 'checked' : '' }}></td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-green editBlood" data-bs-toggle="modal" data-bs-target="#bloodModal" data-id="{{ $blood->id }}"><i class="bx bx-edit fs-4"></i></button>
                                <button class="btn btn-danger btn-sm delete-btn" data-url="{{ route('blood-group.destroy', $blood->id) }}"><i class="bx bx-trash fs-4"></i></button>
                            </td>
                        </tr>
                    @empty
                        <td colspan="6" class="text-center">No data found!</td>
                    @endforelse

                    </tbody>
                </table>
                {{ $bloods->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="bloodModal" tabindex="-1" aria-labelledby="bloodModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="bloodForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bloodModalLabel">Add Blood</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="bloodId">

                        <div class="mb-3">
                            <label for="name" class="form-label">Blood Name:</label>
                            <input type="text" id="name" name="name" placeholder="Enter blood name" class="form-control">
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input bloodStatus" type="checkbox" role="switch" id="bloodStatus" checked="">
                            <label class="form-check-label" for="bloodStatus">Status</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveBlood">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // ✅ Open Modal for Creating New Entry
        $(document).on('click', '[data-bs-target="#bloodModal"]', function () {
            $('#bloodModalLabel').text('Add Blood');
            $('#saveBlood').text('Save');
            $('#bloodId').val('');
            $('#name').val('');
            $('#bloodStatus').prop('checked', true);
            $('.error-message').remove(); // Clear previous error messages
            $('#bloodModal').modal('show');
        });

        // ✅ Open Modal for Editing Existing Entry
        $(document).on('click', '.editBlood', function () {
            let id = $(this).data('id');
            $.ajax({
                url: '/dashboard/blood-group/' + id + '/edit',
                type: 'GET',
                success: function (response) {
                    $('#bloodModalLabel').text('Edit Blood');
                    $('#saveBlood').text('Update');
                    $('#bloodId').val(response.id);
                    $('#name').val(response.name);
                    $('#bloodStatus').prop('checked', response.status == 1);
                    $('.error-message').remove(); // Clear previous errors
                    $('#bloodModal').modal('show');
                },
                error: function () {
                    iziToast.error({
                        title: 'Error',
                        message: 'Failed to load data!',
                        position: 'topRight'
                    });
                }
            });
        });

        // ✅ Handle Create/Update with Validation
        $('#saveBlood').click(function () {
            let id = $('#bloodId').val();
            let name = $('#name').val();
            let status = $('#bloodStatus').is(':checked') ? 1 : 0;
            let url = id ? '/dashboard/blood-group/' + id : '/dashboard/blood-group';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: 'POST',  // Always use POST, and send _method for PUT
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: method, // Laravel recognizes _method for PUT
                    name: name,
                    status: status
                },
                success: function (response) {
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight'
                    });
                    $('#bloodModal').modal('hide');
                    setTimeout(() => location.reload(), 1000); // Reload page after 1 second
                },
                error: function (xhr) {
                    $('.error-message').remove(); // Remove previous errors
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('#' + key).after('<span class="text-danger error-message">' + value[0] + '</span>');
                        });
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight'
                        });
                    }
                }
            });
        });

        // ✅ Handle DELETE Request
        $(document).on("click", ".delete-btn", function (e) {
            e.preventDefault();

            let deleteUrl = $(this).data("url");
            let row = $(this).closest("tr"); // Adjust this for non-table elements

            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function (response) {
                            iziToast.success({
                                title: "Success",
                                message: "Record deleted successfully!",
                                position: "topRight"
                            });

                            // Fade out the deleted row smoothly
                            row.fadeOut(500, function () {
                                $(this).remove();
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText); // Log error to console
                            iziToast.error({
                                title: "Error",
                                message: "Something went wrong!",
                                position: "topRight"
                            });
                        }
                    });
                }
            });
        });

        $(document).on('change', '.bloodStatus', function () {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '/dashboard/blood-group/' + id + '/update-status',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: status
                },
                success: function (response) {
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight'
                    });
                },
                error: function () {
                    iziToast.error({
                        title: 'Error',
                        message: 'Failed to update status!',
                        position: 'topRight'
                    });
                }
            });
        });

    });


</script>
@endsection
