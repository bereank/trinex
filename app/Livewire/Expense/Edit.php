<?php

namespace App\Livewire\Expense;

use Carbon\Carbon;
use App\Models\DRF1;
use App\Models\DRF2;
use App\Models\ODRF;
use App\Models\OPRC;
use App\Models\User;
use App\Models\Expense;
use Livewire\Component;
use App\Models\UserDetail;
use App\Models\ExpenseItem;
use Illuminate\Support\Str;
use App\Actions\GetBranches;
use App\Models\DocAttachment;
use Livewire\WithFileUploads;
use App\Jobs\NotifierApproverJob;
use Illuminate\Support\Facades\DB;
use App\Actions\GetNumberingSeries;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Jobs\NotifierCreatorDocumentRejectedJob;
use App\Models\ApprovalProcess\ApprovalRequestModel;
use BereanK\Integrator\Services\ConfigProviderService;
use App\Actions\ValidationActions\ItemDescriptionAction;
use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Actions\BudgetActions\GetUserCurrentMonthBudgetAction;
use App\Actions\SAPIntegrationActions\CreateDraftDocumentInSAPAction;
use App\Actions\ApprovalProccessActions\DetermineApprovalStagesAction;
use App\Actions\ApprovalProccessActions\DetermineDocumentApprovalStatus;

class Edit extends Component
{
    use WithFileUploads;

    public $bookSettings = [];

    public $requestLines = [];

    public $costCenters = [];

    public $locations = [];

    public $departments = [];

    public $productLines = [];

    public $vehicles = [];

    public $subcontractors = [];

    public $employees = [];

    public $pettyCash = [];

    public $expenses = [];

    public $attachments = [];

    public $attachments2 = [];

    public $attachmentsData = [];

    public $numberSeries = [];

    public $approvaldecisionreport = [];

    public $typeOfPurchases = [];

    public $branches = [];

    public $targetDocuments = [];

    public $users = [];

    public $listOfSelectedApprovers = [];

    public $listOfSelectedApproverId = [];

    public $projects;

    public $client_id;

    public $DocDate;

    public $show;

    public $show1;

    public $Series;

    public $expenseData;

    public $search;

    public $expense_id;

    public $amount;

    public $description;

    public $query;

    public $contacts;

    public $highlightIndex;

    public $PurchaseType;

    public $AcctCode;

    public $DocTotal;

    public $Comments;

    public $U_TypePur;

    public $Branch;

    public $U_targettype;

    public $remarks;

    public $approvalDecision;

    /**
     * Status
     */
    public $showApprovalDecision = false;

    public $syncToSAP = false;

    public $showApprovalActionModal = false;

    public $showRejectionActionModal = false;

    public $showCancellationModal = false;

    public $showEditButton = false;

    public $showAttachmentDeleteButton = false;

    public $showAssignedActionModal = false;

    /**
     * Display Variables
     */
    /**
     * Display Variables
     */
    public $requester;
    public $UserCode;
    public $staff_no;

    public $ReqName;

    public $locationName;

    public $productLineName;

    public $departmentName;

    public $userData;

    public $expensData;

    public $companyName;
    public $CardName;
    public $Address;
    public $newattachment;

    /**
     * Validations
     */
    public function rules()
    {
        return [


            'DocDate' => 'required',
            'ReqName' => 'required',
            'Comments' => 'required|max:254',
            'CardName' => 'required',
            'Address' => 'required',
            'requestLines' => 'required|array|min:1',
            'requestLines.*.amount' => 'required|numeric|min:1',
            'requestLines.*.ItemDescriptionInfo' => 'required|max:100',
            'requestLines.*.AcctCode' => 'required',
            'requestLines.*.Project' => 'required',
            'requestLines.*.OcrCode' => 'required',
            'requestLines.*.OcrCode2' => 'required',
            'requestLines.*.OcrCode3' => 'required',
            'requestLines.*.OcrCode4' => 'required',
            'requestLines.*.OcrCode5' => 'required',
        ];
    }

    /**
     * Validation SMS
     */
    protected $messages = [

        'DocDate' => 'Document Date required',
        'requestLines' => 'Request Lines was required',
        'requestLines.*.amount' => 'Required',
        'requestLines.*.ItemDescriptionInfo' => 'Provide description',
        'requestLines.*.OcrCode' => 'Required',
        'requestLines.*.OcrCode2' => 'Required',
        'requestLines.*.OcrCode3' => 'Required',
        'requestLines.*.AcctCode' => 'Item is required',
        'requestLines.*.OcrCode' => 'Field required',
        'requestLines.*.OcrCode2' => 'Field required',
        'requestLines.*.OcrCode3' => 'Field required',
    ];

    protected $listeners = ['selectDate' => 'getSelectedDate'];

    public function render()
    {


        return view('livewire.expense.edit');
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

    public function getSelectedDate($date)
    {
        $this->DocDate = $date;
    }

    public function addRow()
    {

        $previousData = $this->requestLines[count($this->requestLines) - 1];

        $data = [
            'id' => '',
            'AcctCode' => '',
            'ItemDescription' => '',
            'ItemDescriptionInfo' => '',
            'budget' => 0,
            'amount' => 0,
            'Project' =>  $previousData['Project'],
            'OcrCode' => $previousData['OcrCode'],
            'OcrCode2' => $previousData['OcrCode2'],
            'OcrCode3' => $previousData['OcrCode3'],
            'OcrCode4' => $previousData['OcrCode4'],
            'OcrCode5' => $previousData['OcrCode5'],
            'edited' => false
        ];

        array_push($this->requestLines, $data);
    }

    public function removeLine($index)
    {

        unset($this->requestLines[$index]);
    }



    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->contacts) - 1) {
            $this->highlightIndex = 0;

            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->contacts) - 1;

            return;
        }
        $this->highlightIndex--;
    }



    public function showAttachments()
    {
        if ($this->show1) {
            $this->show1 = false;

            return;
        }

        $this->show1 = true;
    }



    public function updatedRequestlines()
    {

        $this->DocTotal = 0;

        $requestLines = $this->requestLines;
        foreach ($requestLines as $key => $val) {

            if ($val['Project']) {




                $vehicleMasterInfo = OPRC::where('PrcCode', str_replace(' ', '', $val['Project']))->where('DimCode', 7)->first();
                if ($val['Project'] == 'N/A' && !$vehicleMasterInfo) {

                    $requestLines[$key]['OcrCode5'] = 'N/A';
                    $requestLines[$key]['OcrCode4'] = 'Internal';
                }

                Log::info($val['Project']);
                if ($vehicleMasterInfo && !$val['OcrCode5']) {




                    $subContractor = $vehicleMasterInfo->Dim4;


                    $requestLines[$key]['OcrCode5'] = $vehicleMasterInfo->PrcCode;
                    $requestLines[$key]['OcrCode4'] = $subContractor;
                }
            }
            $this->DocTotal = $this->DocTotal + (float) $val['amount'];
        }

        Log::info($requestLines);
        $this->requestLines  =      $requestLines;
    }

    public function mount($client_id, $expense_id)
    {

        $this->expenses = Expense::get();
        $costCenters = OPRC::where('client_id', $client_id)->get();
        $this->productLines = $costCenters->where('DimCode', 1);
        $this->departments = $costCenters->where('DimCode', 2);
        $this->locations = $costCenters->where('DimCode', 3);

        $this->subcontractors = $costCenters->where('DimCode', 4);
        $this->vehicles = $costCenters->where('DimCode', 5);
        $this->projects = $costCenters->where('DimCode', 6);


        $this->showApprovalActionModal = false;
        $this->showRejectionActionModal = false;

        $this->showApprovalStatus($expense_id);
        $this->client_id = $client_id;
        $this->expense_id = $expense_id;

        $expenseData = ODRF::with('rows')->where('id', $expense_id)->first();
        $this->expenseData = $expenseData;


        $requesterDetails = $expenseData->createdby;
        $this->UserCode = $requesterDetails->ExtUserCode;
        $this->ReqName =   $requesterDetails->name;


        $this->attachments = DocAttachment::where('DocEntry', $expense_id)->get();

        foreach ($this->attachments as $key => $attachment) {

            $attachment->url = asset('storage/' . $attachment->FilePath);
        }

        $this->showAttachmentDeleteButton = Auth::user()->id == $this->expenseData->UserSign ? true : false;

        $this->DocDate = $expenseData->DocDate;
        $this->Series = $expenseData->Series;
        $this->PurchaseType = $expenseData->U_PCash;
        $this->U_TypePur = $expenseData->U_TypePur;
        $this->Comments = $expenseData->Comments;
        $this->Branch = $expenseData->Branch;
        $this->Address = $expenseData->Address;
        $this->CardName = $expenseData->CardName;
        $this->DocTotal = (int) $expenseData->DocTotal;

        foreach ($expenseData->rows as $key => $rowData) {




            $data = [
                'id' => $rowData->id,
                'ItemDescription' => $rowData->ItemCode,
                'ItemDescriptionInfo' => $rowData->Dscription,
                'budget' => 0,
                'AcctCode' => $rowData->AcctCode,
                'amount' => $rowData->LineTotal,
                'Project' => $rowData->Project,
                'OcrCode' => $rowData->OcrCode,
                'OcrCode2' => $rowData->OcrCode2,
                'OcrCode3' => $rowData->OcrCode3,
                'OcrCode4' => $rowData->OcrCode4,
                'OcrCode5' => $rowData->OcrCode5,
            ];

            array_push($this->requestLines, $data);
        }




        $this->syncToSAP = $expenseData->ExtRef ? true : false;
    }

    public function showApprovalDecisionModal()
    {

        if ($this->showApprovalDecision) {
            $this->showApprovalDecision = false;

            return;
        }

        $this->showApprovalDecision = true;
    }

    public function showApprovalStatus($draftEntry)
    {

        $approvalRequest = ApprovalRequestModel::where('DraftEntry', $draftEntry)->first();
        if (!$approvalRequest) {
            return;
        }

        $approvaldecisionreport = ApprovalRequestLineModel::with('approvalrequest', 'approvalstage', 'authorizer')
            ->where('WddCode', $approvalRequest->id)
            ->where('StepCode', $approvalRequest->CurrStep)
            ->where('UserID', Auth::user()->id)
            ->where('Status', 'W')
            ->get();

        $this->approvaldecisionreport = $approvaldecisionreport->toArray();
        $this->show = true;
    }

    public function postApprovalDecision($index)
    {

        DB::beginTransaction();
        try {
            $data = $this->approvaldecisionreport[$index];

            $approvalRequestLine = ApprovalRequestLineModel::with('approvalstage')->where('id', $data['id'])->first();

            $approvalRequestLine->update([
                'Remarks' => $data['Remarks'],
                'UpdateDate' => now(),
                'Status' => $data['Status'],
            ]);

            $approvalRequest = ApprovalRequestModel::where('id', $approvalRequestLine->WddCode)->first();

            (new DetermineDocumentApprovalStatus($approvalRequest, $approvalRequestLine))->handle();

            DB::commit();
            Log::info(Auth::user()->name);
            Log::info('Successfully Approved Document Raised On Express Way');
            $this->alertInfo('success', 'Approved successfully');
            NotifierApproverJob::dispatch($this->expenseData);

            return redirect()->route('approvalrequest.index', ['client_id' => $this->client_id]);
        } catch (\Throwable $th) {
            Log::info($th);
            $this->alertInfo('warning', $th->getMessage());

            DB::rollBack();

            return redirect()->route('approvalrequest.index', ['client_id' => $this->client_id]);
        }
    }

    public function closeAllModals(): void
    {
        $this->showApprovalActionModal = false;
        $this->showRejectionActionModal = false;
        $this->showCancellationModal = false;
    }

    public function doApprovalModalShow(): void
    {
        $this->showApprovalActionModal = true;
    }

    public function doShowRejectionModal()
    {
        $this->showRejectionActionModal = true;
    }

    public function doShowCancellationModal()
    {
        $this->showCancellationModal = true;
    }

    public function doAssignedModalShow()
    {
        $this->showAssignedActionModal = true;
    }

    public function updatedNewattachment()
    {

        if (!$this->newattachment) {
            # code...
        }

        $attachment = $this->newattachment;

        $filenameWithExt = $attachment->getClientOriginalName();
        // Get just filename
        $filename = Str::slug(pathinfo($filenameWithExt, PATHINFO_FILENAME));
        // Get just ext
        $extension = $attachment->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename . '.' . $extension;
        // Upload Image
        $path = $attachment->storeAs('expresswayfiles/' .   $this->expenseData->id, $fileNameToStore, 'public');
        DocAttachment::create([
            'DocEntry' =>   $this->expenseData->id,
            'FileExt' => $extension,
            'FileName' => $filename,
            'FilePath' => $path,
        ]);

        $this->alertInfo('success', 'Attachment Added Successfully');
    }
    /**
     * @param int actionType Y=Approve, N=Reject
     */
    public function approveOrRejectDocoment(string $actionType)
    {

        DB::beginTransaction();
        try {
            $data = $this->approvaldecisionreport[0];
            $approvalRequestLine = ApprovalRequestLineModel::with('approvalstage')->where('id', $data['id'])->first();

            $approvalRequestLine->update([
                'Remarks' => $this->remarks ?? 'Approved On: ' . now(),
                'UpdateDate' => now(),
                'Status' => $actionType,
            ]);

            $approvalRequest = ApprovalRequestModel::where('id', $approvalRequestLine->WddCode)->first();

            (new DetermineDocumentApprovalStatus($approvalRequest, $approvalRequestLine))->handle();

            Log::info(Auth::user()->name);
            Log::info('Successfully Approved Document Raised On Express Way');
            DB::commit();
            $this->alertInfo('success', 'Approved successfully');
            NotifierApproverJob::dispatch($this->expenseData);
            NotifierCreatorDocumentRejectedJob::dispatch($this->expenseData);
            return redirect()->route('approvalrequest.index', ['client_id' => $this->client_id]);
        } catch (\Throwable $th) {
            Log::info($th);
            $this->alertInfo('warning', $th->getMessage());

            DB::rollBack();

            return redirect()->route('approvalrequest.index', ['client_id' => $this->client_id]);
        }
    }

    public function cancelDocument()
    {

        if (Auth::user()->id != $this->expenseData->UserSign) {
            $this->alertInfo('warning', 'You dont have permission to cancel the document');

            return;
        }
        DB::beginTransaction();
        try {

            ODRF::where('id', $this->expenseData->id)->update([
                'CANCELED' => 'Y',
            ]);

            $approvalRequest = ApprovalRequestModel::where('DraftEntry', $this->expenseData->id)->first();
            $approvalRequest->update([
                'ProcesStat' => 'C',
            ]);

            DB::commit();
            $this->alertInfo('success', 'Cancelled  successfully');

            return redirect()->route('expense', ['client_id' => $this->client_id]);
        } catch (\Throwable $th) {

            $this->alertInfo('warning', $th->getMessage());
            DB::rollBack();
        }
    }

    public function updateTransaction()
    {

        if (Auth::user()->id != $this->expenseData->UserSign) {
            $this->alertInfo('warning', 'You dont have permission to update the document');
            return;
        }



        $requesterDetails = Auth::user();

        $requester =  $requesterDetails->ExtUserCode;


        if (!$requester) {
            $this->alertInfo('warning', 'Employee details not set');
            return;
        }

        $draftDocument = ODRF::where('id', $this->expenseData->id)->first();
        $this->validate();

        DB::beginTransaction();
        try {

            //Delete Prevuous Records

            $approvalRequestData = ApprovalRequestModel::where('DraftEntry', $draftDocument->id)->first();
            ApprovalRequestLineModel::where('WddCode', $approvalRequestData->id)->delete();
            $approvalRequestData->delete();

            $requestData = $this->requestLines;

            $documentLines = [];
            foreach ($requestData as $key => $line) {

                $line['ItemDescriptionInfo'] = $line['ItemDescriptionInfo'];
                $line['ItemDescription'] = $line['ItemDescriptionInfo'];

                $line['LineTotal'] = $line['amount'];
                $line['VatGroup'] = 'I0';
                $line['RequiredDate'] = $this->DocDate;
                array_push($documentLines, $line);
            }


            $draftDocument->update([
                'DocType' => 'S',
                'ReqType' => 12,
                'Requester' => $requester,
                'ReqName' => $this->ReqName,
                'DocDate' => $this->DocDate,
                'ObjType' => 1470000113,
                'DocTotal' => collect($documentLines)->sum('LineTotal'),
                'Comments' => $this->Comments,
                'client_id' => $this->client_id,
                // 'OwnerCode' => $this->staff_no,
                'Address' => $this->Address,
                'CardName' => $this->CardName,
                'WddStatus' => 'Y',
                'EDocErrMsg' => null,
                'EDocStatus' => 0,
                'UserSign' => Auth::user()->id,
            ]);

            DRF1::where('DocEntry', $draftDocument->id)->delete();
            foreach (collect($documentLines) as $key => $line) {
                (new ItemDescriptionAction($line['ItemDescriptionInfo']))->handle();
                DRF1::create([
                    'DocEntry' => $draftDocument->id,
                    'LineNum' => $key,
                    'AcctCode' => $line['AcctCode'],
                    // 'ItemCode' => $line['ItemDescriptionInfo'],
                    'Dscription' => $line['ItemDescriptionInfo'],
                    'Project' => $line['Project'],
                    'OcrCode' => $line['OcrCode'],
                    'OcrCode2' => $line['OcrCode2'],
                    'OcrCode3' => $line['OcrCode3'],
                    'OcrCode4' => $line['OcrCode4'],
                    'OcrCode5' => $line['OcrCode5'],
                    'LineTotal' => $line['LineTotal'],

                ]);
            }



            (new DetermineApprovalStagesAction($draftDocument))->handle();

            DB::commit();
            $this->alertInfo('success', 'Posted successfully');
            NotifierApproverJob::dispatch($this->expenseData);
            return redirect()->route('expense', ['client_id' => $this->client_id]);
        } catch (\Throwable $th) {

            DB::rollBack();

            $this->alertInfo('warning', $th->getMessage());

            Log::info($th);
        }
    }

    public function updatedSearch()
    {
        $this->users = User::where('name', 'like', '%' . $this->search . '%')->where('Locked', 'N')->take(5)->get();
    }

    public function addToList($userId)
    {

        $user = User::where('id', $userId)->first();

        array_push($this->listOfSelectedApproverId, $userId);
        array_push($this->listOfSelectedApprovers, $user);
    }

    public function removeApproving($index)
    {
        unset($this->listOfSelectedApprovers[$index]);
    }


    public function removeVehicle($index)
    {
        $this->requestLines[$index]['edited'] =  true;
        $this->requestLines[$index]['OcrCode5'] =  '';
    }


    public function removeContractor($index)
    {
        $this->requestLines[$index]['edited'] =  true;
        $this->requestLines[$index]['OcrCode4'] =  '';
    }

    public function removeAttachment($attachmentId)
    {
        if (Auth::user()->id != $this->expenseData->UserSign) {
            $this->alertInfo('warning', 'You do not have permission to delete this attachment.');
            return;
        }

        try {
            $attachment = DocAttachment::find($attachmentId);

            if ($attachment) {
                $fileName = $attachment->FileName;
                
                if (Storage::disk('public')->exists($attachment->FilePath)) {
                    Storage::disk('public')->delete($attachment->FilePath);
                }

                $attachment->delete();

                Log::info("Attachement deleted asuccessfully", [
                    'user_id' => Auth::user()->id,
                    'user_name' => Auth::user()->name,
                    'expense_id' => $this->expense_id,
                    'file_id' => $attachmentId,
                    'file_name' => $fileName
                ]);

                $this->attachments = DocAttachment::where('DocEntry', $this->expense_id)->get();
                foreach ($this->attachments as $item) {
                    $item->url = asset('storage/' . $item->FilePath);
                }

                $this->alertInfo('success', 'Attachment removed successfully');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            $this->alertInfo('warning', 'Error deleting attachment: ' . $th->getMessage());
        }
    }
}
