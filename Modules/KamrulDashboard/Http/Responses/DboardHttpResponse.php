<?php

namespace Modules\KamrulDashboard\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class DboardHttpResponse extends Response implements Responsable
{
    /**
     * @var bool
     */
    protected $error = false;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $previousUrl = '';

    /**
     * @var string
     */
    protected $nextUrl = '';

    /**
     * @var bool
     */
    protected $withInput = false;

    /**
     * @var array
     */
    protected $additional = [];

    /**
     * @var int
     */
    protected $code = 200;

    public $saveAction = 'save';

    public static function make(): self
    {
        return app(static::class);
    }
    /**
     * @param mixed $data
     * @return DboardHttpResponse
     */
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $previousUrl
     * @return DboardHttpResponse
     */
    public function setPreviousUrl($previousUrl): self
    {
        $this->previousUrl = $previousUrl;

        return $this;
    }

    public function setPreviousRoute(string $name, $parameters = [], bool $absolute = true)
    {
        return $this->setPreviousUrl(route($name, $parameters, $absolute));
    }

    /**
     * @param string $nextUrl
     * @return DboardHttpResponse
     */
    public function setNextUrl($nextUrl): self
    {
        $this->nextUrl = $nextUrl;

        return $this;
    }

    /**
     * @param bool $withInput
     * @return DboardHttpResponse
     */
    public function withInput(bool $withInput = true): self
    {
        $this->withInput = $withInput;

        return $this;
    }

    /**
     * @param int $code
     * @return DboardHttpResponse
     */
    public function setCode(int $code): self
    {
        if ($code < 100 || $code >= 600) {
            return $this;
        }

        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return DboardHttpResponse
     */
    public function setMessage($message): self
    {
        $this->message = clean($message);

        return $this;
    }
    public function withCreatedSuccessMessage(): static
    {
        return $this->setMessage(
            trans('kamruldashboard::notices.create_success_message')
        );
    }

    public function withUpdatedSuccessMessage(): static
    {
        return $this->setMessage(
            trans('kamruldashboard::notices.update_success_message')
        );
    }

    public function withDeletedSuccessMessage(): static
    {
        return $this->setMessage(
            trans('kamruldashboard::notices.delete_success_message')
        );
    }
    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @param bool $error
     * @return DboardHttpResponse
     */
    public function setError(bool $error = true): self
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @param array $additional
     * @return DboardHttpResponse
     */
    public function setAdditional(array $additional): self
    {
        $this->additional = $additional;

        return $this;
    }

    /**
     * @return DboardHttpResponse|RedirectResponse|JsonResource
     */
    public function toApiResponse()
    {
        if ($this->data instanceof JsonResource) {
            return $this->data->additional(array_merge([
                'error'   => $this->error,
                'message' => $this->message,
            ], $this->additional));
        }

        return $this->toResponse(request());
    }

    /**
     * @param Request $request
     * @return DboardHttpResponse|JsonResponse|RedirectResponse
     */
    public function toResponse($request)
    {
        if ($request->expectsJson()) {
            $data = [
                'error'   => $this->error,
                'data'    => $this->data,
                'message' => $this->message,
            ];

            if ($this->additional) {
                $data = array_merge($data, ['additional' => $this->additional]);
            }

            return response()
                ->json($data, $this->code);
        }

        if ($request->input('submit') === 'save' && !empty($this->previousUrl)) {
            return $this->responseRedirect($this->previousUrl);
        } elseif (!empty($this->nextUrl)) {
            return $this->responseRedirect($this->nextUrl);
        }

        return $this->responseRedirect(URL::previous());
    }

    /**
     * @param string $url
     * @return RedirectResponse
     */
    protected function responseRedirect($url)
    {
        if ($this->withInput) {
            return redirect()
                ->to($url)
                ->with($this->error ? 'error_msg' : 'success_msg', $this->message)
                ->withInput();
        }

        return redirect()
            ->to($url)
            ->with($this->error ? 'error_msg' : 'success_msg', $this->message);
    }

    public function isSaving(): bool
    {
        return $this->getSubmitterValue() === $this->saveAction;
    }

    protected function getSubmitterValue(): string
    {
        return (string) request()->input('submitter');
    }

    public function toArray(): array
    {
        $data = [
            'error' => $this->error,
            'data' => $this->data,
            'message' => $this->message,
        ];

        if ($this->additional) {
            $data = array_merge($data, ['additional' => $this->additional]);
        }

        return $data;
    }
}
