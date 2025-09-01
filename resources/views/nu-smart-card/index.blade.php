@extends('layouts.vertical', ['subtitle' => 'Nu Smart Card'])
@section('content')

    @include('layouts.partials/page-title', ['title' => 'Nu Module', 'subtitle' => 'Nu Smart Card'])

    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 align-items-md-center">
                <h5 class="card-title mb-0">College Inspection Staff List</h5>
                <div class="d-flex flex-column flex-sm-row align-items-stretch gap-2 w-md-auto">
                    <input type="text" id="search" class="form-control form-control-sm flex-grow-1" placeholder="Search...">
                    <div class="d-flex align-items-center gap-1"  aria-label="Actions">
                        <a class="d-flex align-items-center gap-1 btn btn-success" href="{{ route('export-word') }}"><i class="bx bxs-file-doc"></i> Word</a>
                        <a class="d-flex align-items-center gap-1 btn btn-red" target="_blank" href="{{ route('view-pdf') }}"><i class="bx bxs-file-pdf"></i> PDF</a>
                        <a class="d-flex align-items-center gap-1 btn btn-red" target="_blank" href="{{ route('nu-smart-card.all-mastercard') }}"><i class="bx bx-download"></i> All</a>
                        <a class="d-flex align-items-center gap-1 btn btn-info" href="{{ route('nu-smart-card.create') }}"><i class="bx bx-plus"></i> Add</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-striped table-hover align-middle">
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
@push('scripts')
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
@endpush
