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
                        <div class="row">
                            <div class="col-md-6">
                                <label for="image" class="form-label">Upload Image</label>
                                <input type="file" id="image" name="image" class="form-control">
                                <div class="mt-3">
                                    <img id="profilePreview" src="{{ asset('storage/' . $data->image) }}" class="img-thumbnail img-fluid w-50">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="signature" class="form-label">Upload Signature</label>
                                <input type="file" id="signature" name="signature" class="form-control">
                                <div class="mt-3">
                                    <img id="signaturePreview" src="{{ asset('storage/' . $data->signature) }}" class="img-thumbnail img-fluid w-50">
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
