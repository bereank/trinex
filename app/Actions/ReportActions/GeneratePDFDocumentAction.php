<?php

namespace App\Actions\ReportActions;

use PDF;
use Carbon\Carbon;
use App\Models\ODRF;
use App\Models\OWDD;
use App\Models\User;
use App\Models\WDD1;
use App\Models\ApprovalLog;
use Illuminate\Support\Str;
use App\Models\UserDatabase;
use App\Models\DraftDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Actions\ApprovalProccessActions\GetDocumentApproversAction;


class GeneratePDFDocumentAction
{

    public function __construct(protected int $documentID)
    {
        $this->documentID= $documentID;
      
    }

    public function handle()
    {

        
        $draftDocument = ODRF::with('createdby', 'requestedby', 'rows')->where('id', $this->documentID)->first();

  
        
        if ($draftDocument->WddStatus == 'W') {
            return 'Document Not Approved';
        }
        if ($draftDocument->WddStatus == 'C') {
            return 'Document Cancelled';
        }

        $staffNo = null;
        $staffNo = $draftDocument->Requester;
       

     

        $approvalDecisions = (new GetDocumentApproversAction($draftDocument))->handle();

        //Format Data
        $documentDate = Carbon::createFromFormat('Y-m-d', $draftDocument->DocDate)->format('d.m.Y');
        $defaultFontSize = 9;
        $defaultFontType = 'helvetica';
        $defaultUnderLineWidth = 85;
        $defaultUnderLineStyle = ['width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => [70, 130, 180]];

        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // $pdf::SetMargins(5, 5, 5);
        $pdf::SetPrintHeader(false);
        $pdf::SetPrintFooter(true);
        $pdf::setTitle('Expense Request Printing');

        $pdf::setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf::setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

        $ext = public_path('img/cglogo.png');

        //FUNCTION TO PRINT PAGES NUMBERS
        PDF::setFooterCallback(function ($pdf) use ($draftDocument) {

            // Position at 15 mm from bottom
            $pdf->SetY(-10);
            // Set font
            $pdf->SetFont('helvetica', 'IB', 4);
            // Page number
            $pdf->Cell(0, 10, Crypt::encryptString($draftDocument->id.':'.$draftDocument->createdby->name), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            $pdf->SetFont('helvetica', 'IB', 6);
            $pdf->SetY(-15);
            $pdf->Cell(0, 10, '  Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            $pdf->SetY(-15);
            $pdf->SetFont('helvetica', 'IB', 7);
            $pdf->Cell(0, 0, 'Generated via SAP Express Way on: '.now().'  by  '.'Automated', 0, 0, 'L', 0, '', 0);

        });
        $pdf::AddPage();
        $pdf::Image($ext, 90, 5, 30, 20);

      
        $documentPrintingStatus = $draftDocument->Printed == 'N' ? "Original" : "Copy";
       
        $documentPrintingStatus = "Original";
        //set auto page breaks
        // set default monospaced font
        $pdf::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf::SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf::SetFont($defaultFontType, 'B', 12);
        $pdf::Write(0, $documentPrintingStatus.'        '.$draftDocument->U_PCash, '', 0, 'R', true, 0, false, false, 0);
        $pdf::MultiCell('', 0, '----------------------------------', 0, 'R', 0, 1, 150, 13, true);

   
        /**
         * -----------------------------------
         *      REQUESTER AND DOCUMENT DETAILS
         * ----------------------------------
         */
        $requesterDetailsXMeasurement = 40;

        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'Express .Doc No.', 0, 'L', 0, 1, '', 8, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(55, 5, $draftDocument->id, 0, 1, 0, 1, $requesterDetailsXMeasurement, 8, true);

        $pdf::Line(11, 13, 80, 13, $defaultUnderLineStyle);

        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'SAP Doc No.', 0, 'L', 0, 1, '', 13, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(55, 5,$draftDocument->ExtRefDocNum, 0, 1, 0, 1, $requesterDetailsXMeasurement, 13, true);

        $pdf::Line(11, 18, 80, 18, $defaultUnderLineStyle);

        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'Doc Date', 0, 'L', 0, 1, '', 18, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(55, 5, $documentDate, 0, 1, 0, 1, $requesterDetailsXMeasurement, 18, true);
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);

        $pdf::Line(11, 23, 80, 23, $defaultUnderLineStyle);

        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'Staff No', 0, 'L', 0, 1, '', 25, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(55, 5, $staffNo, 0, 1, 0, 1, $requesterDetailsXMeasurement, 25, true);
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::Line(11, 30, 80, 30, $defaultUnderLineStyle);

        $pdf::MultiCell(55, 5, 'Requester Name', 0, 1, 0, 1, '', 30, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(55, 5, ucwords(Str::lower($draftDocument->ReqName ?? $draftDocument->requestedby->name)), 0, 1, 0, 1, $requesterDetailsXMeasurement, 30, true);
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::Line(11, 35, 80, 35, $defaultUnderLineStyle);

        $pdf::MultiCell(55, 5, 'Email', 0, 1, 0, 1, '', 35, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(55, 5, ucwords(Str::lower($draftDocument->requestedby?->email)), 0, 1, 0, 1, $requesterDetailsXMeasurement, 35, true);
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::Line(11, 40, 80, 40, $defaultUnderLineStyle);

        $pdf::MultiCell(55, 5, 'Personel Name', 0, 1, 0, 1, '', 40, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(100, 5, ucwords(Str::lower($draftDocument->CardName)), 0, 1, 0, 1, $requesterDetailsXMeasurement, 40, true);
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::Line(11, 40, 80, 40, $defaultUnderLineStyle);

        $pdf::MultiCell(55, 5, 'Telephone #', 0, 1, 0, 1, '', 45, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(100, 5, ucwords(Str::lower($draftDocument->Address)), 0, 1, 0, 1, $requesterDetailsXMeasurement, 45, true);
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::Line(11, 40, 80, 40, $defaultUnderLineStyle);

        $pdf::writeHTMLCell(0, 0, '', 45, '<hr>', '', 0, 0, true, '', true);

        //Lines Currency
        $pdf::SetFont('times', '', 9);
        $pdf::SetFont('times', 'B', 9);

        $pdf::MultiCell('', 0, 'Currency : KES', 0, 'R', 0, 1, 150, 46, true);

        //Items

        $html =
            '<table cellspacing="0" cellpadding="1" border="0.1" >
    <thead>
   <tr style=" font-weight: bold;">
    <th width="30">#</th>
    <th width="160">Decription</th>

    <th width="70">Project</th>
    <th width="70">Truck</th>
    <th width="80" align="right">Amount</th>
    <th width="130" align="right">Total</th>
    </tr>
    </thead>
 <tbody>';

        $i = 1;
        foreach ($draftDocument->rows as $key => $draftLine) {
            $total = number_format($draftLine->LineTotal, 2);
            $html .= '<tr>';
            $html .= '<td width="30">'.$i.'</td>';
            $html .= '<td width="160">'.$draftLine->Dscription.'</td>';
            $html .= '<td width="70">'.$draftLine->Project.'</td>';
            $html .= '<td width="70">'.$draftLine->OcrCode5.'</td>';
            $html .= '<td width="80" align="right">'.$total.'</td>';
            $html .= '<td width="130" align="right">'.$total.'</td>';
            $html .= '</tr>';

            $i++;
        }

        $html .=
            '</tbody>
      </table>';

        $pdf::Ln();
        $pdf::Ln();
        $pdf::SetFont('helvetica', '', 9);
        $currentY = $pdf::getY();

        $pdf::writeHTML($html, true, false, false, false, '');

        //Sub Total
        $currentY = $pdf::getY();
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'Request Subtotal:', 0, 'L', 0, 1, 120, $currentY, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'KES '.number_format($draftDocument->DocTotal, 2), 0, 'R', 0, 1, 146, $currentY, true);
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);

        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'Total Before Tax:', 0, 'L', 0, 1, 120, $currentY + 5, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'KES '.number_format($draftDocument->DocTotal, 2), 0, 'R', 0, 1, 146, $currentY + 5, true);
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);

        $pdf::SetFont($defaultFontType, '', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'Total Tax Amount:', 0, 'L', 0, 1, 120, $currentY + 10, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'KES '.number_format(0, 2), 0, 'R', 0, 1, 146, $currentY + 10, true);
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);

        $pdf::SetFont('times', 'b', 11);
        $pdf::MultiCell(55, 5, 'Total Amount:', 0, 'L', 0, 1, 120, $currentY + 15, true);
        $pdf::SetFont($defaultFontType, 'B', $defaultFontSize);
        $pdf::MultiCell(55, 5, 'KES '.number_format(round($draftDocument->DocTotal), 2), 0, 'R', 0, 1, 146, $currentY + 15, true);
        $pdf::SetFont($defaultFontType, '', $defaultFontSize);

        $pdf::Ln();
        $pdf::Write(0, $draftDocument->Comments, '', 0, 'L', true, 0, false, false, 0);
        $pdf::Ln();
        $pdf::Write(0, 'Requst Valid Date: '.$documentDate, '', 0, 'L', true, 0, false, false, 0);

        $pdf::writeHTMLCell(0, 0, '', $pdf::getY() + 2, '<hr>', '', 0, 0, true, '', true);
        $currentY = $pdf::getY();
        $pdf::SetFont($defaultFontType, 'B', 10);
        $pdf::MultiCell(55, 5, 'Prepared By:', 0, '', 0, 1, '', $currentY + 15, true);
        $pdf::MultiCell(55, 5, $draftDocument->createdby->name, 0, '', 0, 1, $requesterDetailsXMeasurement, $currentY + 15, true);

        $pdf::MultiCell(55, 5, 'Date:', 0, '', 0, 1, $requesterDetailsXMeasurement + 40, $currentY + 15, true);
        $pdf::MultiCell(55, 5, date('d-m-Y', strtotime($draftDocument->created_at)), 0, '', 0, 1, $requesterDetailsXMeasurement + 50, $currentY + 15, true);

        $pdf::MultiCell(55, 5, 'Signature:', 0, '', 0, 1, $requesterDetailsXMeasurement + 75, $currentY + 15, true);
        $pdf::MultiCell(55, 5, '', 0, '', 0, 1, $requesterDetailsXMeasurement + 90, $currentY + 15, true);
        

        //Creator Signature

      
    
        $extSigner = public_path('storage/'.$draftDocument->createdby->user_signature);
        
        $pdf::Image(     $extSigner, $requesterDetailsXMeasurement + 100, $currentY + 15, 25, 15);
     
        foreach ($approvalDecisions as $key => $approvalDecision) {

            $approverNames = explode(' ', $approvalDecision->authorizer->name, 3);
            $currentY = $pdf::getY();
            $pdf::SetFont($defaultFontType, 'B', 10);
            $pdf::MultiCell(55, 5, 'Approved By :', 0, '', 0, 1, '', $currentY + 15, true);
            $pdf::MultiCell(55, 5, $approverNames[0].' '.$approverNames[1], 0, '', 0, 1, $requesterDetailsXMeasurement, $currentY + 15, true);

            $pdf::MultiCell(55, 5, 'Date:', 0, '', 0, 1, $requesterDetailsXMeasurement + 40, $currentY + 15, true);
            $pdf::MultiCell(55, 5, date('d-m-Y', strtotime($approvalDecision->UpdateDate)), 0, '', 0, 1, $requesterDetailsXMeasurement + 50, $currentY + 15, true);

            $pdf::MultiCell(55, 5, 'Signature:', 0, '', 0, 1, $requesterDetailsXMeasurement + 75, $currentY + 15, true);
            $pdf::MultiCell(55, 5, '', 0, '', 0, 1, $requesterDetailsXMeasurement + 90, $currentY + 15, true);


            $extApprover = public_path('storage/'.$approvalDecision->authorizer->user_signature);
        

      
            $pdf::Image( $extApprover, $requesterDetailsXMeasurement + 100, $currentY + 10, 25, 15);

        }

     

            // if ($draftDocument == 'N') {
            //     (new UpdateSAPDocPrintingStatusAction($draftDocument))->handle();
            // }

            $draftDocument->update([
                'Printed' => 'Y',
            ]);

            $filename = $draftDocument->ExtRefDocNum.'.pdf';



        

            $pdfPath = storage_path('app/'.$filename);
    
          
            $pdf::output($pdfPath, 'F');
     
   

            return $pdf;
      

    }
}
