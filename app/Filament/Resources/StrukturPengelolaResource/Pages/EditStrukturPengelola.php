<?php

namespace App\Filament\Resources\StrukturPengelolaResource\Pages;

use App\Filament\Resources\StrukturPengelolaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStrukturPengelola extends EditRecord
{
    protected static string $resource = StrukturPengelolaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
