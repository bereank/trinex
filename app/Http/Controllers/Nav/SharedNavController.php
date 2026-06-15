<?php

namespace App\Http\Controllers\Nav;

use App\Models\WDD1;
use App\Models\ApprovalLog;
use Illuminate\Support\Arr;
use App\Models\DraftDocument;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseRequestExport;
use BereanK\Integrator\QueryManager\QueryExcuter;
use App\Actions\ReportActions\GetUserPendingRequestsAction;
use App\Livewire\Expense\ExpenseReport;

class SharedNavController extends Controller
{
    public function getDashboard()
    {


        $linkedDatabases = Auth::user()->databases;

        $totalPending = 0;
        $totalRequests = 0;

        foreach ($linkedDatabases as $key => $db) {

            $totalRequests = WDD1::where('USERID', $db->USERID)->distinct()->count() +  $totalRequests;
            $approvalRequests = (new GetUserPendingRequestsAction($db))->handle();
            $totalPending  = count($approvalRequests) + $totalPending;
        }






        return view('pages.dashboard', [
            'totalPending' => $totalPending,
            'totalRequests' => $totalRequests,
            'totalApproved' => ApprovalLog::where('user_id', Auth::user()->id)->where('SyncStatus', '!=', 2)->count(),

        ]);
    }

    public function getApprovalRequest($client_id)
    {
        return view('pages.approvals.index', [
            'client_id' => $client_id,
        ]);
    }

    public function getApprovalReport($client_id)
    {
        return view('pages.approvals.report', [
            'client_id' => $client_id,
        ]);
    }

    public function getApprovalRequestDocumentDraft($client_id, $ObjType, $WddCode, $draftKey)
    {
        return view('pages.approvals.view', [
            'client_id' => $client_id,
            'ObjType' => $ObjType,
            'WddCode' => $WddCode,
            'draftEntry' => $draftKey,
        ]);
    }

    public function getApprovalRequestDocumentAttachment($client_id, $ObjType, $draftKey, $attachmentLine)
    {
        return redirect()->away('http://192.168.12.8:9093/cloud-attachments/' . $client_id . "/" . $ObjType . "/" . $draftKey . "/" . $attachmentLine);
    }

    public function getSystemUsers()
    {
        return view('pages.users.index');
    }

    public function getSettings()
    {
        return view('pages.setting.password-setting');
    }

    public function getSystemUsersEdit($id)
    {
        return view('pages.users.edit', [
            'user_id' => $id,
        ]);
    }

    public function resetSAPPassword()
    {
        return view('pages.setting.sappassword');
    }


    public function getExpense($client_id)
    {

        return view('pages.expense.index', [
            'client_id' => $client_id,
        ]);
    }

    public function getExpenseReport($client_id)
    {

        return view('pages.expense.report', [
            'client_id' => $client_id,
        ]);
    }

    public function getCreateExpense($client_id)
    {
        return view('pages.expense.create', [
            'client_id' => $client_id,
        ]);

        //For KTB Expense Module
        return view('ktb.expense.create', [
            'client_id' => $client_id,
        ]);
    }

    public function getViewExpense($client_id, $expense_id)
    {

        return view('pages.expense.edit', [
            'client_id' => $client_id,
            'expense_id' => $expense_id,
        ]);


        //For KTB Expense Module
        return view('ktb.expense.edit', [
            'client_id' => $client_id,
            'expense_id' => $expense_id,
        ]);
    }

    public function exportExpenseReport($client_id)
    {
        $component = app(ExpenseReport::class);
        $component->mount($client_id);

        // Get filter values from request
        $component->UserSign = request('UserSign');
        $component->fromDocDate = request('fromDocDate');
        $component->toDocDate = request('toDocDate');
        $component->WddStatus = request('WddStatus', '-1');
        $component->PaidToDate = request('PaidToDate', '-1');
        $component->OcrCode3 = request('OcrCode3', '-1');

        $documents = $component->getExportData();

        return Excel::download(
            new PurchaseRequestExport($documents),
            'purchase_requests_' . date('Y-m-d') . '.xlsx'
        );
    }
}
