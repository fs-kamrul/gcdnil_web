<?php

namespace Modules\AwesomeIcon\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\AwesomeIcon\Http\Models\AwesomeIcon;
use Modules\AwesomeIcon\Repositories\Cache\AwesomeIconCacheDecorator;
use Modules\AwesomeIcon\Repositories\Eloquent\AwesomeIconRepository;
use Modules\AwesomeIcon\Repositories\Interfaces\AwesomeIconInterface;
//add_new_line_Interface_and_Repository_call

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(AwesomeIconInterface::class, function () {
            return new AwesomeIconCacheDecorator(
                new AwesomeIconRepository(new AwesomeIcon)
            );
        });
//add_new_line_Interface_and_Repository_to_hook
    }
}
