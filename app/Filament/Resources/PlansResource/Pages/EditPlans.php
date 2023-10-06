<?php

namespace App\Filament\Resources\PlansResource\Pages;

use App\Filament\Resources\PlansResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlans extends EditRecord
{
    protected static string $resource = PlansResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
