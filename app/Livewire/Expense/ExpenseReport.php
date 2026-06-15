<?php

namespace App\Livewire\Expense;

use App\Models\ODRF;
use App\Models\OPRC;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Actions\SAPIntegrationActions\PostDocumentToSAPAction;

class ExpenseReport extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $ObjType = '';

    public $client_id;

    public $approvaldecisionreport = [];

    public $show = [];
    public $vehicles = [];

    public $showSyncStatus = false;

    public $errorSyncing;

    public $draftEntry;



    public $UserSign;
    public $fromDocDate;
    public $toDocDate;
    public $totalRaised;
    public $WddStatus;
    public $PaidToDate;
    public $OcrCode3;

    public function render()
    {


        $this->totalRaised = ODRF::where('client_id', $this->client_id)
            ->where(function ($query) {

                $authUserInfo = Auth::user();


                if ($authUserInfo->UserType == 0) {
                    $query->Where('UserSign', $authUserInfo->id);
                }
            })

            ->count();


        $creators = ODRF::with('createdby', 'requestedby')
            ->where('client_id', $this->client_id)
            ->where(function ($query) {

                $authUserInfo = Auth::user();


                if ($authUserInfo->UserType == 0) {
                    $query->Where('UserSign', $authUserInfo->id);
                }
            })
            ->pluck('UserSign');

        $documnets = ODRF::with('createdby', 'requestedby', 'rows')->orderBy('id', 'desc')
            ->where('client_id', $this->client_id)

            ->isopened()
            ->where(function ($query) {

                if ($this->fromDocDate && !$this->toDocDate) {

                    $query->whereDate('created_at', $this->fromDocDate);
                }

                if ($this->fromDocDate && $this->toDocDate) {

                    $query->whereDate('created_at', '>=', $this->fromDocDate)->whereDate('created_at', '<=', $this->toDocDate);
                }
            })
            ->where(function ($query) {

                $authUserInfo = Auth::user();



                if ($authUserInfo->UserType == 0) {
                    $query->Where('UserSign', $authUserInfo->id);
                }
                if ($authUserInfo->UserType == 1 || $authUserInfo->UserType == 2) {
                    if ($this->UserSign) {
                        $query->Where('UserSign', $this->UserSign);
                    }
                }
            })
            ->where(function ($query) {


                if ($this->WddStatus == '-1') {
                    $this->WddStatus  = null;
                    return;
                }
                if ($this->WddStatus) {

                    $query->Where('WddStatus', $this->WddStatus);
                }
            })

            ->where(function ($query) {


                if (!$this->PaidToDate) {
                    return;
                }
                if ($this->PaidToDate == 1) {

                    $query->Where('PaidToDate', '>', 0);
                }
                if ($this->PaidToDate == 0) {

                    $query->Where('PaidToDate', '<=', 0)->whereNotNull('ExtRef');
                }
            })

            ->where(function ($query) {


                if ($this->OcrCode3 == '-1') {
                    $this->OcrCode3  = null;
                    return;
                }

                if ($this->OcrCode3) {


                    $query->whereHas('rows', function ($q) {
                        Log::info($this->OcrCode3);
                        $q->where('OcrCode5', $this->OcrCode3);
                    });
                }
            })

            ->where('CANCELED', 'N')
            ->paginate(15);


        return view('livewire.expense.expense-report', [
            'documnets' => $documnets,
            'created_users' => User::whereIn('id', $creators)->get(),

        ]);
    }

    public function mount($client_id)
    {

        $this->vehicles = OPRC::where('DimCode', 5)->get();
        $this->client_id = $client_id;
    }

    public function showApprovalStatus($draftEntry)
    {

        $approvaldecisionreport = ApprovalRequestLineModel::with('approvalrequest', 'approvalstage', 'authorizer')
            ->whereHas('approvalrequest', function ($q) use ($draftEntry) {
                $q->where('DraftEntry', $draftEntry);
            })
            ->get();

        foreach ($approvaldecisionreport as $key => $val) {

            $status = 'Pending';

            if ($val['Status'] == 'N') {
                $status = 'Rejected';
            }
            if ($val['Status'] == 'Y') {
                $status = 'Approved';
            }

            $approvaldecisionreport[$key]['StatusNormal'] = $status;
        }

        $this->approvaldecisionreport = $approvaldecisionreport;
        $this->show = true;
    }

    public function doClose()
    {
        $this->show = false;
        $this->showSyncStatus = false;
    }

    public function showErrorStatus($id)
    {

        $this->draftEntry = null;
        $this->draftEntry = $id;
        $document = ODRF::where('id', $id)->first();
        $this->errorSyncing = $document->EDocErrMsg;
        $this->showSyncStatus = true;
    }

    public function intiateDocumentSync()
    {

        try {
            $document = ODRF::where('id', $this->draftEntry)->first();

            $this->doClose();
        } catch (\Throwable $th) {
            Log::info($th);

            $this->DispatchBroswerEventAction('warning', $th->getMessage());
            $this->doClose();

            return;
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertInfo($state, $message)
    {

        $this->dispatch(
            'alert',
            type: $state,
            message: $message
        );
    }

    public function getExportData()
    {
        $query = ODRF::with('createdby', 'requestedby', 'rows')
            ->where('client_id', $this->client_id)
            ->isopened()
            ->where('CANCELED', 'N');

        if ($this->fromDocDate && !$this->toDocDate) {
            $query->whereDate('created_at', $this->fromDocDate);
        }
        if ($this->fromDocDate && $this->toDocDate) {
            $query->whereDate('created_at', '>=', $this->fromDocDate)
                ->whereDate('created_at', '<=', $this->toDocDate);
        }

        $authUserInfo = Auth::user();
        if ($authUserInfo->UserType == 0) {
            $query->where('UserSign', $authUserInfo->id);
        } elseif (($authUserInfo->UserType == 1 || $authUserInfo->UserType == 2) && $this->UserSign) {
            $query->where('UserSign', $this->UserSign);
        }

        // Status filter
        if ($this->WddStatus && $this->WddStatus != '-1') {
            $query->where('WddStatus', $this->WddStatus);
        }

        // Payment filter
        if ($this->PaidToDate == 1) {
            $query->where('PaidToDate', '>', 0);
        } elseif ($this->PaidToDate == 0) {
            $query->where('PaidToDate', '<=', 0)->whereNotNull('ExtRef');
        }

        // Vehicle filter
        if ($this->OcrCode3 && $this->OcrCode3 != '-1') {
            $query->whereHas('rows', function ($q) {
                $q->where('OcrCode5', $this->OcrCode3);
            });
        }

        return $query->orderBy('id', 'desc')->get();

    }
}
