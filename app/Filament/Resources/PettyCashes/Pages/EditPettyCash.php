<?php

namespace App\Filament\Resources\PettyCashes\Pages;

use App\Actions\ApprovalProccessActions\DetermineApprovalStagesAction;
use App\Filament\Resources\PettyCashes\PettyCashResource;
use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Models\ApprovalProcess\ApprovalRequestModel;
use App\Models\DRF1;
use App\Models\Expense;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditPettyCash extends EditRecord
{
    protected static string $resource = PettyCashResource::class;


    protected array $inventoryLines = [];
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),

        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {

        $this->inventoryLines = $data['inventory_lines'] ?? [];
        $data['UserSign'] = auth()->id();
        $data['ReqType'] = 12;
        $data['Branch'] = auth()->user()->branch;
        $data['ObjType'] = 1470000113;
        $data['WddStatus'] = 'W';

        $totalLineTotal = collect($this->inventoryLines)->sum('LineTotal');

        $data['DocTotal'] = $totalLineTotal;
        unset($data['inventory_lines']);

        return $data;
    }


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        DB::beginTransaction();

        try {




            // Update main record
            $record->update($data);
            $approvalRequestData = ApprovalRequestModel::where('DraftEntry', $record->id)->first();

            if ($approvalRequestData) {
                ApprovalRequestLineModel::where('WddCode', $approvalRequestData?->id)->delete();
                $approvalRequestData->delete();
            }



            DRF1::where('DocEntry', $record->id)->delete();

            if (!empty($this->inventoryLines)) {
                $lines = collect($this->inventoryLines)
                    ->map(function ($line, $index) use ($data) {
                        $line['LineNum'] = $index + 1;
                        $line['ItemDescription'] = Expense::where('AcctCode', $line['AcctCode'])->value('AcctName');
                        $line['RequiredDate'] = $data['DocDate'];
                        return $line;
                    })
                    ->toArray();

                $record->rows()->createMany($lines);
            }

            (new DetermineApprovalStagesAction($record))->handle();
            DB::commit();


            return $record;
        } catch (\Throwable $e) {


            Log::info($e);
            DB::rollBack();

            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->warning()
                ->send();

            $this->halt();

            return $record;
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {

        $data['inventory_lines'] = $this->record
            ->rows()
            ->get([
                'AcctCode',
                'Dscription',
                'LineTotal',
            ])
            ->toArray();

        return $data;
    }
}
