<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Add this to your existing boot() method
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            fn (): string => view('filament.popup-script')->render(),
        );
    }
}
