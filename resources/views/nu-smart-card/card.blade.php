<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ID Card 5.5cm x 8.7cm</title>
  <style>
    @page { size: A4; margin: 1cm; }
    :root{
      --nu-green:#2f7d32;
      --nu-blue:#2c7fb8;
      --text:#111827;
      --muted:#4b5563;
      --border:#e5e7eb;
    }
    *{ box-sizing:border-box; }
    .no-print{margin-bottom:10px;}
    @media print{.no-print{display:none;}}
    .back-body {
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: 11px;
        flex: 1;
        padding-left: 30px !important;
    }
    .sheet{
      display:grid;
      grid-template-columns: 5.5cm 5.5cm;
      gap: 20px;
    }
    .card {
        width: 5.5cm;
        height: 8.7cm;
        background: #fff;
        border-radius: 14px;
        border: 1px solid var(--border);
        box-shadow: 0 6px 18px rgba(0,0,0,.08);
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
        padding-top: 14px;
    }
    /* Header */
    .front-header {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-bottom: 1px solid var(--border);
        justify-content: center;
    }
    .logo {
    }
    .logo img{
      width:100%;
      height:100%;
      object-fit:cover;
    }
    .org{line-height:1.05;}
    .org .bn {
      font-weight: 700;
    }
    .org .en {
      font-size: 9px;
      color: var(--muted);
      letter-spacing: 0.2px;
    }

    .push-down {
      margin-top: 14px;
    }
    /* Front body */
    .front-body{
        padding: 5px 10px 10px;
        display:flex;
      flex-direction:column;
      align-items:center;
      flex:1;
    }
    .photo-wrapper {
        width: 100%;
        height: {{ $idCardSettings->photo_width ?? 100 }}px;
        background-color: {{ $idCardSettings->photo_background_color ?? '#f3f4f6' }};
        border-bottom: 1px solid var(--border);
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,.1);
    }
    .photo-wrapper img {
        width: 50%;
        height: {{ $idCardSettings->photo_height ?? 3.5 }}cm;
        object-fit: contain;
        border-bottom: 1px solid var(--border);
        transform: translate(50%);
    }
    .meta{text-align:center;}
    .meta h2{margin:4px 0;font-size:14px;font-weight:800;}
    .meta .role{font-size:11px;color:var(--muted);}
    .meta .dept{font-size:11px;}
    /* Footer */
    .footer {
        border-top: 1px dashed var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding: 6px 8px 12px;
    }
    .qr {
        width: 50px;
        object-fit: cover;
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: 2px;
    }
    .signs{
      display:flex;
      justify-content:space-between;
      gap:20px;
      flex:1;
      margin-left:10px;
    }
    .sig{text-align:center;font-size:10px;color:var(--muted);}
    .sig-img{width:70px;height:auto;object-fit:contain;}
    /* Back */
    .back-body{
      padding:10px;display:flex;flex-direction:column;gap:6px;font-size:10.5px;flex:1;
    }
    .kv{display:grid;grid-template-columns:2.2cm 1fr;gap:4px;}
    .kv .k{color:var(--muted);}
    .barcode{
      font-family:monospace;letter-spacing:2px;color:#111;opacity:.7;font-size:12px;
      writing-mode:vertical-rl;position:absolute;left:8px;top:27%;
    }
    .note {
        font-size: 10px;
        border-top: 1px dashed var(--border);
        padding: 6px;
        margin-top: auto;
        text-align: center;
    }
    @media print{
      body{background:#fff;padding:0;}
      .sheet{gap:0;grid-template-columns:5.5cm 5.5cm;justify-content:space-between;padding:0 1cm;}
      .card{box-shadow:none;margin:0;}
    }
  </style>
</head>
<body>
@php use SimpleSoftwareIO\QrCode\Facades\QrCode; @endphp
<div class="no-print">
  <button onclick="window.print()" style="padding:8px 12px;background:#4b5563;color:#fff;border:none;border-radius:4px;">Print</button>
</div>
<div class="sheet">
    <!-- FRONT -->
    <div class="card">
      <div class="front-header">
        <div class="logo" style="width: {{ $idCardSettings->organization_logo_width ?? 28 }}px; height: {{ $idCardSettings->organization_logo_height ?? 28 }}px;">
          @if($idCardSettings?->organization_logo)
            <img src="{{ asset('storage/' . $idCardSettings->organization_logo) }}" alt="{{ $idCardSettings->organization_name_en ?? $idCardSettings->organization_name }}">
          @endif
        </div>
        <div class="org">
          <div class="bn" style="font-size: {{ $idCardSettings->organization_name_font_size ?? 13 }}px;">{{ $idCardSettings->organization_name }}</div>
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
          $qrData = $nuSmartCard->name . "\n" .
             ($nuSmartCard->designation?->name ?? '') . "\n" .
             $nuSmartCard->mobile_number . "\n" .
             ($idCardSettings->organization_name_en ?? '');

         $qrCode = base64_encode(
           QrCode::format('svg')->size(400)->errorCorrection('H')->generate($qrData)
         );
      @endphp
      <div class="footer">
      <div class="sig">
        <img src="{{ asset('uploads/signature/' . $nuSmartCard->signature) }}" alt="Card Holder" class="sig-img">
        <div>Card Holder</div>
      </div>

      <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR" class="qr">

      <div class="sig">
        @if($idCardSettings?->authority_signature)
          <img src="{{ asset('storage/' . $idCardSettings->authority_signature) }}" alt="{{ $idCardSettings->authority_name ?? 'Registrar' }}" class="sig-img">
        @endif
        <div>{{ $idCardSettings->authority_name ?? 'Registrar' }}</div>
      </div>
    </div>
    </div>
    <!-- BACK -->
    <div class="card">
      <div class="front-header">
        <div class="logo" style="width: {{ $idCardSettings->organization_logo_width ?? 28 }}px; height: {{ $idCardSettings->organization_logo_height ?? 28 }}px;">
          @if($idCardSettings?->organization_logo)
            <img src="{{ asset('storage/' . $idCardSettings->organization_logo) }}" alt="{{ $idCardSettings->organization_name_en ?? $idCardSettings->organization_name }}">
          @endif
        </div>
        <div class="org">
          <div class="bn" style="font-size: {{ $idCardSettings->organization_name_font_size ?? 13 }}px;">{{ $idCardSettings->organization_name }}</div>
          <div class="en">{{ $idCardSettings->organization_name_en }}</div>
        </div>
      </div>
      <div class="back-body">
        <div class="kv"><div class="k">P.F. No.</div><div>: {{ $nuSmartCard->pf_number }}</div></div>
        <div class="kv"><div class="k">Mobile No.</div><div>: {{ $nuSmartCard->mobile_number }}</div></div>
        <div class="kv"><div class="k">Blood Group</div><div>: {{ $nuSmartCard->blood?->name }}</div></div>
        <div class="kv"><div class="k">Address</div><div>: {{ $nuSmartCard->present_address }}</div></div>
        <div class="kv push-down"><div class="k">Emergency Contact</div><div>: {{ $nuSmartCard->emergency_contact }}</div></div>
        <div class="kv"><div class="k">Valid Up to</div><div>: {{ \App\Helpers\DateHelpers::dateFormat($nuSmartCard->prl_date, 'd-m-Y') }}</div></div>
        <div class="note">{{ $idCardSettings->back_footer }}</div>
      </div>
      <div class="barcode">{{ $nuSmartCard->id_card_number }}</div>
    </div>
  </div>
</body>
</html>
