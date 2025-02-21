@extends('layouts.vertical', ['subtitle' => 'Nu Smart Card'])
@section('css')
@endsection
@section('content')

    @include('layouts.partials/page-title', ['title' => 'Nu Module', 'subtitle' => 'Nu Smart Card'])

    <div class="card">
        <div class="card-header">
            <div class="flex-box justify-content-between">
                <h5 class="card-title">College Inspection Staff List</h5>
                <a class="btn btn-sm btn-info" href="{{ route('nu-smart-card.create') }}">Add New</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Created At</th>
                        <th width="200" class="text-center" scope="col">Image</th>
                        <th width="250" scope="col" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $nu)
                            <tr>
                                <th scope="row">{{ $data->firstItem()+$loop->index }}</th>
                                <td>{{ $nu->name }}</td>
                                <td>{{ $nu->designation }}</td>
                                <td>{{ $nu->created_at->toDateString() }}</td>
                                <td><img class="img-thumbnail img-fluid rounded mx-auto d-block w-25" alt="image" src="{!! asset('uploads/images/' . $nu->image)  !!}"> </td>
                                <td class="text-center">
                                    <a href="{{ route('nu-smart-card.show', $nu->id) }}" class="btn btn-primary btn-sm"><i class="bx bx-show fs-4"></i></a>
                                    <a href="{{ route('nu-smart-card.edit', $nu->id) }}" class="btn btn-sm btn-green"><i class="bx bx-edit fs-4"></i></a>
                                    <button data-url="{{ route('nu-smart-card.destroy', $nu->id) }}" class="btn btn-danger delete-btn btn-sm"><i class="bx bx-trash fs-4"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Data Found</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script type="text/javascript">
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
    </script>
@endsection
