<?php

namespace App\Filament\Resources\ApprovalStages\Pages;

use App\Filament\Resources\ApprovalStages\ApprovalStageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApprovalStages extends ListRecords
{
    protected static string $resource = ApprovalStageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
