<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSmartCardRequest;
use App\Models\BloodGroup;
use App\Models\NuSmartCard;
use App\Models\Department;
use App\Models\Designation;
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
        $departments = Department::all();
        $designations = Designation::all();
        return view('frontend.nuSmartCard.index', compact('bloods', 'departments', 'designations'));
    }

    /**
     * @return Factory|Application|View|RedirectResponse
     */
    public function viewData(): Factory|Application|View|RedirectResponse
    {
        $submittedId = session('submitted_id');

        // Redirect if no session ID exists
        if (!$submittedId) {
            return redirect()->route('nu-smart-card.store_data')->with('error', 'No data found!');
        }

        // Fetch the record from the database
        $data = NuSmartCard::with(['blood', 'department', 'designation'])->find($submittedId);

        if (!$data) {
            return redirect()->route('nu-smart-card.store_data')->with('error', 'Record not found!');
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
    public function store_data(StoreSmartCardRequest $request): JsonResponse
    {
        logger('StoreSmartCardRequest Data:', $request->all());
        try {
            $smartCard = (new NuSmartCard())->storeSmartCard($request);
            if(!$smartCard){
                return response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
            }
            session(['submitted_id' => $smartCard->id]);
            return response()->json([
                'success' => true,
                'message' => 'Data submitted successfully!',
            ]);
        } catch (\Throwable $th) {
            logger($th);
            return response()->json(['success' => false, 'error' => $th->getMessage()], 500);
        }
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
    public function search(Request $request): JsonResponse
    {
        $term = $request->get('q');

        $results = NuSmartCard::with(['department', 'designation'])
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                      ->orWhere('pf_number', 'like', "%{$term}%")
                      ->orWhere('id_card_number', 'like', "%{$term}%");
            })
            ->limit(10)
            ->get();

        return response()->json($results);
    }
}
