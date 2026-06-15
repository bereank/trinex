<?php

namespace App\Actions\ValidationActions;

use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Support\Icons\Heroicon;

class UserNavigationGroupAction
{
    public function __construct() {}

    public function handle(): array
    {


        $userDatabases = auth()->user()->databases;

        $inventoryNavigation = [];
        foreach ($userDatabases as $key => $value) {

            $userNavifation = NavigationItem::make($value->db_details->db_name)
                ->icon(Heroicon::OutlinedRectangleStack)
                ->url('/admin/dashboard')
                ->label($value->db_details->db_name)
                ->icon(Heroicon::OutlinedRectangleStack)
                ->url('/admin/dashboard');

            array_push($inventoryNavigation, $userNavifation);
        }

        return $inventoryNavigation;
    }
}
