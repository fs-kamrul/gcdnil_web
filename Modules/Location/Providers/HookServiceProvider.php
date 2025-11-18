<?php

namespace Modules\Location\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
//add_new_line_Interface_and_Repository_call
use Modules\Location\Http\Models\City;
use Modules\Location\Repositories\Eloquent\CityRepository;
use Modules\Location\Repositories\Interfaces\CityInterface;
use Modules\Location\Repositories\Cache\CityCacheDecorator;
use Modules\Location\Http\Models\State;
use Modules\Location\Repositories\Eloquent\StateRepository;
use Modules\Location\Repositories\Interfaces\StateInterface;
use Modules\Location\Repositories\Cache\StateCacheDecorator;
use Modules\Location\Http\Models\Country;
use Modules\Location\Repositories\Eloquent\CountryRepository;
use Modules\Location\Repositories\Interfaces\CountryInterface;
use Modules\Location\Repositories\Cache\CountryCacheDecorator;

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
//add_new_line_Interface_and_Repository_to_hook
        $this->app->bind(CityInterface::class, function () {
            return new CityCacheDecorator(
                new CityRepository(new City)
            );
        });

        $this->app->bind(StateInterface::class, function () {
            return new StateCacheDecorator(
                new StateRepository(new State)
            );
        });

        $this->app->bind(CountryInterface::class, function () {
            return new CountryCacheDecorator(
                new CountryRepository(new Country)
            );
        });

    }
}



