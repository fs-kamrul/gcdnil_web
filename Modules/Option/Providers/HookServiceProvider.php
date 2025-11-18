<?php

namespace Modules\Option\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Option\Http\Models\Option;
use Modules\Option\Repositories\Cache\OptionCacheDecorator;
use Modules\Option\Repositories\Eloquent\OptionRepository;
use Modules\Option\Repositories\Interfaces\OptionInterface;
//add_new_line_Interface_and_Repository_call
use Modules\Option\Http\Models\OptionBloodGroup;
use Modules\Option\Repositories\Eloquent\OptionBloodGroupRepository;
use Modules\Option\Repositories\Interfaces\OptionBloodGroupInterface;
use Modules\Option\Repositories\Cache\OptionBloodGroupCacheDecorator;
use Modules\Option\Http\Models\OptionSet;
use Modules\Option\Repositories\Eloquent\OptionSetRepository;
use Modules\Option\Repositories\Interfaces\OptionSetInterface;
use Modules\Option\Repositories\Cache\OptionSetCacheDecorator;
use Modules\Option\Http\Models\OptionSubject;
use Modules\Option\Repositories\Eloquent\OptionSubjectRepository;
use Modules\Option\Repositories\Interfaces\OptionSubjectInterface;
use Modules\Option\Repositories\Cache\OptionSubjectCacheDecorator;
use Modules\Option\Http\Models\OptionGender;
use Modules\Option\Repositories\Eloquent\OptionGenderRepository;
use Modules\Option\Repositories\Interfaces\OptionGenderInterface;
use Modules\Option\Repositories\Cache\OptionGenderCacheDecorator;
use Modules\Option\Http\Models\OptionReligion;
use Modules\Option\Repositories\Eloquent\OptionReligionRepository;
use Modules\Option\Repositories\Interfaces\OptionReligionInterface;
use Modules\Option\Repositories\Cache\OptionReligionCacheDecorator;
use Modules\Option\Http\Models\OptionSection;
use Modules\Option\Repositories\Eloquent\OptionSectionRepository;
use Modules\Option\Repositories\Interfaces\OptionSectionInterface;
use Modules\Option\Repositories\Cache\OptionSectionCacheDecorator;
use Modules\Option\Http\Models\OptionGroup;
use Modules\Option\Repositories\Eloquent\OptionGroupRepository;
use Modules\Option\Repositories\Interfaces\OptionGroupInterface;
use Modules\Option\Repositories\Cache\OptionGroupCacheDecorator;
use Modules\Option\Http\Models\OptionYear;
use Modules\Option\Repositories\Eloquent\OptionYearRepository;
use Modules\Option\Repositories\Interfaces\OptionYearInterface;
use Modules\Option\Repositories\Cache\OptionYearCacheDecorator;
use Modules\Option\Http\Models\OptionClass;
use Modules\Option\Repositories\Eloquent\OptionClassRepository;
use Modules\Option\Repositories\Interfaces\OptionClassInterface;
use Modules\Option\Repositories\Cache\OptionClassCacheDecorator;

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(OptionInterface::class, function () {
            return new OptionCacheDecorator(
                new OptionRepository(new Option)
            );
        });
//add_new_line_Interface_and_Repository_to_hook
        $this->app->bind(OptionBloodGroupInterface::class, function () {
            return new OptionBloodGroupCacheDecorator(
                new OptionBloodGroupRepository(new OptionBloodGroup)
            );
        });

        $this->app->bind(OptionSetInterface::class, function () {
            return new OptionSetCacheDecorator(
                new OptionSetRepository(new OptionSet)
            );
        });

        $this->app->bind(OptionSubjectInterface::class, function () {
            return new OptionSubjectCacheDecorator(
                new OptionSubjectRepository(new OptionSubject)
            );
        });

        $this->app->bind(OptionGenderInterface::class, function () {
            return new OptionGenderCacheDecorator(
                new OptionGenderRepository(new OptionGender)
            );
        });

        $this->app->bind(OptionReligionInterface::class, function () {
            return new OptionReligionCacheDecorator(
                new OptionReligionRepository(new OptionReligion)
            );
        });

        $this->app->bind(OptionSectionInterface::class, function () {
            return new OptionSectionCacheDecorator(
                new OptionSectionRepository(new OptionSection)
            );
        });

        $this->app->bind(OptionGroupInterface::class, function () {
            return new OptionGroupCacheDecorator(
                new OptionGroupRepository(new OptionGroup)
            );
        });

        $this->app->bind(OptionYearInterface::class, function () {
            return new OptionYearCacheDecorator(
                new OptionYearRepository(new OptionYear)
            );
        });

        $this->app->bind(OptionClassInterface::class, function () {
            return new OptionClassCacheDecorator(
                new OptionClassRepository(new OptionClass)
            );
        });

    }
}









