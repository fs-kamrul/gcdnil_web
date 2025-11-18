<?php

namespace Modules\KamrulDashboard\Traits;

use Exception;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

trait HasDeleteManyItemsTrait
{
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @param RepositoryInterface $repository
     * @param string $screen
     * @return DboardHttpResponse
     * @throws Exception
     */
    protected function executeDeleteItems(
        Request $request,
        DboardHttpResponse $response,
        RepositoryInterface $repository,
        string $screen
    ) {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('kamruldashboard::lang.no_select'));
        }

        foreach ($ids as $id) {
            $item = $repository->findOrFail($id);
            if (!$item) {
                continue;
            }

            $repository->delete($item);
            event(new DeletedContentEvent($screen, $request, $item));
        }

        return $response->setMessage(trans('kamruldashboard::lang.delete_success_message'));
    }
}
