<?php

namespace Modules\Location\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Location\Console\MigrateLocationCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            MigrateLocationCommand::class,
        ]);
    }
}
