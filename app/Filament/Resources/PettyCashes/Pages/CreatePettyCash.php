<?php

namespace App\Filament\Resources\PettyCashes\Pages;

use App\Actions\ApprovalProccessActions\DetermineApprovalStagesAction;
use App\Actions\PettyCashDocumentAction;
use App\Filament\Resources\PettyCashes\PettyCashResource;
use App\Models\Expense;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreatePettyCash extends CreateRecord
{
    protected static string $resource = PettyCashResource::class;


    protected array $inventoryLines = [];
    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $this->inventoryLines = $data['inventory_lines'] ?? [];
        $data['UserSign'] = auth()->id();
        $data['ReqType'] = 12;
        $data['ObjType'] = 1470000113;
        $data['client_id'] = 1001;
        $data['Branch'] = auth()->user()->branch;
        $data['WddStatus'] = 'W';

        $totalLineTotal = collect($this->inventoryLines)->sum('LineTotal');

        $data['DocTotal'] = $totalLineTotal;
        unset($data['inventory_lines']);

        return $data;
    }


    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {


        DB::beginTransaction();

        try {
            $certification = static::getModel()::create($data);

            if (!empty($this->inventoryLines)) {
                $lines = collect($this->inventoryLines)
                    ->map(function ($line, $index) use ($data) {
                        $line['LineNum'] = $index + 1;
                        $line['ItemDescription'] = Expense::where('AcctCode', $line['AcctCode'])->value('AcctName');
                        $line['RequiredDate'] = $data['DocDate'];
                        return $line;
                    })
                    ->toArray();

                $certification->rows()->createMany($lines);
            }




            (new DetermineApprovalStagesAction($certification))->handle();

            (new PettyCashDocumentAction($certification))->handle();
            DB::commit();

            return $certification;
        } catch (\Throwable $e) {

            Log::info('Error creating inventory: ' . $e);
            DB::rollBack();
            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->warning()
                ->send();

            $this->halt();

            return $certification;
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
