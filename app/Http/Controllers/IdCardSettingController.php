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
        return view('id_card.settings', compact('settings'));
    }

    /**
     * Update the ID card settings.
     */
    public function update(Request $request)
    {
        $settings = IdCardSetting::first() ?? new IdCardSetting();

        $settings->organization_name = $request->organization_name;
        $settings->authority_name    = $request->authority_name;

        if ($request->hasFile('organization_logo')) {
            $path = $request->organization_logo->store('logos', 'public');
            $settings->organization_logo = $path;
        }

        if ($request->hasFile('authority_logo')) {
            $path = $request->authority_logo->store('logos', 'public');
            $settings->authority_logo = $path;
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

