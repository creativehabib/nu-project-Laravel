@php use App\Helpers\DateHelpers;use SimpleSoftwareIO\QrCode\Facades\QrCode; @endphp
<div class="sheet">
    <!-- FRONT -->
    <div class="card">
        <div class="front-header">
            <div class="logo"
                 style="width: {{ $idCardSettings->organization_logo_width ?? 28 }}px; height: {{ $idCardSettings->organization_logo_height ?? 28 }}px;">
                @if($idCardSettings?->organization_logo)
                    <img src="{{ asset('storage/' . $idCardSettings->organization_logo) }}"
                         alt="{{ $idCardSettings->organization_name_en ?? $idCardSettings->organization_name }}">
                @endif
            </div>
            <div class="org">
                <div class="bn"
                     style="font-size: {{ $idCardSettings->organization_name_font_size ?? 13 }}px;">{{ $idCardSettings->organization_name }}</div>
                <div class="en">{{ $idCardSettings->organization_name_en }}</div>
            </div>
        </div>
        <div class="photo-wrapper">
            <img src="{{ asset('uploads/images/' . $nuSmartCard->image) }}" alt="{{ $nuSmartCard->name }}">
        </div>
        <div class="front-body">
            <div class="meta">
                <h2>{{ $nuSmartCard->name }}</h2>
                <div class="role">{{ $nuSmartCard->designation?->name }}</div>
                <div class="dept">{{ $nuSmartCard->department?->name }}</div>
            </div>
        </div>
        @php
            $qrData = json_encode([
                'name'        => $nuSmartCard->name,
                'designation' => $nuSmartCard->designation?->name,
                'mobile'      => $nuSmartCard->mobile_number,
                'organization'=> $idCardSettings->organization_name ?? ''
            ]);
            $qrCode = base64_encode(
                QrCode::format('svg')->size(40)->errorCorrection('H')->generate($qrData)
            );
        @endphp
        <div class="footer">
            <div class="sig">
                <img src="{{ asset('uploads/signature/' . $nuSmartCard->signature) }}" alt="Card Holder"
                     class="sig-img">
                <div>Card Holder</div>
            </div>
            <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR" class="qr">
            <div class="sig">
                @if($idCardSettings?->authority_signature)
                    <img src="{{ asset('storage/' . $idCardSettings->authority_signature) }}"
                         alt="{{ $idCardSettings->authority_name ?? 'Registrar' }}" class="sig-img">
                @endif
                <div>{{ $idCardSettings->authority_name ?? 'Registrar' }}</div>
            </div>
        </div>
    </div>
    <!-- BACK -->
    <div class="card">
        <div class="front-header">
            <div class="logo"
                 style="width: {{ $idCardSettings->organization_logo_width ?? 28 }}px; height: {{ $idCardSettings->organization_logo_height ?? 28 }}px;">
                @if($idCardSettings?->organization_logo)
                    <img src="{{ asset('storage/' . $idCardSettings->organization_logo) }}"
                         alt="{{ $idCardSettings->organization_name_en ?? $idCardSettings->organization_name }}">
                @endif
            </div>
            <div class="org">
                <div class="bn"
                     style="font-size: {{ $idCardSettings->organization_name_font_size ?? 13 }}px;">{{ $idCardSettings->organization_name }}</div>
                <div class="en">{{ $idCardSettings->organization_name_en }}</div>
            </div>
        </div>
        <div class="back-body">
            <div class="kv">
                <div class="k">P.F. No.</div>
                <div>: {{ $nuSmartCard->pf_number }}</div>
            </div>
            <div class="kv">
                <div class="k">Mobile No.</div>
                <div>: {{ $nuSmartCard->mobile_number }}</div>
            </div>
            <div class="kv">
                <div class="k">Blood Group</div>
                <div>: {{ $nuSmartCard->blood?->name }}</div>
            </div>
            <div class="kv">
                <div class="k">Address</div>
                <div>: {{ $nuSmartCard->present_address }}</div>
            </div>
            <div class="kv push-down">
                <div class="k">Emergency Contact</div>
                <div>: {{ $nuSmartCard->emergency_contact }}</div>
            </div>
            <div class="kv">
                <div class="k">Valid Up to</div>
                <div>: {{ DateHelpers::dateFormat($nuSmartCard->prl_date, 'd-m-Y') }}</div>
            </div>
            <div class="note">{{ $idCardSettings->back_footer }}</div>
        </div>
        <div class="barcode">{{ $nuSmartCard->id_card_number }}</div>
    </div>
</div>
