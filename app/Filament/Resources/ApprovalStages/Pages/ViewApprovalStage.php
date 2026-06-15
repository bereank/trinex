<?php

namespace App\Filament\Resources\ApprovalStages\Pages;

use App\Filament\Resources\ApprovalStages\ApprovalStageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewApprovalStage extends ViewRecord
{
    protected static string $resource = ApprovalStageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
