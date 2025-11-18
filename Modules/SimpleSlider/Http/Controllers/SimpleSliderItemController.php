<?php

namespace Modules\SimpleSlider\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Modules\KamrulDashboard\Events\BeforeEditContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Http\Controllers\DboardController;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\SimpleSlider\Http\Requests\SimpleSliderItemRequest;
use Modules\SimpleSlider\Repositories\Interfaces\SimpleSliderItemInterface;
use Modules\SimpleSlider\Tables\SimpleSliderItemTable;

class SimpleSliderItemController extends DboardController
{
    protected $simpleSliderItemRepository;

    public function __construct(SimpleSliderItemInterface $simpleSliderItemRepository)
    {
        $this->simpleSliderItemRepository = $simpleSliderItemRepository;
    }

    public function index(SimpleSliderItemTable $dataTable)
    {
        return $dataTable->renderTable();
    }

    public function create()
    {
        $data = array();
        $data['title']        = __('simpleslider::simple-slider.create_new_slide');
        return view('simpleslider::simpleslideritems.create',$data);
//        return $formBuilder->create(SimpleSliderItemForm::class)
//            ->setTitle(trans('simpleslider::simple-slider.create_new_slide'))
//            ->setUseInlineJs(true)
//            ->renderForm();
    }

    public function store(SimpleSliderItemRequest $request, DboardHttpResponse $response)
    {
        $simpleSlider = $this->simpleSliderItemRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(SIMPLE_SLIDER_ITEM_MODULE_SCREEN_NAME, $request, $simpleSlider));

        return $response->setMessage(trans('kamruldashboard::notices.create_success_message'));
    }

    public function edit(int $id, Request $request)
    {
        $simpleSliderItem = $this->simpleSliderItemRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $simpleSliderItem));

        $data = array();
        $data['title']        = __('simpleslider::simple-slider.edit_slide_new');
        $data['record']        = $simpleSliderItem;
        $data['simple_slider_id']        = $id;
        return view('simpleslider::simpleslideritems.create',$data);

//        return $formBuilder->create(SimpleSliderItemForm::class, ['model' => $simpleSliderItem])
//            ->setTitle(trans('simpleslider::simple-slider.edit_slide', ['id' => $simpleSliderItem->id]))
//            ->setUseInlineJs(true)
//            ->renderForm();
    }

    public function update(int $id, SimpleSliderItemRequest $request, DboardHttpResponse $response)
    {
        $simpleSlider = $this->simpleSliderItemRepository->findOrFail($id);
        $simpleSlider->fill($request->input());

        $this->simpleSliderItemRepository->createOrUpdate($simpleSlider);

        event(new UpdatedContentEvent(SIMPLE_SLIDER_ITEM_MODULE_SCREEN_NAME, $request, $simpleSlider));

        return $response->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    public function destroy(int $id)
    {
        $slider = $this->simpleSliderItemRepository->findOrFail($id);

        return view('simpleslider::partials.delete', compact('slider'))->render();
    }

    public function postDelete(Request $request, $id, DboardHttpResponse $response)
    {
        try {
            $simpleSlider = $this->simpleSliderItemRepository->findOrFail($id);
            $this->simpleSliderItemRepository->delete($simpleSlider);

            event(new DeletedContentEvent(SIMPLE_SLIDER_ITEM_MODULE_SCREEN_NAME, $request, $simpleSlider));

            return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
