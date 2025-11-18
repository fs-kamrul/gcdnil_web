<?php

namespace Modules\Language\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Language\Http\Models\Language;
use Modules\Language\Repositories\Eloquent\LanguageRepository;
use Modules\Language\Repositories\Interfaces\LanguageInterface;
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
        $this->app->bind(LanguageInterface::class, function () {
            return new LanguageRepository(new Language);
        });
//add_new_line_Interface_and_Repository_to_hook
    }
}
