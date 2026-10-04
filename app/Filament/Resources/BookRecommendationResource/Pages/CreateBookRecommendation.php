<?php

namespace App\Filament\Resources\BookRecommendationResource\Pages;

use App\Filament\Resources\BookRecommendationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookRecommendation extends CreateRecord
{
    protected static string $resource = BookRecommendationResource::class;
}
