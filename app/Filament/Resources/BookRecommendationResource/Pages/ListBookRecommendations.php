<?php

namespace App\Filament\Resources\BookRecommendationResource\Pages;

use App\Filament\Resources\BookRecommendationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookRecommendations extends ListRecords
{
    protected static string $resource = BookRecommendationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
