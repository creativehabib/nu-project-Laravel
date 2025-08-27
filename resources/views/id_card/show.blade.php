<div class="id-card">
    @if($settings?->organization_logo)
        <img src="{{ asset('storage/' . $settings->organization_logo) }}" class="org-logo">
    @endif

    <h2>{{ $settings?->organization_name }}</h2>
    <h3>{{ $user->name }}</h3>

    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" class="qr-code">

    @if($settings?->authority_logo)
        <img src="{{ asset('storage/' . $settings->authority_logo) }}" class="authority-logo">
    @endif
</div>

