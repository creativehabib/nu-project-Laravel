<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSmartCardRequest;
use App\Models\BloodGroup;
use App\Models\NuSmartCard;
use App\Models\Department;
use App\Models\Designation;
use App\Models\IdCardSetting;
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
        // Calculate PRL Date (60 years from birthdate)
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
     * @param StoreSmartCardRequest $request
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

    /**
     * Show a form to search ID card by PF number.
     */
    public function pfForm(): View
    {
        return view('frontend.nuSmartCard.pf');
    }

    /**
     * Display ID card for the submitted PF number.
     */
    public function pfShow(Request $request)
    {
        $data = $request->validate([
            'pf_number' => 'required',
        ]);

        $nuSmartCard = NuSmartCard::with(['designation', 'department', 'blood'])
            ->where('pf_number', $data['pf_number'])
            ->firstOrFail();

        $idCardSettings = IdCardSetting::first();

        return view('nu-smart-card.card', compact('nuSmartCard', 'idCardSettings'));
    }

    /**
     * Generate a PDF of the ID card for the submitted PF number.
     */
    public function pfShowPdf(Request $request)
    {
        $data = $request->validate([
            'pf_number' => 'required',
        ]);

        $nuSmartCard = NuSmartCard::with(['designation', 'department', 'blood'])
            ->where('pf_number', $data['pf_number'])
            ->firstOrFail();

        $idCardSettings = IdCardSetting::first();

        try {
            $view = view('nu-smart-card.card_pdf', compact('nuSmartCard', 'idCardSettings'));
            $html = $view instanceof View ? $view->render() : (string) $view;
        } catch (\Throwable $e) {
            return back()->with('error', 'Unable to generate PDF for the ID card.');
        }

        $html = trim((string) $html);
        if ($html === '') {
            return back()->with('error', 'Unable to generate PDF for the ID card.');
        }

        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'nikosh',
            'mode' => 'utf-8',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
            'format' => 'A4',
        ]);

        try {
            $mpdf->WriteHTML($html);
        } catch (\Throwable $e) {
            return back()->with('error', 'Unable to generate PDF for the ID card.');
        }

        $pdfContent = $mpdf->Output('', 'S');

        return response()->streamDownload(
            fn () => print($pdfContent),
            'id-card.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }

    /**
     * Show all ID cards on a legal-sized page with print/download options.
     */
    public function allCards(): View
    {
        $nuSmartCards = NuSmartCard::with(['designation', 'department', 'blood'])
            ->orderBy('order_position', 'asc')
            ->paginate(6);
        $idCardSettings = IdCardSetting::first();
        return view('nu-smart-card.all_cards', compact('nuSmartCards', 'idCardSettings'));
    }

    /**
     * Download all ID cards as a PDF in legal size.
     */
    public function downloadAllCardsPdf()
    {
        $nuSmartCards = NuSmartCard::with(['designation', 'department', 'blood'])
            ->orderBy('order_position', 'asc')
            ->get();

        if ($nuSmartCards->isEmpty()) {
            return back()->with('error', 'No smart cards available to download.');
        }

        $idCardSettings = IdCardSetting::first();
        if (!$idCardSettings) {
            return back()->with('error', 'ID card settings are missing.');
        }

        try {
            $view = view('nu-smart-card.all_mastercard_pdf', compact('nuSmartCards', 'idCardSettings'));
            $html = $view instanceof View ? $view->render() : (string) $view;
        } catch (\Throwable $e) {
            return back()->with('error', 'Unable to generate PDF for ID cards.');
        }

        $html = trim((string) $html);
        if ($html === '') {
            return back()->with('error', 'Unable to generate PDF for ID cards.');
        }

        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'nikosh',
            'mode' => 'utf-8',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
            'format' => 'Legal',
            'orientation' => 'L',
        ]);

        try {
            $mpdf->WriteHTML($html);
        } catch (\Throwable $e) {
            return back()->with('error', 'Unable to generate PDF for ID cards.');
        }

        $pdfContent = $mpdf->Output('', 'S');

        return response()->streamDownload(
            fn () => print($pdfContent),
            'all-id-cards.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }
}
