<?php

namespace Modules\Menus\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\BeforeEditContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Menus\Http\Models\Menus;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menus\Http\Imports\MenusImport;
use Modules\Menus\Http\Models\MenusNode;
use Modules\Menus\Http\Requests\MenusRequest;
use Modules\Menus\Packages\Facades\MenusFacade;
use Modules\Menus\Repositories\Interfaces\MenusInterface;
use Modules\Menus\Repositories\Interfaces\MenusNodeInterface;
use Modules\Menus\Repositories\Interfaces\MenusLocationInterface;
use Modules\Menus\Tables\MenusTable;
use Modules\Post\Http\Models\Category;
use Modules\Post\Http\Models\Page;
use Exception;
use Assets;

class MenusController extends Controller
{

    use HasDeleteManyItemsTrait;
    protected $photo_path = 'uploads/menus/';
    /**
     * @var MenusInterface
     */
    protected $menusRepository;

    /**
     * @var MenusNodeInterface
     */
    protected $menusNodeRepository;

    /**
     * @var MenusLocationInterface
     */
    protected $menusLocationRepository;
    /**
     * MenuController constructor.
     * @param MenusInterface $menusRepository
     * @param MenusNodeInterface $menusNodeRepository
     * @param MenusLocationInterface $menusLocationRepository
     */
    public function __construct(MenusInterface $menusRepository, MenusNodeInterface $menusNodeRepository, MenusLocationInterface $menusLocationRepository) {
        $this->menusRepository = $menusRepository;
        $this->menusNodeRepository = $menusNodeRepository;
        $this->menusLocationRepository = $menusLocationRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(MenusTable $dataTable)
    {
        if (!auth()->user()->can('menus_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('menus::lang.menus'));

        return $dataTable->renderTable();
//        $data = array();
//        $data['title']        = 'menus';
//        return view('menus::menus.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        Assets::addStyles(['menu_custom']);

        if (!auth()->user()->can('menus_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('menus::lang.menus_create'));
        $data = array();
        $data['title']        = 'menus_create';
        return view('menus::menus.create',$data);
    }

    /**
     * @param MenusRequest $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws Exception
     */
    public function store(MenusRequest $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('menus_create')) {
            abort(403, 'Unauthorized action.');
        }
        $menu = $this->menusRepository->getModel();

        $menu->fill($request->input());
        $menu->slug = $this->menusRepository->createSlug($request->input('name'));
        $menu->user_id = Auth::id();
        $menu = $this->menusRepository->createOrUpdate($menu);
//        $this->cache->flush();
        event(new CreatedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));

        $this->saveMenuLocations($menu, $request);

        return $response
            ->setPreviousUrl(route('menus.index'))
            ->setNextUrl(route('menus.edit', $menu->id))
            ->setMessage(trans('kamruldashboard::notices.create_success_message'));
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Menus\Http\Models\Menus  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menus $menu)
    {
        if (!auth()->user()->can('menus_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('menus::lang.menus_show'));
        $data = array();
        $data['menus']        = $menu;
        $data['title']        = 'menus_show';
        return view('menus::menus.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Menus\Http\Models\Menus  $menu
     * @return \Illuminate\Http\Response
     */
    public function pdf(Menus $menu)
    {
        if (!auth()->user()->can('menus_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('menus::lang.menus_show'));
        $data = array();
        $data['menus']        = $menu;
        $data['title']        = 'menus_show';
        return view('menus::menus.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @param Request $request
     * @return string
     */
    public function edit($id, Request $request)
    {
        if (!auth()->user()->can('menus_edit')) {
            abort(403, 'Unauthorized action.');
        }
        Assets::addScripts(['excanvas','custom-scrollbar', 'stickyTableHeaders', 'waypoints', 'spectrum', 'fancybox', 'are-you-sure'])
            ->addStyles(['custom-scrollbar', 'spectrum', 'fancybox'])
            ->addScriptsDirectly([
                'vendor/Modules/Menus/lib/jquery-nestable/jquery.nestable.js',
                'vendor/Modules/Menus/js/aaaamenus.js',
            ])
            ->addStylesDirectly([
                'vendor/Modules/Menus/css/menu_custom.css',
                'vendor/Modules/Menus/lib/jquery-nestable/jquery.nestable.css',
                'vendor/Modules/Menus/css/menus.css',
            ]);
        page_title()->setTitle(trans('menus::lang.menus_edit'));

        $oldInputs = old();
        if ($oldInputs && $id == 0) {
            $oldObject = new stdClass();
            foreach ($oldInputs as $key => $row) {
                $oldObject->$key = $row;
            }
            $menu = $oldObject;
        } else {
            $menu = $this->menusRepository->findOrFail($id);
        }
        event(new BeforeEditContentEvent($request, $menu));

        $data = array();
        $locations = [];
        $data['menu']      = $menu;
        $data['locations']      = $menu->locations()->pluck('location')->all();
//        $data['menulist']       = $data['record']->pluck('name', 'id')->prepend('Select menu', 0)->all();
        $data['title']        = 'menus_edit';
        $data['record']        = $menu;//Menus::where('id', $_GET['menu'])->first();
//        if($id != 0){
//            $data['indmenu']        = $data['record'];
//            $data['menu_nodes']        = MenusNode::where('menus_id', $data['record']->id)->get();
//        }
        $data['menulist']        = $data['record']->pluck('name', 'id')->prepend('Select menu', 0)->all();
        return view('menus::menus.edit_new',$data,);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MenusRequest  $request
     * @param  \Modules\Menus\Http\Models\Menus  $menu
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return Exception
     */
    public function update(MenusRequest $request, $id, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('menus_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $menus = $this->menusRepository->firstOrNew(compact('id'));
        $menus->fill($request->input());
        $this->menusRepository->createOrUpdate($menus);
        event(new UpdatedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menus));

        $this->saveMenuLocations($menus, $request);

        $deletedNodes = ltrim($request->input('deleted_nodes', ''));
        if ($deletedNodes) {
            $deletedNodes = explode(' ', ltrim($request->input('deleted_nodes', '')));
            $this->menusNodeRepository->deleteBy([['id', 'IN', $deletedNodes]]);
        }
        MenusFacade::recursiveSaveMenu(json_decode($request->input('menu_nodes'), true), $menus->id, 0);

        return $response
            ->setPreviousUrl(route('menus.index'))
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \Modules\Menus\Http\Models\Menus  $menu
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function destroy(Request $request, Menus  $menu, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('menus_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        $path = $this->photo_path;
        try{
            $menus = $this->menusRepository->findOrFail($menu->id);
            $this->menusNodeRepository->deleteBy(['menus_id' => $menus->id]);
            $this->menusLocationRepository->deleteBy(['menus_id' => $menus->id]);
            $this->menusRepository->delete($menus);
            deleteFile($menu->photo, $path);
            event(new DeletedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));

            return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
        } catch ( \Exception $e) {
            return $response
                ->setError()
                ->setMessage($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('kamruldashboard::notices.no_select'));
        }

        foreach ($ids as $id) {
            $menu = $this->menusRepository->findOrFail($id);
            $this->menusNodeRepository->deleteBy(['menus_id' => $menu->id]);
            $this->menusLocationRepository->deleteBy(['menus_id' => $menu->id]);
            $this->menusRepository->delete($menu);
            event(new DeletedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));
        }

        return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
    }
    public function newMenu()
    {
        if (!auth()->user()->can('menus_create')) {
            abort(403, 'Unauthorized action.');
        }
        if(isset($_GET['menu'])){
            $get_menu = $_GET['menu'];
        }else{
            $get_menu = 0;
        }
        $data = array();
        $data['menulist'] = array();
        $data['locations'] = array();
        $locations = array();
        $data['title']        = 'menus';
        if($get_menu != 0){
            $data['menus']          = MenusNode::where('menus_id', $get_menu)->where('parent_id', 0)->orderBy('sort', 'ASC')->get();
            $data['indmenu']        = Menus::find($get_menu);
            $locations              = $data['indmenu']->locations->pluck('location')->toarray();
//            $data['record']         = Menus::where('id', $get_menu)->first();
        }
        foreach ($locations as $location){
            $data['locations'][] = $location;
        }
        $data['menulist']       = Menus::pluck('name', 'id')->prepend('Select menu', 0)->all();
        return view('menus::menus.edit',$data);
    }

    public function createNewMenu(Request $request)
    {
//        $menu = new Menus();
        $menu                 = new Menus();
        $menu->name           = $request->name;
        $menu->slug           = $this->menusRepository->createSlug($request->name);
        $menu->status         = 1;
        $menu->uuid           = gen_uuid();
        $menu->user_id        = Auth::id();
        $menu->save();

        $this->saveMenuLocations($menu, $request);
        return response()->json([
            'resp' => $menu->id
        ], 200);
    }
    public function createItem(Request $request)
    {
        if ($request->has('data')) {
            foreach ($request->post('data') as $key => $value) {
                $menuitem = new MenusNode();
                $menuitem->title = $value['label'];
                $menuitem->url = $value['url'];
                $menuitem->icon_font = $value['icon'];
                $menuitem->menus_id = $value['id'];
                $menuitem->reference_id = $value['reference_id'];
                $menuitem->reference_type = $value['reference_type'];
                $menuitem->parent_id = 0;
                $menuitem->sort = MenusNode::getNextSortRoot($value['id']);
                $menuitem->save();
            }
        }

        return response()->json([
            'resp' => 1
        ], 200);
    }
    public function updateItem(Request $request)
    {
        $dataItem = $request->input('dataItem');
        if (is_array($dataItem)) {
            foreach ($dataItem as $value) {
                $menuitem = MenusNode::findOrFail($value['id']);
                $menuitem->title = $value['label'];
                $menuitem->url = $value['link'];
                $menuitem->css_class = $value['class'];
                $menuitem->icon_font = $value['icon'];
                $menuitem->target = $value['target'];
                $menuitem->save();
            }
        } else {
            $menuitem = MenusNode::findOrFail($request->input('id'));
            $menuitem->title = $request->input('label');
            $menuitem->url = $request->input('url');
            $menuitem->css_class = $request->input('clases');
            $menuitem->icon_font = $request->input('icon');
            $menuitem->target = $request->input('target');
            $menuitem->save();
        }
        return response()->json([
            'resp' => 1
        ], 200);
    }
    public function generateMenuControl(Request $request)
    {
        $menu = Menus::findOrFail($request->input('idMenu'));
        $menu->name = $request->input('menuName');
        $menu->save();
        if (is_array($request->input('data'))) {
            foreach ($request->input('data') as $key => $value) {
                $menuitem = MenusNode::findOrFail($value['id']);
//                $mother_id = $menuitem->parent_id;
                $menuitem->parent_id = $value['parent_id'] ?? 0;
                $menuitem->sort = $key;
                $menuitem->depth = $value['depth'] ?? 1;
                $menuitem->has_child = 0;
                $menuitem->save();

//                if($mother_id) {
//                    $menuitem2 = MenusNode::findOrFail($mother_id);
//                    $menuitem2->has_child = 0;
//                    $menuitem2->save();
////                    if($mother_id != 6 && $mother_id != 10 && $mother_id != 18) {
////                    }
//                }
                if(isset($value['parent_id'])) {
//                    if($value['parent_id'] != 6 && $value['parent_id'] != 10 && $value['parent_id'] != 18) {
//                    }
                    $menuitem1 = MenusNode::findOrFail($value['parent_id']);
                    $menuitem1->has_child = 1;
                    $menuitem1->save();
                }
            }
        }
        $menus = $this->menusRepository->getModel();
        $menus->fill($request->input());
        $this->saveMenuLocations($menu, $request);
        return response()->json([
            'resp' => 1
        ], 200);
    }

    /**
     * @param Model $menus
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    protected function saveMenuLocations($menus, Request $request)
    {
        $locations = $request->input('locations', []);

        $this->menusLocationRepository->deleteBy([
            'menus_id' => $menus->id,
            ['location', 'NOT_IN', $locations],
        ]);

        foreach ($locations as $location) {
            $menuLocation = $this->menusLocationRepository->firstOrCreate([
                'menus_id'  => $menus->id,
                'location' => $location,
            ]);
            event(new CreatedContentEvent(MENU_LOCATION_MODULE_SCREEN_NAME, $request, $menuLocation));
        }

        return true;
    }
    public function destroyMenu(Request $request)
    {
        $menudelete = Menus::findOrFail($request->input('id'));
        $menudelete->delete();

        return response()->json([
            'resp' => 'You delete this item'
        ], 200);
    }

    public function destroyItem(Request $request)
    {
        $menuitem = MenusNode::findOrFail($request->input('id'));
        $menuitem->delete();
        return response()->json([
            'resp' => 1
        ], 200);
    }
}
