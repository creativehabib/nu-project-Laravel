<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <!-- Cropper.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <style type="text/css">
        #cropperModal img {
            width: 90vw;           /* Expand image to larger viewport width */
            max-width: 90vw;
            max-height: 85vh;     /* Allow a taller crop area */
            display: block;
            margin: auto;
        }
    </style>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="max-w-2xl lg:max-w-3xl">

            <main class="p-4">
                <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                    <div class="flex flex-col col-span-1 p-6 bg-white dark:bg-gray-900 rounded-lg shadow-md">
                        <div class="mb-4">
                            <input type="text" id="live-search" placeholder="Search Smart Card" class="w-full p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                            <ul id="search-results" class="mt-2"></ul>
                        </div>
                        <form class="flex flex-col gap-4" id="ajax-form" enctype="multipart/form-data">
                            <div class="flex flex-col text-gray-700 dark:text-gray-200">
                                <label class="mb-2 text-sm font-medium">Name</label>
                                <input type="text" name="name" placeholder="Enter your name" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                <span class="text-red-500 text-sm mt-1" id="name-error"></span>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="flex flex-col text-gray-700 dark:text-gray-200">
                                    <label class="mb-2 text-sm font-medium">Department</label>
                                    <select name="department_id" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-red-500 text-sm mt-1" id="department_id-error"></span>
                                </div>
                                <div class="flex flex-col text-gray-700 dark:text-gray-200">
                                    <label class="mb-2 text-sm font-medium">Designation</label>
                                    <select name="designation_id" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                        <option value="">Select Designation</option>
                                        @foreach($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-red-500 text-sm mt-1" id="designation_id-error"></span>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div class="flex flex-col text-gray-700 dark:text-gray-200">
                                    <label class="mb-2 text-sm font-medium">PF No.</label>
                                    <input type="text" name="pf_number" placeholder="PF No." class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                    <span class="text-red-500 text-sm mt-1" id="pf_number-error"></span>
                                </div>
                                <div class="flex flex-col text-gray-700 dark:text-gray-200">
                                    <label class="mb-2 text-sm font-medium">ID Card Number</label>
                                    <input type="text" name="id_card_number" placeholder="ID Card Number" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                    <span class="text-red-500 text-sm mt-1" id="id_card_number-error"></span>
                                </div>
                                <div class="flex flex-col text-gray-700 dark:text-gray-200">
                                    <label class="mb-2 text-sm font-medium">Date of Birth</label>
                                    <input type="date" name="birth_date" placeholder="Select date" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                    <span class="text-red-500 text-sm mt-1" id="birth_date-error"></span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="flex flex-col text-gray-700 dark:text-gray-200">
                                    <label class="mb-2 text-sm font-medium">Mobile Number</label>
                                    <input type="text" name="mobile_number" placeholder="Enter mobile number" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                    <span class="text-red-500 text-sm mt-1" id="mobile_number-error"></span>
                                </div>
                                <div class="flex flex-col text-gray-700 dark:text-gray-200">
                                    <label class="mb-2 text-sm font-medium">Blood Group</label>
                                    <select name="blood_id" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                        <option value="">Select Blood Group</option>
                                        @foreach($bloods as $blood)
                                            <option value="{{ $blood->id }}">{{ $blood->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-red-500 text-sm mt-1" id="blood_id-error"></span>
                                </div>
                            </div>


                            <div class="flex flex-col text-gray-700 dark:text-gray-200">
                                <label class="mb-2 text-sm font-medium">Present Address</label>
                                <textarea name="present_address" placeholder="Enter your address" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white"></textarea>
                                <span class="text-red-500 text-sm mt-1" id="present_address-error"></span>
                            </div>
                            <div class="flex flex-col text-gray-700 dark:text-gray-200">
                                <label class="mb-2 text-sm font-medium">Emergency Contact</label>
                                <input type="text" name="emergency_contact" placeholder="Enter emergency contact" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                <span class="text-red-500 text-sm mt-1" id="emergency_contact-error"></span>
                            </div>
                            <div class="grid grid-cols-2 sm:flex-row justify-between text-gray-700 dark:text-gray-200 gap-2">
                                <div class="flex flex-col">
                                    <label class="mb-2 text-sm font-medium">Signature (300 x 80)</label>
                                    <input type="file" name="signature" placeholder="Upload signature" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                    <span class="text-red-500 text-sm mt-1" id="signature-error"></span>
                                    <img id="signaturePreview" class="mt-2 w-32 h-auto hidden"/>
                                </div>
                                <div class="flex flex-col">
                                    <label class="mb-2 text-sm font-medium">Image PP Size (45mm x 55mm)</label>
                                    <input type="file" name="image" placeholder="Upload passport size photo" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                                    <span class="text-red-500 text-sm mt-1" id="image-error"></span>
                                    <img id="profilePreview" class="mt-2 w-32 h-auto hidden" />
                                </div>
                            </div>
                            <button type="submit" id="nu_form_btn" class="mt-4 cursor-pointer p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Submit</button>
                        </form>
                    </div>
                </div>
            </main>

            <footer class="py-10 text-center text-sm text-black dark:text-white/70">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </footer>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const profileInput = document.querySelector("input[name='image']");
        const signatureInput = document.querySelector("input[name='signature']");
        const profilePreview = document.getElementById("profilePreview");
        const signaturePreview = document.getElementById("signaturePreview");

        let cropper, activeInput;
        let croppedProfileBlob = null;
        let croppedSignatureBlob = null;

        $('#live-search').on('keyup', function () {
            const q = $(this).val();
            if (q.length < 2) {
                $('#search-results').empty();
                return;
            }

            $.get('/nu-smart-card/search', { q: q }, function (data) {
                const html = data.length
                    ? data.map(item => `<li>${item.name} - ${item.pf_number || ''} - ${item.id_card_number || ''}</li>`).join('')
                    : '<li class="text-gray-500">No results found</li>';
                $('#search-results').html(html);
            });
        });

        // ✅ Cropper Modal Setup
        const cropperModal = document.createElement("div");
        cropperModal.id = "cropperModal";
        cropperModal.className = "fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden";
        cropperModal.innerHTML = `
            <div class="bg-white p-6 rounded-lg shadow-md w-full" style="max-width:90vw;">
                <img id="cropperPreview" class="w-full h-auto" />
                <div class="flex justify-end mt-4">
                    <button id="cropImage" class="bg-green-500 text-white p-2 rounded-md mr-2">Crop</button>
                    <button id="cancelCrop" class="bg-red-500 text-white p-2 rounded-md">Cancel</button>
                </div>
            </div>
        `;
        document.body.appendChild(cropperModal);

        function handleImageSelection(input, aspectRatio, minWidth, minHeight) {
            activeInput = input;
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("cropperPreview").src = e.target.result;
                    cropperModal.classList.remove("hidden");
                    cropperModal.style.display = "flex";

                    if (cropper) cropper.destroy();
                    cropper = new Cropper(document.getElementById("cropperPreview"), {
                        aspectRatio: aspectRatio,
                        viewMode: 1,
                        autoCropArea: 1,
                        minCropBoxWidth: minWidth,
                        minCropBoxHeight: minHeight,
                    });
                };
                reader.readAsDataURL(file);
            }
        }

        profileInput.addEventListener("change", function () {
            handleImageSelection(this, 45 / 55, 531, 649);
        });

        signatureInput.addEventListener("change", function () {
            handleImageSelection(this, 300 / 80, 300, 80);
        });

        document.getElementById("cancelCrop").addEventListener("click", function () {
            cropperModal.classList.add("hidden");
            cropperModal.style.display = "none";
            activeInput.value = ""; // Reset input field
        });

        document.getElementById("cropImage").addEventListener("click", function () {
            if (cropper) {
                const width = activeInput === profileInput ? 531 : 300;
                const height = activeInput === profileInput ? 649 : 80;
                const canvas = cropper.getCroppedCanvas({
                    width: width,
                    height: height,
                    fillColor: "transparent", // Ensure PNG transparency
                });

                canvas.toBlob(blob => {
                    if (activeInput === profileInput) {
                        croppedProfileBlob = blob;
                        profilePreview.src = URL.createObjectURL(blob);
                        profilePreview.classList.remove("hidden"); // Show preview
                    } else if (activeInput === signatureInput) {
                        croppedSignatureBlob = blob;
                        signaturePreview.src = URL.createObjectURL(blob);
                        signaturePreview.classList.remove("hidden"); // Show preview
                    }

                    // ✅ Replace the input file with the cropped one
                    const file = new File([blob], "cropped-image.png", { type: "image/png" });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    activeInput.files = dataTransfer.files;

                    cropperModal.classList.add("hidden");
                    cropperModal.style.display = "none";
                }, "image/png", 1);
            }
        });

        // ✅ Submit Form using jQuery
        $("#ajax-form").on("submit", function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            // Ensure the cropped image is added to the FormData
            if (croppedProfileBlob) {
                formData.set("image", croppedProfileBlob, "cropped-profile.png");
            }
            if (croppedSignatureBlob) {
                formData.set("signature", croppedSignatureBlob, "cropped-signature.png");
            }

            $("#nu_form_btn").prop("disabled", true).text("Submitting...");

            $.ajax({
                url: "{{ route('nu-smart-card.store_data') }}",
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



</body>
</html>
