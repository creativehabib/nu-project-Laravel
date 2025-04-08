@extends('layouts.base', ['subtitle' => 'Home'])

@section('body-attribute')
    class="authentication-bg"
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('content')
    <div class="w-75 mx-auto bg-white">
        <div class="row">
            <div class="col-md-12">
                <div class="header">
                    <div class="text-center">
                        <img src="http://jobs.nu.ac.bd/apply_internal/img/logo_nu_banner.png" alt="Logo" class="img-fluid" />
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
                    <div class="jobs-form p-2">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
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
                            <div class="text-center mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
