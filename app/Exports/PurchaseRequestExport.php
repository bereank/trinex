<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PurchaseRequestExport implements FromCollection, WithHeadings
{
    public $documents;

    public function __construct($documents)
    {
        $this->documents = $documents;
    }

    public function collection()
    {
        return $this->documents->map(function ($doc) {
            return [
                'requester' => $doc->ReqName ?? $doc->requestedby->name ?? 'N/A',
                'total' => number_format($doc->DocTotal, 2),
                'paid_total' => number_format($doc->PaidToDate, 2),
                'date' => $doc->DocDate,
                'remarks' => $doc->Comments,
                'sap_doc_number' => $doc->ExtRefDocNum ?? 'N/A',
                'approval_status' => $this->getApprovalStatus($doc),
                'payment_status' => $doc->PaidToDate > 0 ? 'Paid' : 'Pending'
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Requester',
            'Total',
            'Paid Total',
            'Date',
            'Remarks',
            'SAP Doc #',
            'Approval Status',
            'Payment Status'
        ];
    }

    private function getApprovalStatus($doc)
    {
        if ($doc->CANCELED == 'Y') return 'Cancelled';
        if ($doc->WddStatus == 'N') return 'Rejected';
        if ($doc->WddStatus == 'Y') return 'Approved';
        if ($doc->WddStatus == 'W') return 'Pending';
        return 'Unknown';
    }
}
