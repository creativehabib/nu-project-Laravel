@extends('layouts.vertical', ['subtitle' => 'ID Card Settings'])

@section('content')
    @include('layouts.partials.page-title', ['title' => 'ID Card', 'subtitle' => 'Settings'])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('id-card.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">প্রতিষ্ঠানের নাম</label>
                    <input type="text" name="organization_name" class="form-control" value="{{ $settings->organization_name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">প্রতিষ্ঠানের লোগো</label>
                    <input type="file" name="organization_logo" class="form-control">
                    @if($settings->organization_logo)
                        <img src="{{ asset('storage/' . $settings->organization_logo) }}" height="60" class="mt-2">
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">কর্তৃপক্ষের নাম</label>
                    <input type="text" name="authority_name" class="form-control" value="{{ $settings->authority_name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">কর্তৃপক্ষের লোগো</label>
                    <input type="file" name="authority_logo" class="form-control">
                    @if($settings->authority_logo)
                        <img src="{{ asset('storage/' . $settings->authority_logo) }}" height="60" class="mt-2">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">সংরক্ষণ</button>
            </form>
        </div>
    </div>
@endsection
