@extends('layouts.vertical', ['subtitle' => 'Nu Smart Card'])
@section('css')
@endsection
@section('content')

    @include('layouts.partials/page-title', ['title' => 'User', 'subtitle' => 'Profile'])

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">My Account</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('profile.update',Auth::user()->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row row-cols-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" id="profile_image" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="old_password">Old Password</label>
                                <input type="password" id="old_password" name="old_password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="example-textarea" class="form-label">Text
                                    area</label>
                                <textarea class="form-control" id="example-textarea" rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-secondary">Update</button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection
