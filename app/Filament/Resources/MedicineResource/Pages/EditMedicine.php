<?php

namespace App\Filament\Resources\MedicineResource\Pages;

use App\Filament\Resources\MedicineResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditMedicine extends EditRecord
{
    protected static string $resource = MedicineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
