<?php

namespace Modules\LanguageAdvanced\Http\Controllers;

use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Illuminate\Routing\Controller;
use Modules\LanguageAdvanced\Http\Requests\LanguageAdvancedRequest;
use Modules\LanguageAdvanced\Packages\Supports\LanguageAdvancedManager;

class LanguageAdvancedController extends Controller
{
    /**
     * @param int $id
     * @param LanguageAdvancedRequest $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function save($id, LanguageAdvancedRequest $request, DboardHttpResponse $response)
    {
        $model = $request->input('model');

        if (!class_exists($model)) {
            abort(404);
        }

        $data = (new $model)->findOrFail($id);

        LanguageAdvancedManager::save($data, $request);

        do_action(LANGUAGE_ADVANCED_ACTION_SAVED, $data, $request);

        event(new UpdatedContentEvent('', $request, $data));

        return $response
            ->setMessage(trans('kamruldashboard::lang.update_success_message'));
    }
}
