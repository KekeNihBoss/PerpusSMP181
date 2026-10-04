<?php

namespace App\Filament\Resources\TataTertibResource\Pages;

use App\Filament\Resources\TataTertibResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTataTertib extends EditRecord
{
    protected static string $resource = TataTertibResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
