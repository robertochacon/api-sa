<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\User;

class UsersChart extends BarChartWidget
{
    protected static ?string $heading = 'Users';

    protected function getData(): array
    {
        $data = Trend::model(User::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();
 
        return [
            'datasets' => [
                [
                    'label' => 'Users registered',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#1ABC9C',
                    'borderColor' => '#1ABC9C',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
