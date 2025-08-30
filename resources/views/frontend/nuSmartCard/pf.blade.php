@extends('layouts.base', ['subtitle' => 'ID Card Search'])

@section('css')
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
            grid-template-columns: 5.4cm 5.4cm;
            gap: 20px;
        }
        .card {
            width: 5.4cm;
            height: 8.56cm;
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
            .sheet{gap:0;grid-template-columns:5.4cm 5.4cm;justify-content:space-between;padding:0 1cm;}
            .card{box-shadow:none;margin:0;}
        }
    </style>
@endsection

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">National University</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#works">Our Work</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('nu-smart-card.pf-form') }}">ID Card Search</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="display-6 text-center mb-4">Find ID Card</h1>

        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <form action="{{ route('nu-smart-card.pf-show') }}" method="POST" class="row g-3 justify-content-center mb-4">
            @csrf
            <div class="col-auto">
                <input type="text" name="pf_number" value="{{ old('pf_number') }}" class="form-control" placeholder="Enter PF Number">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        @isset($nuSmartCard)
            <div class="d-flex flex-column align-items-center">
                @include('nu-smart-card.partials.id-card', ['nuSmartCard' => $nuSmartCard, 'idCardSettings' => $idCardSettings])
                @php $pdfUrl = route('nu-smart-card.pf-show.pdf', ['pf_number' => $nuSmartCard->pf_number]); @endphp
                <div class="no-print mt-3 text-center">
                    <button class="btn btn-secondary me-2" onclick="window.print()">Print</button>
                    <a href="{{ $pdfUrl }}" class="btn btn-dark" target="_blank">Download PDF</a>
                </div>
            </div>
        @endisset
    </div>
@endsection

