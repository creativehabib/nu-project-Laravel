<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSmartCardRequest;
use App\Http\Requests\updateSmartCardRequest;
use App\Models\BloodGroup;
use App\Models\NuSmartCard;
use App\Models\Department;
use App\Models\Designation;
use App\Helpers\DateHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = NuSmartCard::query()->orderBy('order_position', 'asc');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('pf_number', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(5)->withQueryString();

        return view('nu-smart-card.index', compact('data'));
    }

    public function create()
    {
        $bloods = BloodGroup::all();
        $departments = Department::all();
        $designations = Designation::all();
        return view('nu-smart-card.create', compact('bloods','departments','designations'));
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
            logger($th);
            return response()->json(['success' => false, 'error' => $th->getMessage()], 500);
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
        $departments = Department::all();
        $designations = Designation::all();
        $data = NuSmartCard::query()->findOrFail($id);
        return view('nu-smart-card.edit',compact('data','bloods','departments','designations'));
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
            logger($throwable);
            return response()->json(['success' => false,'error'=> $throwable->getMessage()], 500);
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

    public function liveSearch(Request $request): JsonResponse
    {
        $term = $request->get('q');
        $results = NuSmartCard::with('designation')
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('pf_number', 'like', "%{$term}%");
            })
            ->orderBy('order_position', 'asc')
            ->get();

        $html = view('nu-smart-card.partials.table-rows', ['data' => $results])->render();

        return response()->json(['html' => $html]);
    }

    public function exportWord(): BinaryFileResponse
    {
        $data = NuSmartCard::with(['designation', 'department', 'blood'])->orderBy('order_position', 'asc')->get();

        $cell = fn(?string $value): string => '<w:tc><w:p><w:r><w:t>' . htmlspecialchars($value ?? '') . '</w:t></w:r></w:p></w:tc>';

        $rowsXml = '';
        $relsXmlEntries = '';
        $imageFiles = [];
        $contentTypeImages = [];
        $imageCounter = 1;
        $docPrId = 1;

        foreach ($data as $index => $row) {
            $rowsXml .= '<w:tr>';
            $rowsXml .= $cell((string)($index + 1));
            $rowsXml .= $cell($row->name);
            $rowsXml .= $cell($row->designation?->name ?? '');
            $rowsXml .= $cell($row->department?->name ?? '');
            $rowsXml .= $cell($row->pf_number);
            $rowsXml .= $cell($row->id_card_number);
            $rowsXml .= $cell(DateHelpers::dateFormat($row->prl_date, 'd/m/Y'));
            $rowsXml .= $cell($row->blood?->name ?? '');
            $rowsXml .= $cell($row->mobile_number);
            $rowsXml .= $cell($row->present_address);
            $rowsXml .= $cell($row->emergency_contact);

            $imageFields = [
                ['file' => $row->image, 'path' => NuSmartCard::IMAGE_UPLOAD_PATH],
                ['file' => $row->signature, 'path' => NuSmartCard::SIGNATURE_UPLOAD_PATH],
            ];

            foreach ($imageFields as $field) {
                $filePath = $field['file'] ? public_path($field['path'] . $field['file']) : null;
                if ($filePath && file_exists($filePath)) {
                    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    $contentTypeImages[$ext] = $ext === 'png' ? 'image/png' : 'image/jpeg';
                    $relId = 'rId' . $imageCounter;
                    $imageName = 'image' . $imageCounter . '.' . $ext;
                    $relsXmlEntries .= '<Relationship Id="' . $relId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/' . $imageName . '"/>';
                    $imageFiles[] = ['path' => $filePath, 'name' => 'word/media/' . $imageName];

                    $size = 714375; // 75px in EMUs
                    $rowsXml .= '<w:tc><w:p><w:r><w:drawing><wp:inline distT="0" distB="0" distL="0" distR="0"><wp:extent cx="' . $size . '" cy="' . $size . '"/><wp:effectExtent l="0" t="0" r="0" b="0"/><wp:docPr id="' . $docPrId . '" name="Image' . $imageCounter . '"/><wp:cNvGraphicFramePr/><a:graphic xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"><a:graphicData uri="http://schemas.openxmlformats.org/drawingml/2006/picture"><pic:pic xmlns:pic="http://schemas.openxmlformats.org/drawingml/2006/picture"><pic:nvPicPr><pic:cNvPr id="0" name="Image"/><pic:cNvPicPr/></pic:nvPicPr><pic:blipFill><a:blip r:embed="' . $relId . '"/><a:stretch><a:fillRect/></a:stretch></pic:blipFill><pic:spPr><a:xfrm><a:off x="0" y="0"/><a:ext cx="' . $size . '" cy="' . $size . '"/></a:xfrm><a:prstGeom prst="rect"><a:avLst/></a:prstGeom></pic:spPr></pic:pic></a:graphicData></a:graphic></wp:inline></w:drawing></w:r></w:p></w:tc>';
                    $imageCounter++;
                    $docPrId++;
                } else {
                    $rowsXml .= '<w:tc/>';
                }
            }

            $rowsXml .= '</w:tr>';
        }

        $documentXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"'
            .' xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"'
            .' xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"'
            .' xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"'
            .' xmlns:pic="http://schemas.openxmlformats.org/drawingml/2006/picture">'
            .'<w:body>'
            .'<w:tbl>'
            .'<w:tr>'
            .'<w:tc><w:p><w:r><w:t>No</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>Name</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>Designation</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>Department</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>PF No</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>ID Card No</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>PRL Date</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>Blood Group</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>Mobile No</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>Present Address</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>Emergency No</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>Image</w:t></w:r></w:p></w:tc>'
            .'<w:tc><w:p><w:r><w:t>Signature</w:t></w:r></w:p></w:tc>'
            .'</w:tr>'
            .$rowsXml
            .'</w:tbl>'
            .'<w:sectPr><w:pgSz w:w="12240" w:h="15840"/><w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440"/></w:sectPr>'
            .'</w:body>'
            .'</w:document>';

        $contentTypesXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            .'<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            .'<Default Extension="xml" ContentType="application/xml"/>';
        foreach ($contentTypeImages as $ext => $type) {
            $contentTypesXml .= '<Default Extension="' . $ext . '" ContentType="' . $type . '"/>';
        }
        $contentTypesXml .= '<Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>'
            .'</Types>';

        $relsXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml" Id="R1"/>'
            .'</Relationships>';

        $documentRelsXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .$relsXmlEntries
            .'</Relationships>';

        $fileName = tempnam(sys_get_temp_dir(), 'docx');
        $zip = new \ZipArchive();
        $zip->open($fileName, \ZipArchive::CREATE);
        $zip->addFromString('[Content_Types].xml', $contentTypesXml);
        $zip->addFromString('_rels/.rels', $relsXml);
        $zip->addFromString('word/document.xml', $documentXml);
        $zip->addFromString('word/_rels/document.xml.rels', $documentRelsXml);
        foreach ($imageFiles as $img) {
            // Use addFromString to ensure the image binary is properly added to the archive
            if (is_readable($img['path'])) {
                $zip->addFromString($img['name'], file_get_contents($img['path']));
            }
        }
        $zip->close();

        return response()->download($fileName, 'smart-cards.docx')->deleteFileAfterSend(true);
    }


    public function getPdfData(){
        $data = NuSmartCard::query()->with('blood')->orderBy('order_position','asc')->get();
        date_default_timezone_set("Asia/Dhaka");
        $html = '
        <!doctype html>
        <meta charset="UTF-8">
        <head>
        <style>
        body {
            font-size: 10pt;
            color: #191e23;
        }
        p {	margin: 0; }
        table.items {
            border: 0.1mm solid #323639;
        }
        td, th { align-items: center; }
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
                    <td>Designation</td>
                    <td>Department</td>
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
            $html .= '<td>'.($row->designation->name ?? '').'</td>';
            $html .= '<td>'.($row->department->name ?? '').'</td>';
            $html .= '<td>'.$row['pf_number'].'</td>';
            $html .= '<td>'. \App\Helpers\DateHelpers::dateFormat($row['prl_date'], 'd/m/Y').'</td>';
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
        $mpdf->SetTitle("National University. - Nu Smart Card Staff List");
        $mpdf->SetAuthor("NU");
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);

        $mpdf->Output(Str::random(16).'.pdf', 'D');
    }

    // single pdf
    public function getSinglePdfData($id)
    {
        // get single data
        $data = NuSmartCard::query()->with(['blood', 'department', 'designation'])->findOrFail($id);
        date_default_timezone_set("Asia/Dhaka");
        $html = '
        <!doctype html>
        <meta charset="UTF-8">
        <head>
        <style>
        body {
            font-family: sans-serif,nikosh;
            font-size: 10pt;
            color: #1a1e25;
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
                    <th>Designation</th>
                    <td>'.($data->designation->name ?? '').'</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>'.($data->department->name ?? '').'</td>
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
                    <td>'.  \App\Helpers\DateHelpers::dateFormat($data->prl_date, 'd/m/Y').'</td>
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
            'mode' => 'utf-8',
            'margin_left' => 25,
            'margin_right' => 25,
            'margin_top' => 45,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 5,
            'format' => 'A4',
            'orientation' => 'P'
        ]);

        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle($data->name. ' - '."National University");
        $mpdf->SetAuthor("NU");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText("College Inspection");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->WriteHTML($html);
        ob_clean();
        flush();
        $mpdf->Output(Str::slug($data->name).'.pdf','I');
    }

}
