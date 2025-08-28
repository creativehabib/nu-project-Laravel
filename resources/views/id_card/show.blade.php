<div class="id-card">
    @if($settings?->organization_logo)
        <img src="{{ asset('storage/' . $settings->organization_logo) }}" class="org-logo" style="width: {{ $settings->organization_logo_width ?? 28 }}px; height: {{ $settings->organization_logo_height ?? 28 }}px;">
    @endif

    <h2 style="font-size: {{ $settings->organization_name_font_size ?? 16 }}px;">{{ $settings?->organization_name }}</h2>
    @if($settings?->organization_name_en)
        <h3>{{ $settings->organization_name_en }}</h3>
    @endif
    <h3>{{ $user->name }}</h3>

    <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" class="qr-code">

    @if($settings?->authority_signature)
        <img src="{{ asset('storage/' . $settings->authority_signature) }}" class="authority-logo">
    @endif
</div>

