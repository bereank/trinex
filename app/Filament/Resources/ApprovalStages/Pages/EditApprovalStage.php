<?php

namespace App\Filament\Resources\ApprovalStages\Pages;

use App\Filament\Resources\ApprovalStages\ApprovalStageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditApprovalStage extends EditRecord
{
    protected static string $resource = ApprovalStageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
