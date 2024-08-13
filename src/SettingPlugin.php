<?php

namespace Tenchology\Setting;

use Tenchology\Setting\Filament\Pages\Setting;
use Filament\Panel;
use Filament\Contracts\Plugin;

class SettingPlugin implements Plugin
{
    public function getId(): string
    {
        return 'setting';
    }

    public function register(Panel $panel): void
    {
        $panel->discoverResources(
            in: __DIR__ . '/Filament/Resources',
            for: 'Tenchology\\Setting\\Filament\\Resources'
        );
        $panel->discoverPages(
            in: __DIR__ . '/Filament/Pages',
            for: 'Tenchology\\Setting\\Filament\\Pages'
        );
//        $panel->discoverClusters(
//            in: __DIR__ . '/Filament/Clusters',
//            for: 'Tenchology\\Setting\\Filament\\Clusters'
//        );


    }

    public function boot(Panel $panel): void {}
}
