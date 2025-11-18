@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')

@endsection
@section('javascript')

@endsection

@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('kamruldashboard::lang.kamruldashboard')</h4>
           </div>
            <div class="card-body">
                <h1>Hello @lang('kamruldashboard::lang.kamruldashboard')</h1>
                <code>
                    <b>#Requirements</b> <br/>
                    //1. composer require apphostbd/laravel-fpdf <br/>
                    2. composer require laravel/ui <br/>
                    3. composer require composer/semver <br/>
                    4. composer require yajra/laravel-datatables-oracle <br/>
                    4.1. composer require yajra/laravel-datatables-buttons:^4 <br/>
                    4.2. composer require yajra/laravel-datatables-html:^4 <br/>
                    4.3. composer require kris/laravel-form-builder <br/>
                    4.4. composer require xantios/mimey <br/>
                    4.5. composer require "twig/twig:^3.0" <br/>
                    4.6. composer require barryvdh/laravel-dompdf <br/>
                    4.7. composer require khaled.alshamaa/ar-php <br/>
                    4.8. composer require tightenco/ziggy <br/>
                    4.9. composer require laravel/socialite <br/>
                    4.9. composer require google/analytics-data <br/>
                    4.10. composer require barryvdh/laravel-snappy <br/>
                    4.10. composer require mpdf/mpdf <br/>
                    <br/>
                    5. composer require intervention/image <br/>
                    6. composer require spatie/laravel-backup <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider" <br/>
                    6. composer require maatwebsite/excel <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config <br/>
                    7. composer require nwidart/laravel-menus <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; php artisan vendor:publish --provider="Nwidart\Menus\MenusServiceProvider" <br/>
                    8. composer require nwidart/laravel-modules <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" <br/>
                    9. composer require ezyang/htmlpurifier v4.13 <br/>
                    10.composer require mews/purifier <br/>
                    11.composer require google/apiclient-services <br/>
                    12.composer require google/apiclient <br/>
                    13.composer require google/recaptcha <br/>
                    14. composer require kris/laravel-form-builder <br/>
                    15.composer require symfony/cache <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; composer.json file add this. <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; "autoload": { <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "psr-4": { <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "App\\": "app/", <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>"Modules\\": "Modules/",</b> <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "Database\\Factories\\": "database/factories/", <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "Database\\Seeders\\": "database/seeders/" <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; } <br/>

                    &nbsp;&nbsp;&nbsp;&nbsp; } <br/>
                    //__. php artisan vendor:publish --provider="Modules\KamrulDashboard\Providers\KamrulDashboardServiceProvider" <br/>
                    //__. Http/Kernel.php add <br/>
                    //&nbsp;&nbsp;&nbsp;&nbsp; 'setData' => \Modules\KamrulDashboard\Http\Middleware\IsInstalled::class,<br/>
                    //&nbsp;&nbsp;&nbsp;&nbsp; 'AdminSidebarMenu' => \Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu::class,<br/>
                    <br/>
                    <b>#Installation</b> <br/>
                    9. php artisan module:enable KamrulDashboard<br/>
                    10. php artisan vendor:publish --tag=kamruldashboard_public<br/>
                    11. php artisan vendor:publish --tag=sitemap_public<br/>
                    12. php artisan vendor:publish --tag=laravel-pagination<br/>
                    13. php artisan module:make ModuleName <br/>
                    14. php artisan kamrul:create ModuleName <br/>
                    15. php artisan kamrul:create-data ModuleName <br/>
                    16. php artisan kamrul:model ModuleCategory ModuleName <br/>
                    16. php artisan kamrul:modelpublic ModuleCategory ModuleName <br/>

                    <br/> <br/>
                    -------------------------------------------------------------- <br/>
                    1.  composer install <br/>
                    2.  npm install <br/>
                    3.  npm run dev <br/>
                    4.  composer dump-autoload <br/>
                    5.  php artisan optimize <br/>
                    6.  (create and edit .env for database connection) <br/>
                    7.  php artisan key:generate <br/>
                    8.  php artisan config:clear <br/>
                    9.  php artisan cache:clear <br/>
                    10. php artisan migrate <br/>
                    11. php artisan db:seed <br/>
                    12. php artisan migrate:refresh --seed <br/>
                    13. php artisan module:migrate-refresh --seed <br/>
                    14. php artisan serve <br/>
                    15. php artisan module:seed KamrulDashboard<br/>
                    16. php artisan module:seed<br/>
                    <br/>
                    <br/>
                    -------------------------------------------------------------- <br/>
                    &nbsp;  php artisan cache:clear<br/>
                    &nbsp;  php artisan view:clear<br/>
                    &nbsp;  php artisan route:clear<br/>
                    &nbsp;  php artisan clear-compiled<br/>
                    &nbsp;  php artisan config:cache<br/>
                    &nbsp;  php artisan config:clear<br/>

                </code>
            </div>
        </div>
    </div>
</div>
@endsection
