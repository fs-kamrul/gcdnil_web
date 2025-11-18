<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSystemsRequest;
use App\Http\Requests\UpdateSystemsRequest;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Modules\KamrulDashboard\Http\Models\Systems;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Packages\Supports\Helper;

class SystemsController extends Controller
{

    public function getCacheManagement()
    {
        if (!auth()->user()->can('systems_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('kamruldashboard::lang.cache_management'));
        $data = array();
        $data['title']        = 'cache_management';
        return view('kamruldashboard::systems.cache',$data);
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @param Filesystem $files
     * @param Application $app
     * @return DboardHttpResponse
     */
    public function postClearCache(Request $request, DboardHttpResponse $response, Filesystem $files, Application $app)
    {
        switch ($request->input('type')) {
            case 'clear_cms_cache':
                Helper::clearCache();
//                Menu::clearCacheMenuItems();
                break;
            case 'refresh_compiled_views':
                foreach ($files->glob(config('view.compiled') . '/*') as $view) {
                    $files->delete($view);
                }
                break;
            case 'clear_config_cache':
                $files->delete($app->getCachedConfigPath());
//                Helper::configCache();
//                Artisan::call('optimize');
                break;
            case 'clear_route_cache':
                $files->delete($app->getCachedRoutesPath());
                break;
            case 'clear_log':
                if ($files->isDirectory(storage_path('logs'))) {
                    foreach ($files->allFiles(storage_path('logs')) as $file) {
                        $files->delete($file->getPathname());
                    }
                }
                break;
        }

        return $response->setMessage(trans('kamruldashboard::lang.commands.' . $request->input('type') . '.success_msg'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSystemsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSystemsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Modules\KamrulDashboard\Http\Models\Systems  $systems
     * @return \Illuminate\Http\Response
     */
    public function show(Systems $systems)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Modules\KamrulDashboard\Http\Models\Systems  $systems
     * @return \Illuminate\Http\Response
     */
    public function edit(Systems $systems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSystemsRequest  $request
     * @param  \Modules\KamrulDashboard\Http\Models\Systems  $systems
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSystemsRequest $request, Systems $systems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\KamrulDashboard\Http\Models\Systems  $systems
     * @return \Illuminate\Http\Response
     */
    public function destroy(Systems $systems)
    {
        //
    }
}
