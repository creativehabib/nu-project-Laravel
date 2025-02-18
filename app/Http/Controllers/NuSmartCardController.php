<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\NuSmartCard;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class NuSmartCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bloods = BloodGroup::where('status', 1)->get();
        return view('frontend.nuSmartCard.index', compact('bloods'));
    }

    /**
     * @return Factory|Application|View|RedirectResponse
     */
    public function viewData(): Factory|Application|View|RedirectResponse
    {
        $submittedId = session('submitted_id');

        // Redirect if no session ID exists
        if (!$submittedId) {
            return redirect()->route('nu-smart-card.store')->with('error', 'No data found!');
        }

        // Fetch the record from the database
        $data = NuSmartCard::find($submittedId);

        if (!$data) {
            return redirect()->route('nu-smart-card.store')->with('error', 'Record not found!');
        }
        // Calculate PRL Date (60 years from birth date)
        $birthDate = Carbon::parse($data->birth_date);
        $prlDate = $birthDate->addYears(60); // Add 60 years

        // Format Date for Readability
        $data->formatted_prl_date = $prlDate->format('F d, Y'); // Example: "January 10, 2085"
        $data->relative_prl_date = $prlDate->diffForHumans();  // Example: "in 35 years"

        return view('frontend.nuSmartCard.view', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'department' => 'required',
            'designation' => 'required|string|max:255',
            'pf_number' => 'required|numeric|unique:nu_smart_cards,pf_number',
            'birth_date' => 'required|date',
            'mobile_number' => 'required|numeric',
            'blood_group' => 'required',
            'present_address' => 'required|string',
            'emergency_contact' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'signature' => 'required|image|mimes:jpeg,png,jpg,webp|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle Image Uploads
        $imagePath = null;
        $signaturePath = null;

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $image = Image::make($imageFile->getRealPath());

            if ($image->width() !== 472 || $image->height() !== 590) {
                return response()->json(['errors' => ['image' => ['Image must be 472x590 pixels.']]], 422);
            }

            $imagePath = $imageFile->store('uploads/images', 'public');
        }

        if ($request->hasFile('signature')) {
            $signatureFile = $request->file('signature');
            $signature = Image::make($signatureFile->getRealPath());

            if ($signature->width() !== 300 || $signature->height() !== 80) {
                return response()->json(['errors' => ['signature' => ['Signature must not exceed 300x80 pixels.']]], 422);
            }

            $signaturePath = $signatureFile->store('uploads/signatures', 'public');
        }

        // Parse birth date and calculate PRL date
        $birthDate = Carbon::parse($request->birth_date);
        $prlDate = $birthDate->addYears(60); // Add 60 years

        // Save to Database
        $record = NuSmartCard::create([
            'name' => $request->name,
            'department' => $request->department,
            'designation' => $request->designation,
            'pf_number' => $request->pf_number,
            'birth_date' => $request->birth_date,
            'prl_date' => $prlDate->toDateString(),
            'mobile_number' => $request->mobile_number,
            'blood_id' => $request->blood_group,
            'present_address' => $request->present_address,
            'emergency_contact' => $request->emergency_contact,
            'image' => $imagePath,
            'signature' => $signaturePath,
        ]);

        if ($record) {
            session(['submitted_id' => $record->id]);
            return response()->json([
                'success' => true,
                'message' => 'Data submitted successfully!',
                'data' => $record
            ]);
        }

        return response()->json(['success' => false], 500);
    }


    /**
     * Display the specified resource.
     */
    public function show(NuSmartCard $nuSmartCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NuSmartCard $nuSmartCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NuSmartCard $nuSmartCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NuSmartCard $nuSmartCard)
    {
        //
    }
}
