<?php

namespace App\Filament\Resources\BookRecommendationResource\Pages;

use App\Filament\Resources\BookRecommendationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookRecommendation extends EditRecord
{
    protected static string $resource = BookRecommendationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
