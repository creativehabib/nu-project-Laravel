@extends('layouts.vertical', ['subtitle' => 'ID Card Settings'])

@section('content')
    @include('layouts.partials.page-title', ['title' => 'ID Card', 'subtitle' => 'Settings'])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('id-card.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">প্রতিষ্ঠানের নাম (বাংলা)</label>
                    <input type="text" name="organization_name" class="form-control" value="{{ $settings->organization_name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">প্রতিষ্ঠানের নাম (ইংরেজি)</label>
                    <input type="text" name="organization_name_en" class="form-control" value="{{ $settings->organization_name_en }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">বাংলা নামের ফন্ট সাইজ</label>
                    <input type="number" name="organization_name_font_size" class="form-control" value="{{ $settings->organization_name_font_size }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">প্রতিষ্ঠানের লোগো</label>
                    <input type="file" name="organization_logo" class="form-control">
                    @if($settings->organization_logo)
                        <img src="{{ asset('storage/' . $settings->organization_logo) }}" height="60" class="mt-2">
                    @endif
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label class="form-label">লোগোর প্রস্থ (px)</label>
                        <input type="number" name="organization_logo_width" class="form-control" value="{{ $settings->organization_logo_width }}">
                    </div>
                    <div class="col">
                        <label class="form-label">লোগোর উচ্চতা (px)</label>
                        <input type="number" name="organization_logo_height" class="form-control" value="{{ $settings->organization_logo_height }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">কর্তৃপক্ষের নাম</label>
                    <input type="text" name="authority_name" class="form-control" value="{{ $settings->authority_name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">কর্তৃপক্ষের স্বাক্ষর</label>
                    <input type="file" name="authority_signature" class="form-control">
                    @if($settings->authority_signature)
                        <img src="{{ asset('storage/' . $settings->authority_signature) }}" height="60" class="mt-2">
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">ব্যাক সাইড ফুটার</label>
                    <textarea name="back_footer" class="form-control" rows="3">{{ $settings->back_footer }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">সংরক্ষণ</button>
            </form>
        </div>
    </div>
@endsection
