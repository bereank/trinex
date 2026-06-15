<?php

namespace App\Livewire;


use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Models\User;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ApprovalReport extends Component implements HasForms, HasTable
{

    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;


    public $ownerRecord;

    public function mount($ownerRecord)
    {
        $this->ownerRecord = $ownerRecord;
    }

    public function makeFilamentTranslatableContentDriver(): ?\Filament\Support\Contracts\TranslatableContentDriver
    {
        return null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ApprovalRequestLineModel::query()
                    ->with(['approvalrequest', 'approvalstage', 'authorizer'])
                    ->whereHas('approvalrequest', function ($q) {
                        $q->where('DraftEntry', $this->ownerRecord->id);
                    })
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('approvalstage.Name')->searchable(),
                TextColumn::make('authorizer.name')->searchable(),
                TextColumn::make('Status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'N' => 'heroicon-m-x-mark',
                        'Y' => 'heroicon-m-check',
                        'W' => 'heroicon-m-clock',
                    })
                    ->formatStateUsing(fn(string $state): mixed => match ($state) {
                        'N' => 'Rjected',
                        'Y' => 'Approved',
                        'W' => 'Pending',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'N' => 'danger',
                        'Y' => 'success',
                        'W' => 'primary',
                    }),
                TextColumn::make('Remarks')->searchable(),

            ]);
    }
    public function render()
    {
        return view('livewire.approval-report');
    }
}
