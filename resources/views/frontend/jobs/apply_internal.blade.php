@extends('layouts.base', ['subtitle' => 'Home'])

@section('body-attribute')
    class="authentication-bg"
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('content')
@php
    $months = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];
@endphp
    <div class="w-75 mx-auto bg-white">
        <div class="row">
            <div class="col-md-12">
                <div class="header">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/logo_nu_banner.png')}}" alt="Logo" class="img-fluid" />
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container">
                          <a class="navbar-brand" href="#">Home</a>
                          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                          </button>
                          <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                              <li class="nav-item">
                                <a class="nav-link" href="#">User Login</a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </nav>
                </div>
                <div class="content p-2 mt-3">
                    <h3 class="text-center bg-info text-white p-1">Promotion/Upgradation Application Form:</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="jobs-form px-3 py-1">
                            
                            {{-- @include('frontend.jobs.form') --}}
                            <div class="mb-2">
                                <label for="post_name" class="form-label text-black">Name of the Post*:</label>
                                <select class="form-select editmode text-black" id="post_name" name="post_name" autofocus required>
                                    <option value="" disabled selected>Select Post</option>
                                    <option value="Post 1">Post 1</option>
                                    <option value="Post 2">Post 2</option>
                                    <option value="Post 3">Post 3</option>
                                    <option value="Post 4">Post 4</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="pf_no" class="form-label text-black">PF No*:</label>
                                <input type="text" class="form-control editmode text-black" placeholder="PF No" id="pf_no" name="pf_no" required>
                            </div>
                            <div class="mb-2">
                                <label for="present_designation" class="form-label text-black">Present Designation:*(বর্তমান পদ):</label>
                                <input type="text" class="form-control editmode text-black" placeholder="Present Designation" id="present_designation" name="present_designation" required>
                            </div>
                            <div class="mb-2">
                                <label for="department" class="form-label text-black">Department:*(দপ্তর):</label>
                                <input type="text" class="form-control editmode text-black" placeholder="Department" id="department" name="department" required>
                            </div>
                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="applicant_name" class="form-label text-black">Applicant's Name (English)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Applicant name" id="applicant_name" name="applicant_name" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="applicant_name_bn" class="form-label text-black">Applicant's Name (Bangla)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Applicant name bangla" id="applicant_name_bn" name="applicant_name_bn" required>
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="father_name" class="form-label text-black">Father's Name(English)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Father name" id="father_name" name="father_name" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="father_name_bn" class="form-label text-black">Father's Name(Bangla)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Father name bangla" id="father_name_bn" name="father_name_bn" required>
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="mother_name" class="form-label text-black">Mother's Name(English)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Mother name" id="mother_name" name="mother_name" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="mother_name_bn" class="form-label text-black">Mother's Name(Bangla)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Mother name bangla" id="mother_name_bn" name="mother_name_bn" required>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="home_district" class="form-label text-black">Home District*:</label>
                                <select class="form-select editmode text-black" id="home_district" name="home_district" required>
                                    <option value="" disabled selected>Select District</option>
                                    <option value="District 1">District 1</option>
                                    <option value="District 2">District 2</option>
                                    <option value="District 3">District 3</option>
                                    <option value="District 4">District 4</option>
                                </select>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <label for="present_address" class="form-label text-black">Present Address(English)*:</label>
                                    <textarea class="form-control editmode text-black" placeholder="Present Address" id="present_address" name="present_address" required></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label for="present_address_bn" class="form-label text-black">Present Address(Bangla)*:</label>
                                    <textarea class="form-control editmode text-black" placeholder="Present Address" id="present_address_bn" name="present_address_bn" required></textarea>
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="permanent_address" class="form-label text-black">Permanent Address(English)*:</label>
                                    <textarea class="form-control editmode text-black" placeholder="Present Address" id="permanent_address" name="permanent_address" required></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label for="permanent_address_bn" class="form-label text-black">Permanent Address(Bangla)*:</label>
                                    <textarea class="form-control editmode text-black" placeholder="Permanent Address" id="permanent_address_bn" name="permanent_address_bn" required></textarea>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="nid_number" class="form-label text-black">National ID/Birth Reg No*:</label>
                                <input type="text" class="form-control editmode text-black" placeholder="NID/Birth Reg No" id="nid_number" name="nid_number" required>
                            </div>

                            <div class="row mb-2">
                                <label for="b_day" class="form-label text-black">Date of Birth*:</label>
                                <div class="col-sm-4">
                                    <select class="form-select editmode text-black" id="b_day" name="b_day" required>
                                        <option value="" disabled selected>Select Date</option>
                                        @for ($i = 1; $i <= 31; $i++)
                                            @php
                                                $day = str_pad($i, 2, '0', STR_PAD_LEFT); // Pads with 0 to make it 2 digits
                                            @endphp
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endfor
                                    </select>   
                                </div>
                                
                                <div class="col-sm-4">
                                    <select class="form-select editmode text-black" id="b_month" name="b_month" required>
                                        <option value="" disabled selected>Select Month</option>
                                        @foreach ($months as $key => $month)
                                            <option value="{{ $key }}">{{ $key }} - {{ $month }}</option>
                                        @endforeach
                                    </select>   
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-select editmode text-black" id="b_year" name="b_year" required>
                                        <option value="" disabled selected>Select Year</option>
                                        @for ($i = 1950; $i <= 2007; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-6 mb-2">
                                    <label for="gender" class="form-label text-black">Gender*</label>
                                    <select class="form-select editmode text-black" id="gender" name="gender" required>
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label for="marital_status" class="form-label text-black">Marital Status*</label>
                                    <select class="form-select editmode text-black" id="marital_status" name="marital_status" required>
                                        <option value="" disabled selected>Select Marital Status</option>
                                        <option value="Married">Married</option>
                                        <option value="Unmarried">Unmarried</option>
                                        <option value="Divorced">Divorced</option>
                                    </select>
                                </div>                                
                            </div>

                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="religion" class="form-label text-black">Religion*:</label>
                                    <select class="form-select editmode text-black" id="religion" name="religion" required>
                                        <option value="" disabled selected>Select Religion</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Christian">Christian</option>
                                        <option value="Buddhist">Buddhist</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="nationality" class="form-label text-black">Nationality*:</label>
                                    <select class="form-select editmode text-black" id="nationality" name="nationality">
                                        <option value="Bangladeshi">Bangladeshi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="col-sm-4">
                                    <label for="current_job_duration" class="form-label text-black">Job Duration of current position*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Current Job Duration" id="current_job_duration" name="current_job_duration" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="previous_job_duration" class="form-label text-black">Job Duration of Previous position*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Prev job duration" id="previous_job_duration" name="previous_job_duration" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="total_job_duration" class="form-label text-black">Total job Duration*(মোট চাকরির মেয়াদ):</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Total Job duration" id="total_job_duration" name="total_job_duration" required>
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="mobile_no" class="form-label text-black">Mobile No*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Mobile No" id="mobile_no" name="mobile_no" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="email" class="form-label text-black">Email*:</label>
                                    <input type="email" class="form-control editmode text-black" placeholder="Email" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <fieldset>
                                <legend>Upload Your Photo:( <font color="blue"> ছবির  সাইজ ৩০০x৩০০ Pixel,ফরম্যাট .jpg এবং  100 KB এর  বেশী নয় ।</font>)</legend>
                                <div class="mb-2 row">
                                    
                                    <div class="col-sm-4 mt-2">
                                        <input type="file" class="form-control editmode text-black" id="photo" name="photo" required>
                                    </div>
                                    <div id="photo-preview" class="w-100 text-center mt-4">
                                        <img id="photo-preview-img" src="{{ asset('assets/images/nobody.png')}}" alt="Photo Preview" style=" max-width: 100%; margin:auto; height: 150px;">
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="mt-2">
                            <fieldset>
                                <legend>Upload Your Signature:( <font color="blue">  ছবির সাইজ ৩০০ X ৮০ Pixel,ফরম্যাট .jpg এবং 60 KB এর বেশী নয় ।</font>)</legend>
                                <div class="mb-2 row">
                                    <div class="col-sm-4 mt-2">
                                        <input type="file" class="form-control editmode text-black" id="signature" name="signature" required>
                                    </div>
                                    <div id="signature-preview" class="w-100 text-center mt-4">
                                        <img id="signature-preview-img" src="{{ asset('assets/images/sample_sig.jpg')}}" alt="Signature Preview" style=" max-width: 100%; margin:auto; height: 80px;">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="mt-2">
                            <fieldset style=" padding: 6px 25px !important; font-size: 14px !important;">   
                                <label for="" class="text-black">বর্তমানে আবেদনকারীর বিরুদ্বে কোন বিভাগীয় মামলা/লঘু বা গুরুদন্ড প্রাপ্ত কিনা?:*</label> &nbsp; &nbsp; 
                                <input type="radio" class="form-check-input cursor-pointer text-black" id="writ_petition" value="Yes" name="writ_petition">&nbsp;Yes &nbsp; &nbsp; 
                                <input type="radio" value="No" id="writ_petition" class="form-check-input text-black cursor-pointer" name="writ_petition">&nbsp;No
                             </fieldset>
                        </div>
                        <div class="mt-2 px-3 py-1">
                            <label for="password" class="form-label text-black">Password:</label>
                            <input type="password" class="form-control editmode text-black" placeholder="Password" id="password" name="password" required>
                        </div>
                        <div class="form-check px-3 py-1">
                            <input type="checkbox" class="form-check-input" name="info_yes" id="info_yes">
                            <label class="form-check-label" for="info_yes">Check this custom
                                I hereby declare that the information provided in this application is true and correct to the best of my knowledge. I understand that any false information may lead to disqualification or termination of employment.</label>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.getElementById('photo').addEventListener('change', function(event) {
        const preview = document.getElementById('photo-preview-img');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });
</script>
<script>
    document.getElementById('signature').addEventListener('change', function(event) {
        const preview = document.getElementById('signature-preview-img');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });
</script>

@endsection
