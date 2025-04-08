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
                                <label for="name" class="form-label text-black">Name of the Post*:</label>
                                <select class="form-select editmode text-black" id="name" name="name" required>
                                    <option value="" disabled selected>Select Post</option>
                                    <option value="Post 1">Post 1</option>
                                    <option value="Post 2">Post 2</option>
                                    <option value="Post 3">Post 3</option>
                                    <option value="Post 4">Post 4</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="name" class="form-label text-black">PF No*:</label>
                                <input type="text" class="form-control editmode text-black" id="name" name="name" required>
                            </div>
                            <div class="mb-2">
                                <label for="name" class="form-label text-black">Present Designation:*(বর্তমান পদ):</label>
                                <input type="text" class="form-control editmode text-black" placeholder="Designation" id="name" name="name" required>
                            </div>
                            <div class="mb-2">
                                <label for="name" class="form-label text-black">Department:*(দপ্তর):</label>
                                <input type="text" class="form-control editmode text-black" placeholder="Department" id="name" name="name" required>
                            </div>
                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="present_salary" class="form-label text-black">Applicant's Name (English)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Salary" id="present_salary" name="present_salary" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="proposed_salary" class="form-label text-black">Applicant's Name (Bangla)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Salary" id="proposed_salary" name="proposed_salary" required>
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="present_salary" class="form-label text-black">Father's Name(English)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Salary" id="present_salary" name="present_salary" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="proposed_salary" class="form-label text-black">Father's Name(Bangla)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Salary" id="proposed_salary" name="proposed_salary" required>
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="present_salary" class="form-label text-black">Mother's Name(English)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Salary" id="present_salary" name="present_salary" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="proposed_salary" class="form-label text-black">Mother's Name(Bangla)*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Salary" id="proposed_salary" name="proposed_salary" required>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="name" class="form-label text-black">Home District*:</label>
                                <select class="form-select editmode text-black" id="name" name="name" required>
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
                                    <label for="present_address" class="form-label text-black">Present Address(Bangla)*:</label>
                                    <textarea class="form-control editmode text-black" placeholder="Present Address" id="present_address" name="permanent_address" required></textarea>
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="present_salary" class="form-label text-black">Permanent Address(English)*:</label>
                                    <textarea class="form-control editmode text-black" placeholder="Present Address" id="present_address" name="permanent_address" required></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label for="proposed_salary" class="form-label text-black">Permanent Address(Bangla)*:</label>
                                    <textarea class="form-control editmode text-black" placeholder="Present Address" id="present_address" name="permanent_address" required></textarea>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="nid_number" class="form-label text-black">National ID/Birth Reg No*:</label>
                                <input type="text" class="form-control editmode text-black" placeholder="NID/Birth Reg No" id="nid_number" name="nid_number" required>
                            </div>

                            <div class="row mb-2">
                                <label for="date_of_birth" class="form-label text-black">Date of Birth*:</label>
                                <div class="col-sm-4">
                                    <select class="form-select editmode text-black" id="date_of_birth" name="date_of_birth" required>
                                        <option value="" disabled selected>Date</option>
                                        @for ($i = 1; $i <= 31; $i++)
                                            @php
                                                $day = str_pad($i, 2, '0', STR_PAD_LEFT); // Pads with 0 to make it 2 digits
                                            @endphp
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endfor
                                    </select>   
                                </div>
                                
                                <div class="col-sm-4">
                                    <select class="form-select editmode text-black" id="date_of_birth" name="date_of_birth" required>
                                        <option value="" disabled selected>Month</option>
                                        @foreach ($months as $key => $month)
                                            <option value="{{ $key }}">{{ $key }} - {{ $month }}</option>
                                        @endforeach
                                    </select>   
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-select editmode text-black" id="date_of_birth" name="date_of_birth" required>
                                        <option value="" disabled selected>Year</option>
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
                                    <label for="present_salary" class="form-label text-black">Religion*:</label>
                                    <select class="form-select editmode text-black" id="present_salary" name="present_salary" required>
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
                                    <label for="present_salary" class="form-label text-black">Job Duration of current position*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Job Duration" id="present_salary" name="present_salary" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="proposed_salary" class="form-label text-black">Job Duration of Previous position*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Date of Joining" id="proposed_salary" name="proposed_salary" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="proposed_salary" class="form-label text-black">Total job Duration*(মোট চাকরির মেয়াদ):</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Date of Joining" id="proposed_salary" name="proposed_salary" required>
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="col-sm-6">
                                    <label for="present_salary" class="form-label text-black">Mobile No*:</label>
                                    <input type="text" class="form-control editmode text-black" placeholder="Mobile No" id="present_salary" name="present_salary" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="proposed_salary" class="form-label text-black">Email*:</label>
                                    <input type="email" class="form-control editmode text-black" placeholder="Email" id="proposed_salary" name="proposed_salary" required>
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
                                        <img id="photo-preview-img" src="{{ asset('assets/images/nobody.png')}}" alt="Photo Preview" style=" max-width: 100%; height: 150px;">
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="mt-2">
                            <fieldset>
                                <legend>Upload Your Signature:( <font color="blue">  ছবির সাইজ ৩০০ X ৮০ Pixel,ফরম্যাট .jpg এবং 60 KB এর বেশী নয় ।</font>)</legend>
                                <div class="mb-2 row">
                                    
                                    <div class="col-sm-4 mt-2">
                                        <input type="file" class="form-control editmode text-black" id="photo" name="photo" required>
                                    </div>
                                    <div id="photo-preview" class="w-100 text-center mt-4">
                                        <img id="photo-preview-img" src="{{ asset('assets/images/sample_sig.jpg')}}" alt="Photo Preview" style=" max-width: 100%; height: 80px;">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="mt-2 px-3 py-1">
                            <label for="password" class="form-label text-black">Password:</label>
                            <input type="password" class="form-control editmode text-black" id="password" name="password" required>
                        </div>
                        <div class="form-check px-3 py-1">
                            <input type="checkbox" class="form-check-input" id="customCheck1">
                            <label class="form-check-label" for="customCheck1">Check this custom
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
