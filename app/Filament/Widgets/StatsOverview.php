<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Component;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Categories', \Cache::remember('stats.categories.count', 300, fn() => Category::count()))
                ->description('All categories')
                ->descriptionIcon('heroicon-o-folder')
                ->color('success'),
            Stat::make('Total Components', \Cache::remember('stats.components.count', 300, fn() => Component::count()))
                ->description('All components')
                ->descriptionIcon('heroicon-o-cube')
                ->color('info'),
            Stat::make('Active Components', \Cache::remember('stats.components.active', 300, fn() => Component::where('is_active', true)->count()))
                ->description('Published components')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('primary'),
        ];
    }
}
