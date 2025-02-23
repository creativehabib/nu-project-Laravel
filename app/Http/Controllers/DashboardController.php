<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSmartCardRequest;
use App\Http\Requests\updateSmartCardRequest;
use App\Models\BloodGroup;
use App\Models\NuSmartCard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DashboardController extends Controller
{
    public function index()
    {
        $data = NuSmartCard::query()->paginate(5);
        return view('nu-smart-card.index', compact('data'));
    }

    public function create()
    {
        $bloods = BloodGroup::all();
        return view('nu-smart-card.create', compact('bloods'));
    }

    /**
     * @param StoreSmartCardRequest $request
     * @return JsonResponse
     */
    public function store(StoreSmartCardRequest $request): JsonResponse
    {
        try {
            $smartCard = (new NuSmartCard())->storeSmartCard($request);
            return response()->json([
                'success' => true,
                'message' => 'Data submitted successfully!',
            ]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false,'message'=> 'Data not submitted successfully!'], 500);
        }
    }

    public function show($id)
    {
        $nuSmartCard = NuSmartCard::query()->with('blood')->findOrFail($id);
        return view('nu-smart-card.show',compact('nuSmartCard'));
    }

    public function edit($id)
    {
        $bloods = BloodGroup::where('status', 1)->get();
        $data = NuSmartCard::query()->findOrFail($id);
        return view('nu-smart-card.edit',compact('data','bloods'));
    }

    /**
     * @param updateSmartCardRequest $request
     * @param NuSmartCard $nuSmartCard
     * @return JsonResponse
     */
    public function update(updateSmartCardRequest $request, NuSmartCard $nuSmartCard): JsonResponse
    {
        try {
            (new NuSmartCard())->updateSmartCard($request, $nuSmartCard);
            return response()->json(['success' => true, 'message' => 'Data updated successfully!']);
        } catch (\Throwable $throwable){
            return response()->json(['success' => false,'message'=> 'Data not updated successfully!'], 500);
        }
    }

    /**
     * @param NuSmartCard $nuSmartCard
     * @return JsonResponse
     */
    public function destroy(NuSmartCard $nuSmartCard): JsonResponse
    {
        (new NuSmartCard())->deleteSmartCard($nuSmartCard);
        return response()->json(['success' => true, 'message' => 'Data deleted successfully!']);
    }


    public function getPdfData(){
        $data = NuSmartCard::all();
        date_default_timezone_set("Asia/Dhaka");
        $html = '
        <!doctype html>
        <meta charset="UTF-8">
        <head>
        <style>
        body {
            font-size: 10pt;
        }
        p {	margin: 0pt; }
        table.items {
            border: 0.1mm solid #323639;
        }
        td { vertical-align: top; }
        .items td {
            border-left: 0.1mm solid #323639;
            border-right: 0.1mm solid #323639;
        }
        table thead td { background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #323639;
            font-variant: small-caps;
        }
        table tbody tr {
        border: 0.1mm solid #323639;
        }

        </style>
        </head>
        <body>
        <!--mpdf
        <htmlpageheader name="myheader">
        <table width="100%" style="text-align:center;">
        <tr>
        <td width="50%" style="color:#323639; ">
        <span style="font-weight: bold; font-size: 20pt;">জাতীয় বিশ্ববিদ্যালয়</span>
        <br /><span style="font-size:14pt;">বাংলাদেশ</span><br /><span style="font-size:14pt">কলেজ পরিদর্শন দপ্তর</span> <br/>
        </td>

        </tr></table>
        </htmlpageheader>
        <htmlpagefooter name="myfooter">
        <div style="font-size: 10pt; text-align: center; padding-top: 3mm; ">
        Page {PAGENO} of {nb}
        </div>
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
        <sethtmlpagefooter name="myFooter1" value="on" />
        mpdf-->
        <table class="items table" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Name</td>
                    <td>Department</td>
                    <td>Designation</td>
                    <td>PF No</td>
                    <td>PRL Date</td>
                    <td>Blood Group</td>
                    <td>Mobile No</td>
                    <td>Present Address</td>
                    <td>Emergency No</td>
                    <td>Image</td>
                    <td>Signature</td>
                </tr>
            </thead>
        <tbody>
        <!-- ITEMS HERE -->';
        $i ='';
        foreach($data as $row){
            $html .= '<tr>';
            $html .= '<td>'.++$i.'</td>';
            $html .= '<td>'.$row['name'].'</td>';
            $html .= '<td>'.$row['department'].'</td>';
            $html .= '<td>'.$row['designation'].'</td>';
            $html .= '<td>'.$row['pf_number'].'</td>';
            $html .= '<td>'.$row['prl_date'].'</td>';
            $html .= '<td>'.$row->blood->name.'</td>';
            $html .= '<td>'.$row['mobile_number'].'</td>';
            $html .= '<td>'.$row['present_address'].'</td>';
            $html .= '<td>'.$row['emergency_contact'].'</td>';
            $html .= '<td><img src="uploads/images/'.$row['image'].'" alt="" style="width: 75px; object-fit: cover"></td>';
            $html .= '<td><img src="uploads/signature/'.$row['signature'].'" alt="" style="width: 75px; object-fit: cover"></td>';
            $html .= '</tr>';
        };


        $html .='

        <!-- END ITEMS HERE -->
        </tbody>
        </table>
        <htmlpagefooter name="myFooter1">
        <div style="border-top: .25px solid #323639; font-size: 9pt; text-align: center; padding-top: 3mm; ">
            <table width="100%">
                <tr>
                    <td width="33%">Date: {DATE j-m-Y} Time: {DATE h:i:sa}</td>
                    <td width="33%" align="center">Page {PAGENO} of {nbpg}</td>
                    <td width="33%" style="text-align: right; ">Print by: '.Auth::user()->name.'</td>
                </tr>
            </table>
            </div>
        </htmlpagefooter>
        </body>
        </html>';

        //$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
        //require_once $path . '/vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'nikosh',
            'mode' => 'utf-8',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 30,
            'margin_bottom' => 25,
            'margin_header' => 5,
            'margin_footer' => 5,
            'format' => 'Legal',
            'orientation' => 'L'
        ]);

        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("National University. - Data file");
        $mpdf->SetAuthor("NU");
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

    // single pdf
    public function getSinglePdfData($id)
    {
        // get single data
        $data = NuSmartCard::query()->with('blood')->findOrFail($id);
        date_default_timezone_set("Asia/Dhaka");
        $html = '
        <!doctype html>
        <meta charset="UTF-8">
        <head>
        <style>
        body {
            font-size: 10pt;
        }
        table.items {
            border: 0.1mm solid #323639;
        }
        th, td { padding: 9pt }
        .items th{
            text-align: left;
        }
        .items td {
            border-left: 0.1mm solid #323639;
            border-right: 0.1mm solid #323639;
        }
        table thead td { background-color: #EEEEEE;
            border: 0.1mm solid #323639;
            font-variant: small-caps;
        }
        table tr {
            border: 0.1mm solid #323639;
        }

        </style>
        </head>
        <body>
        <!--mpdf
        <htmlpageheader name="myheader">
        <table width="100%" style="text-align:center;">
        <tr>
        <td width="50%" style="color:#323639; ">
        <span style="font-weight: bold; font-size: 20pt;">জাতীয় বিশ্ববিদ্যালয়</span>
        <br /><span style="font-size:14pt;">বাংলাদেশ</span><br /><span style="font-size:14pt">কলেজ পরিদর্শন দপ্তর</span> <br/>
        </td>

        </tr></table>
        </htmlpageheader>
        <htmlpagefooter name="myfooter">
        <div style="font-size: 9pt;">
        Page {PAGENO} of {nb}
        </div>
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
        <sethtmlpagefooter name="myFooter1" value="on" />
        mpdf-->
        <h4 style="text-align: center; color: #2f3944;">Smart ID Card Information</h4>
        <table class="items table" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
        <!-- ITEMS HERE -->';
        $html .= '<tr>
                    <th>Name</th>
                    <td>'.$data->name.'</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>'.$data->department.'</td>
                </tr>
                <tr>
                    <th>Designation</th>
                    <td>'.$data->designation.'</td>
                </tr>
                <tr>
                    <th>PF No</th>
                    <td>'.$data->pf_number.'</td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td>'. \App\Helpers\DateHelpers::dateFormat($data->birth_date) .'</td>
                </tr>
                <tr>
                    <th>PRL Date</th>
                    <td>'. \App\Helpers\DateHelpers::dateFormat($data->prl_date).'</td>
                </tr>
                <tr>
                    <th>Mobile Number</th>
                    <td>'. $data->mobile_number .'</td>
                </tr>
                <tr>
                    <th>Blood Group</th>
                    <td>'. $data->blood->name .'</td>
                </tr>
                <tr>
                    <th>Present Address</th>
                    <td>'.$data->present_address .'</td>
                </tr>
                <tr>
                    <th>Emergency Contact</th>
                    <td>'. $data->emergency_contact .'</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td><img src="uploads/images/'.$data->image.'" style="width: 75px; object-fit: cover" alt=""></td>
                </tr>
                <tr>
                    <th>Signature</th>
                    <td><img src="uploads/signature/'.$data->signature.'" style="width: 75px; object-fit: cover" alt=""></td>
                </tr>
                ';

        $html .='

        <!-- END ITEMS HERE -->
        </table>
            <htmlpagefooter name="myFooter1">
                <div style="border-top: .25px solid #323639;">
                    <table width="100%">
                        <tr>
                            <td width="33%">Date: {DATE j-m-Y} Time: {DATE h:i:sa}</td>
                            <td width="33%" style="text-align: right; ">Print by: '.Auth::user()->name.'</td>
                        </tr>
                    </table>
                </div>
            </htmlpagefooter>
        </body>
        </html>';


        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'nikosh',
            'mode' => 'utf-8',
            'margin_left' => 25,
            'margin_right' => 25,
            'margin_top' => 35,
            'margin_bottom' => 25,
            'margin_header' => 5,
            'margin_footer' => 5,
            'format' => 'A4',
            'orientation' => 'P'
        ]);

        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("National University. - Data file");
        $mpdf->SetAuthor("NU");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText("College Inspection");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

}
