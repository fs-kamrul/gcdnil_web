<?php

namespace Modules\Admission\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Admission\Http\Models\Admission;
use Modules\Admission\Repositories\Cache\AdmissionCacheDecorator;
use Modules\Admission\Repositories\Eloquent\AdmissionRepository;
use Modules\Admission\Repositories\Interfaces\AdmissionInterface;
//add_new_line_Interface_and_Repository_call
use Modules\Admission\Http\Models\AdmissionMerit;
use Modules\Admission\Repositories\Eloquent\AdmissionMeritRepository;
use Modules\Admission\Repositories\Interfaces\AdmissionMeritInterface;
use Modules\Admission\Repositories\Cache\AdmissionMeritCacheDecorator;
use Modules\Admission\Http\Models\AdmissionMark;
use Modules\Admission\Repositories\Eloquent\AdmissionMarkRepository;
use Modules\Admission\Repositories\Interfaces\AdmissionMarkInterface;
use Modules\Admission\Repositories\Cache\AdmissionMarkCacheDecorator;
use Modules\Admission\Http\Models\AdmissionSubject;
use Modules\Admission\Repositories\Eloquent\AdmissionSubjectRepository;
use Modules\Admission\Repositories\Interfaces\AdmissionSubjectInterface;
use Modules\Admission\Repositories\Cache\AdmissionSubjectCacheDecorator;

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(AdmissionInterface::class, function () {
            return new AdmissionCacheDecorator(
                new AdmissionRepository(new Admission)
            );
        });
//add_new_line_Interface_and_Repository_to_hook
        $this->app->bind(AdmissionMeritInterface::class, function () {
            return new AdmissionMeritCacheDecorator(
                new AdmissionMeritRepository(new AdmissionMerit)
            );
        });

        $this->app->bind(AdmissionMarkInterface::class, function () {
            return new AdmissionMarkCacheDecorator(
                new AdmissionMarkRepository(new AdmissionMark)
            );
        });

        $this->app->bind(AdmissionSubjectInterface::class, function () {
            return new AdmissionSubjectCacheDecorator(
                new AdmissionSubjectRepository(new AdmissionSubject)
            );
        });

        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 301);
    }

    public function addSettings(?string $data = null): string
    {
        return $data . view('admission::setting')->render();
    }
}



