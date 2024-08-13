<?php

namespace Tenchology\Setting\Providers;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;
use Tenchology\Setting\SettingPlugin;

class SettingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(fn (Panel $panel) => ($panel->getId() !== 'admin') || $panel->plugin(new SettingPlugin()));

        $this->mergeConfigFrom(__DIR__ . '/../../config/settings_fields.php', 'settings_fields');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/settings_fields.php' => config_path('settings_fields.php'),
        ], 'settings-config');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'settings');
    }
}
