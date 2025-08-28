<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8" />
    <title>All ID Cards</title>
    <style>
        @page { size: Legal; margin: 1cm; }
        :root{
            --nu-green:#2f7d32;
            --nu-blue:#2c7fb8;
            --text:#111827;
            --muted:#4b5563;
            --border:#e5e7eb;
        }
        *{ box-sizing:border-box; }
        .sheets{display:flex;flex-wrap:wrap;gap:20px;}
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
        .card{
            width:5.5cm;
            height:8.7cm;
            background:#fff;
            border-radius:14px;
            border:1px solid var(--border);
            box-shadow: 0 6px 18px rgba(0,0,0,.08);
            overflow:hidden;
            position:relative;
            display:flex;
            flex-direction:column;
            padding-top: 14px;
        }
        .front-header{
            display:flex;
            align-items:center;
            gap:10px;
            padding:6px 10px;
            border-bottom:1px solid var(--border);
        }
        .logo {
            border-radius: 6px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid #eee;
            padding: 2px;
        }
        .logo img{
            width:100%;
            height:100%;
            object-fit:contain;
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
        .front-body{
            padding:10px;
            padding-top:5px;
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
        .footer{
            border-top:1px dashed var(--border);
            padding: 6px 8px 12px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-top:auto;
        }
        .qr{
            width:50px;
            height:50px;
            object-fit:contain;
            border:1px solid var(--border);
            border-radius:4px;
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
        .kv{display:grid;grid-template-columns:2.2cm 1fr;gap:4px;}
        .kv .k{color:var(--muted);}
        .barcode{
            font-family:monospace;letter-spacing:2px;color:#111;opacity:.7;font-size:12px;
            writing-mode:vertical-rl;transform:rotate(180deg);position:absolute;left:8px;top:30%;
        }
        .note {
            font-size: 10px;
            border-top: 1px dashed var(--border);
            padding: 6px;
            margin-top: auto;
            text-align: center;
        }
        .no-print{margin-bottom:10px;}
        @media print{.no-print{display:none;}}
    </style>
</head>
<body>
<div class="no-print">
    <a href="{{ route('nu-smart-card.all-cards.pdf') }}" style="padding:8px 12px;background:#2563eb;color:#fff;border-radius:4px;text-decoration:none;">Download PDF</a>
    <button onclick="window.print()" style="padding:8px 12px;background:#4b5563;color:#fff;border:none;border-radius:4px;">Print</button>
</div>
<div class="sheets">
    @foreach($nuSmartCards as $nuSmartCard)
        @include('nu-smart-card.partials.id-card', ['nuSmartCard' => $nuSmartCard, 'idCardSettings' => $idCardSettings])
    @endforeach
</div>
</body>
</html>
