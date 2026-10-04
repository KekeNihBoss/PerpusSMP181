<?php

namespace App\Filament\Resources\StrukturPengelolaResource\Pages;

use App\Filament\Resources\StrukturPengelolaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStrukturPengelolas extends ListRecords
{
    protected static string $resource = StrukturPengelolaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
