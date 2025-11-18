<?php

namespace Modules\SimpleSlider\Http\Controllers;

use Assets;
use Illuminate\Http\Request;
use Exception;
use Modules\KamrulDashboard\Events\BeforeEditContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Http\Controllers\DboardController;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\SimpleSlider\Http\Requests\SimpleSliderRequest;
use Modules\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;
use Modules\SimpleSlider\Repositories\Interfaces\SimpleSliderItemInterface;
use Modules\SimpleSlider\Tables\SimpleSliderItemTable;
use Modules\SimpleSlider\Tables\SimpleSliderTable;

class SimpleSliderController extends DboardController
{
    use HasDeleteManyItemsTrait;

    protected $simpleSliderRepository;

    protected $simpleSliderItemRepository;

    public function __construct(
        SimpleSliderInterface $simpleSliderRepository,
        SimpleSliderItemInterface $simpleSliderItemRepository
    ) {
        $this->simpleSliderRepository = $simpleSliderRepository;
        $this->simpleSliderItemRepository = $simpleSliderItemRepository;
    }

    public function index(SimpleSliderTable $dataTable)
    {
        page_title()->setTitle(trans('simpleslider::simple-slider.menu'));

        return $dataTable->renderTable();
    }

    public function create()
    {
        page_title()->setTitle(trans('simpleslider::simple-slider.create'));

        $data = array();
        $data['title']        = 'simpleslider';
        return view('simpleslider::simpleslider.create',$data);
//        return $formBuilder
//            ->create(SimpleSliderForm::class)
//            ->removeMetaBox('slider-items')
//            ->renderForm();
    }

    public function store(SimpleSliderRequest $request, DboardHttpResponse $response)
    {
        $simpleSlider = $this->simpleSliderRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(SIMPLE_SLIDER_MODULE_SCREEN_NAME, $request, $simpleSlider));

        return $response
            ->setPreviousUrl(route('simple-slider.index'))
            ->setNextUrl(route('simple-slider.edit', $simpleSlider->id))
            ->setMessage(trans('kamruldashboard::notices.create_success_message'));
    }

    public function edit(int $id, Request $request, SimpleSliderItemTable $dataTable)
    {
        Assets::addScripts(['blockui', 'sortable'])
            ->addScriptsDirectly(['vendor/Modules/SimpleSlider/js/simple-slider-admin.js']);

        $simpleSlider = $this->simpleSliderRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $simpleSlider));

        page_title()->setTitle(trans('simpleslider::simple-slider.edit') . ' "' . $simpleSlider->name . '"');

        $data = array();
        $data['title']        = 'simpleslider';
        $data['record']        = $simpleSlider;
        $data['content']        = $dataTable->setAjaxUrl(route('simple-slider-item.index',$id ?: 0))->renderTable();
        return view('simpleslider::simpleslider.create',$data);
//        return $formBuilder
//            ->create(SimpleSliderForm::class, ['model' => $simpleSlider])
//            ->renderForm();
    }

    public function update(int $id, SimpleSliderRequest $request, DboardHttpResponse $response)
    {
        $simpleSlider = $this->simpleSliderRepository->findOrFail($id);
        $simpleSlider->fill($request->input());

        $this->simpleSliderRepository->createOrUpdate($simpleSlider);

        event(new UpdatedContentEvent(SIMPLE_SLIDER_MODULE_SCREEN_NAME, $request, $simpleSlider));

        return $response
            ->setPreviousUrl(route('simple-slider.index'))
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    public function destroy(Request $request, int $id, DboardHttpResponse $response)
    {
        try {
            $simpleSlider = $this->simpleSliderRepository->findOrFail($id);
            $this->simpleSliderRepository->delete($simpleSlider);

            event(new DeletedContentEvent(SIMPLE_SLIDER_MODULE_SCREEN_NAME, $request, $simpleSlider));

            return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->simpleSliderRepository, SIMPLE_SLIDER_MODULE_SCREEN_NAME);
    }

    public function postSorting(Request $request, DboardHttpResponse $response)
    {
        foreach ($request->input('items', []) as $key => $id) {
            $this->simpleSliderItemRepository->createOrUpdate(['order' => ($key + 1)], ['id' => $id]);
        }

        return $response->setMessage(trans('simpleslider::simple-slider.update_slide_position_success'));
    }
}
