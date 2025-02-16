@extends('layouts.vertical', ['subtitle' => 'Nu Smart Card'])

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
@endsection
@section('content')
    <div class="row row-cols-lg-1 gx-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nu Smart Data Edit</h5>
                </div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" id="ajax-form">
                        @csrf
                        <div class="row row-cols-lg-2 gx-4">
                            <div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" value="{{ $data->name }}" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" id="department" value="{{$data->department}}" name="department" class="form-control"
                                           placeholder="Department">
                                </div>

                                <div class="mb-3">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" id="designation" class="form-control" value="{{$data->designation}}">
                                </div>

                                <div class="mb-3">
                                    <label for="pf_number" class="form-label">PF No.</label>
                                    <input type="text" id="pf_number" class="form-control" value="{{$data->pf_number}}">
                                </div>

                                <div class="mb-3">
                                    <label for="present_address" class="form-label">Present Address</label>
                                    <textarea class="form-control" id="present_address" rows="5">{{$data->present_address}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" id="image" name="image" class="form-control">
                                    <img src="{{ asset('storage/' . $data->image)  }}" id="profilePreview" alt="{{ $data->name }}" class="w-25 img-thumbnail img-fluid">
                                </div>
                            </div>
                            <div>
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">Mobile Number</label>
                                    <input type="text" value="{{ $data->mobile_number }}" id="mobile_number" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="birth_date" class="form-label">Date of Birth</label>
                                    <input type="date" id="birth_date" name="birth_date" value="{{$data->birth_date}}" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="example-emergency_contact" class="form-label">Emergency Contact</label>
                                    <input type="text" id="example-emergency_contact" class="form-control" value="{{ $data->emergency_contact }}">
                                </div>

                                <div class="mb-3">
                                    <label for="example-textarea" class="form-label">Blood Group</label>
                                    <select class="form-select">
                                        <option value="">Select Blood Group</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                    </select>
                                </div>

                            <div class="mb-3">
                                <label for="signature" class="form-label">Upload Signature</label>
                                <input type="file" id="signature" name="signature" class="form-control">
                                <div class="mt-3">
                                    <img id="signaturePreview" src="{{ asset('storage/' . $data->signature) }}" class="img-thumbnail img-fluid w-50">
                                </div>
                            </div>
                        </div>
                        </div>
                        <button type="submit" id="nu_form_btn" class="btn btn-success mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Fullscreen Bootstrap Modal for Image Cropping -->
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                    <div class="w-auto h-auto d-flex justify-content-center align-items-center">
                        <img id="cropperPreview" class="object-fit-fill"/>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button id="cropImage" class="btn btn-success">Crop</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const profileInput = document.querySelector("#image");
            const signatureInput = document.querySelector("#signature");
            const profilePreview = document.getElementById("profilePreview");
            const signaturePreview = document.getElementById("signaturePreview");
            let cropper;
            let activeInput;
            let croppedBlob = null;

            function handleImageSelection(input, aspectRatio) {
                activeInput = input;
                const file = input.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById("cropperPreview").src = e.target.result;
                        let cropperModal = new bootstrap.Modal(document.getElementById("cropperModal"));
                        cropperModal.show();

                        if (cropper) cropper.destroy();
                        cropper = new Cropper(document.getElementById("cropperPreview"), {
                            aspectRatio: aspectRatio,
                            viewMode: 1,
                            autoCropArea: 1,
                        });
                    };
                    reader.readAsDataURL(file);
                }
            }

            profileInput.addEventListener("change", function () {
                handleImageSelection(this, 472 / 590);
            });

            signatureInput.addEventListener("change", function () {
                handleImageSelection(this, 300 / 80);
            });

            document.getElementById("cropImage").addEventListener("click", function () {
                if (cropper) {
                    let width = activeInput === profileInput ? 472 : 300;
                    let height = activeInput === profileInput ? 590 : 80;
                    const canvas = cropper.getCroppedCanvas({ width: width, height: height });

                    canvas.toBlob(blob => {
                        croppedBlob = blob;
                        const previewElement = activeInput === profileInput ? profilePreview : signaturePreview;
                        previewElement.src = URL.createObjectURL(blob);

                        // Replace input file with cropped image
                        const file = new File([blob], "cropped-image.png", { type: "image/png" });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        activeInput.files = dataTransfer.files;

                        document.getElementById("cropperModal").querySelector(".btn-close").click();
                    }, "image/png", 1);
                }
            });

            // ✅ AJAX Form Submission
            $("#ajax-form").on("submit", function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                if (croppedBlob) {
                    formData.set(activeInput.name, croppedBlob, "cropped-image.png");
                }

                $("#nu_form_btn").prop("disabled", true).text("Submitting...");

                $.ajax({
                    url: "{{ route('nu-smart-card.store') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (response) {
                        iziToast.success({
                            title: "Success",
                            message: "Data inserted successfully!",
                            position: "topRight"
                        });

                        setTimeout(() => {
                            window.location.href = "{{ route('view-data') }}";
                        }, 2000);
                    },
                    error: function (response) {
                        $("#ajax-form span").text("");
                        $.each(response.responseJSON.errors, function (key, value) {
                            $("#" + key + "-error").text(value[0]);
                        });
                        $("#nu_form_btn").prop("disabled", false).text("Submit");
                    }
                });
            });
        });
    </script>
@endsection
