<?php

namespace App\Http\Controllers;

use App\Models\NuSmartCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = NuSmartCard::query()->paginate(1);;
        return view('nu-smart-card.index', compact('data'));
    }

    public function create()
    {
        return view('nu-smart-card.create');
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $nuSmartCard = NuSmartCard::query()->findOrFail($id);
        return view('nu-smart-card.show',compact('nuSmartCard'));
    }

    public function edit($id)
    {
        $data = NuSmartCard::query()->findOrFail($id);
        return view('nu-smart-card.edit',compact('data'));
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }


    public function getPdfData(){
        $data = NuSmartCard::latest()->get();
        date_default_timezone_set("Asia/Dhaka");
        $html = '
        <!doctype html>
        <meta charset="UTF-8">
        <head>
        <style>
        body {font-family: nikosh;
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
        <span style="font-weight: bold; font-size: 16pt;">জাতীয় বিশ্ববিদ্যালয়</span>
        <br /><span style="font-size:14px;">বাংলাদেশ</span><br /><span style="font-size:14px">কলেজ পরিদর্শন দপ্তর</span> <br/>
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
                    <td>ক্রমিক নং</td>
                    <td width="20%">ফাইল নং</td>
                    <td>ফাইলের নাম</td>
                    <td>বিষয়</td>
                    <td>আসার তারিখ</td>
                    <td>আসার দপ্তর</td>
                    <td width="8%">মার্ক ও তারিখ</td>
                    <td>যাওয়ার দপ্তর</td>
                    <td>যাওয়ার তারিখ</td>
                    <td>আইন উপদেষ্টার কাছে যাওয়ার তারিখ</td>
                    <td>আইন উপদেষ্টার কাছ থেকে আসার তারিখ</td>
                    <td>মন্তব্য</td>
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
            $html .= '<td>'.$row['blood_group'].'</td>';
            $html .= '<td>'.$row['mobile_number'].'</td>';
            $html .= '<td>'.$row['present_address'].'</td>';
            $html .= '<td>'.$row['birth_date'].'</td>';
            $html .= '<td>'.$row['image'].'</td>';
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
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 30,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10,
            'orientation' => 'L'
        ]);

        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("National University. - Data file");
        $mpdf->SetAuthor("NU");
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

}
