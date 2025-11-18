<?php

namespace Modules\VenueFacility\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\VenueFacility\Http\Models\VenueFacility;
use Modules\VenueFacility\Repositories\Cache\VenueFacilityCacheDecorator;
use Modules\VenueFacility\Repositories\Eloquent\VenueFacilityRepository;
use Modules\VenueFacility\Repositories\Interfaces\VenueFacilityInterface;
//add_new_line_Interface_and_Repository_call
use Modules\VenueFacility\Http\Models\KeyFacility;
use Modules\VenueFacility\Repositories\Eloquent\KeyFacilityRepository;
use Modules\VenueFacility\Repositories\Interfaces\KeyFacilityInterface;
use Modules\VenueFacility\Repositories\Cache\KeyFacilityCacheDecorator;

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(VenueFacilityInterface::class, function () {
            return new VenueFacilityCacheDecorator(
                new VenueFacilityRepository(new VenueFacility)
            );
        });
//add_new_line_Interface_and_Repository_to_hook
        $this->app->bind(KeyFacilityInterface::class, function () {
            return new KeyFacilityCacheDecorator(
                new KeyFacilityRepository(new KeyFacility)
            );
        });

    }
}

