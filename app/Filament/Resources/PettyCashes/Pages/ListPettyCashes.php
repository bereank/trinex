<?php

namespace App\Filament\Resources\PettyCashes\Pages;


use App\Filament\Resources\PettyCashes\PettyCashResource;
use App\Filament\Resources\PettyCashes\Widgets\PurchaseRequestStatOverView;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListPettyCashes extends ListRecords
{

    use ExposesTableToWidgets;
    protected static string $resource = PettyCashResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PurchaseRequestStatOverView::class
        ];
    }
}
