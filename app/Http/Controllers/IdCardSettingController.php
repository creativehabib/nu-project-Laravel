<?php

namespace App\Http\Controllers;

use App\Models\IdCardSetting;
use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IdCardSettingController extends Controller
{
    /**
     * Show the form for editing the ID card settings.
     */
    public function edit()
    {
        $settings = IdCardSetting::first() ?? new IdCardSetting();
        return view('dashboard.id-card.settings', compact('settings'));
    }

    /**
     * Update the ID card settings.
     */
    public function update(Request $request)
    {
        $settings = IdCardSetting::first() ?? new IdCardSetting();

        $settings->organization_name           = $request->organization_name;
        $settings->organization_name_en        = $request->organization_name_en;
        $settings->organization_name_font_size = $request->organization_name_font_size;
        $settings->organization_logo_width     = $request->organization_logo_width;
        $settings->organization_logo_height    = $request->organization_logo_height;
        $settings->authority_name              = $request->authority_name;
        $settings->back_footer                 = $request->back_footer;

        if ($request->hasFile('organization_logo')) {
            $path = $request->organization_logo->store('logos', 'public');
            $settings->organization_logo = $path;
        }

        if ($request->hasFile('authority_signature')) {
            $path = $request->authority_signature->store('signatures', 'public');
            $settings->authority_signature = $path;
        }

        $settings->save();

        return redirect()->back()->with('success', 'Settings updated!');
    }

    /**
     * Display an ID card for the given user with QR code.
     */
    public function show(User $user)
    {
        $settings = IdCardSetting::first();
        $qrData = json_encode([
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ]);
        $qrCode = QrCode::format('png')->size(200)->generate($qrData);

        return view('id_card.show', compact('settings', 'user', 'qrCode'));
    }
}

