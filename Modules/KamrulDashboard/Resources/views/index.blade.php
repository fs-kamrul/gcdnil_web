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
                    1. composer require apphostbd/laravel-fpdf <br/>
                    2. composer require intervention/image <br/>
                    3. composer require maatwebsite/excel <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config <br/>
                    4. composer require nwidart/laravel-menus <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; php artisan vendor:publish --provider="Nwidart\Menus\MenusServiceProvider" <br/>
                    5. composer require nwidart/laravel-modules <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; composer.json file add this. <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; "autoload": { <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "psr-4": { <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "App\\": "app/", <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>"Modules\\": "Modules/",</b> <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "Database\\Factories\\": "database/factories/", <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "Database\\Seeders\\": "database/seeders/" <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; } <br/>

                    &nbsp;&nbsp;&nbsp; } <br/>
                    <br/>
                    <b>#Installation</b> <br/>
                    6. php artisan vendor:publish --tag=kamruldashboard_public<br/>
                    7. php artisan module:make ModuleName <br/>
                    8. php artisan kamrul:create ModuleName <br/>
                    9. php artisan kamrul:create-data ModuleName <br/>
                    9. php artisan kamrul:model ModuleCategory ModuleName <br/>

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
                    15. php artisan module:seed<br/>
                    <br/>
                    php artisan vendor:publish --provider="Modules\KamrulDashboard\Providers\KamrulDashboardServiceProvider" <br/>
                    <br/><br/>
                    config menus.php add <br/>
                    &nbsp;&nbsp;&nbsp; 'adminsidebarcustom' => \Modules\KamrulDashboard\Http\AdminSidebarCustom::class,<br/>
                    Http/Kernel.php add <br/>
                    &nbsp;&nbsp;&nbsp; 'setData' => \Modules\KamrulDashboard\Http\Middleware\IsInstalled::class,<br/>
                    &nbsp;&nbsp;&nbsp; 'AdminSidebarMenu' => \Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu::class,<br/>
                </code>
            </div>
        </div>
    </div>
</div>
@endsection
