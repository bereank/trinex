<?php

namespace App\Actions\ValidationActions;

use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Support\Icons\Heroicon;

class UserNavigationAction
{
    public function __construct() {}

    public function handle(): array
    {

        return [
            NavigationGroup::make('My Databases')
                ->items([
                    NavigationItem::make('Expense')
                        ->icon(Heroicon::OutlinedRectangleStack)
                        ->url('/admin/dashboard')
                        ->label('Expense')
                        ->icon(Heroicon::OutlinedRectangleStack)
                        ->url('/admin/dashboard'),
                    NavigationItem::make('Approvals')
                        ->icon(Heroicon::OutlinedRectangleStack)
                        ->url('/admin/dashboard')
                        ->label('Approvals')
                        ->icon(Heroicon::OutlinedRectangleStack)
                        ->url('/admin/dashboard')
                ])
                ->collapsed(false),
        ];

        $userDatabases = auth()->user()->databases;

        $inventoryNavigation = [];
        foreach ($userDatabases as $key => $value) {

            $userNavifation = NavigationItem::make('Expense')
                ->icon(Heroicon::OutlinedRectangleStack)
                ->url('/admin/dashboard')
                ->label('Expense')
                ->icon(Heroicon::OutlinedRectangleStack)
                ->url('/admin/dashboard');

            array_push($inventoryNavigation, $userNavifation);


            $userNavifation = NavigationItem::make('Expense')
                ->icon(Heroicon::OutlinedRectangleStack)
                ->url('/admin/dashboard')
                ->label('Expense')
                ->icon(Heroicon::OutlinedRectangleStack)
                ->url('/admin/dashboard');

            array_push($inventoryNavigation, $userNavifation);
        }

        return $inventoryNavigation;
    }
}
