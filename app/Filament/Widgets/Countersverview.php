<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Orders;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Entities;
use App\Models\User;

class Countersverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Entities', Entities::count()),
            Card::make('Categories', Categories::count()),
            Card::make('Products', Products::count()),
            Card::make('Orders', Orders::count()),
            Card::make('Users', User::count()),
        ];
    }
}
