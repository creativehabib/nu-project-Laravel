@extends('layouts.vertical', ['subtitle' => 'Nu Smart Card'])
@section('css')
@endsection
@section('content')

    @include('layouts.partials/page-title', ['title' => 'Nu Module', 'subtitle' => 'Nu Smart Card'])

    <div class="card">
        <div class="card-header">
            <div class="flex-box justify-content-between align-items-center">
                <h5 class="card-title">College Inspection Staff List</h5>
                <div class="d-flex align-items-center">
                    <input type="text" id="search" class="form-control form-control-sm me-2" placeholder="Search...">
                    <a class="btn btn-sm btn-success me-2" href="{{ route('export-word') }}">Word Export</a>
                    <a class="btn btn-sm btn-red me-2" target="_blank" href="{{ route('view-pdf') }}">PDF Download</a>
                    <a class="btn btn-sm btn-red me-2" target="_blank" href="{{ route('nu-smart-card.all-mastercard') }}">All Mastercard Download</a>
                    <a class="btn btn-sm btn-info" href="{{ route('nu-smart-card.create') }}">Add New</a>
                </div>
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
                        <th width="300" scope="col" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody id="nu-smart-card-table">
                        @include('nu-smart-card.partials.table-rows', ['data' => $data])
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
        $(document).ready(function(){
            $('#search').on('keyup', function(){
                let q = $(this).val();
                if(q.length === 0){
                    window.location.reload();
                    return;
                }
                $.get("{{ route('nu-smart-card.live-search') }}", { q: q }, function(data){
                    $('#nu-smart-card-table').html(data.html);
                    $('.pagination').hide();
                });
            });
        });

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
