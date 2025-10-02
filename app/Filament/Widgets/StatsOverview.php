<?php

namespace App\Filament\Widgets;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Prescription;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        return [
            Stat::make('Users', (string) User::count())
                ->description('Total registered users')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make('Pharmacies', (string) Pharmacy::count())
                ->description('Active pharmacies')
                ->descriptionIcon('heroicon-o-building-storefront')
                ->color('success'),

            Stat::make('Medicines', (string) Medicine::count())
                ->description('Total medicines')
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color('info'),

            Stat::make('Prescriptions', (string) Prescription::count())
                ->description('Uploaded prescriptions')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('warning'),
        ];
    }
}
