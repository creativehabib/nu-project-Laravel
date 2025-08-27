<form action="{{ url('/id-card/settings') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>প্রতিষ্ঠানের নাম</label>
    <input type="text" name="organization_name" value="{{ $settings->organization_name }}">

    <label>প্রতিষ্ঠানের লোগো</label>
    <input type="file" name="organization_logo">
    @if($settings->organization_logo)
        <img src="{{ asset('storage/' . $settings->organization_logo) }}" height="60">
    @endif

    <label>কর্তৃপক্ষের নাম</label>
    <input type="text" name="authority_name" value="{{ $settings->authority_name }}">

    <label>কর্তৃপক্ষের লোগো</label>
    <input type="file" name="authority_logo">
    @if($settings->authority_logo)
        <img src="{{ asset('storage/' . $settings->authority_logo) }}" height="60">
    @endif

    <button type="submit">সংরক্ষণ</button>
</form>

