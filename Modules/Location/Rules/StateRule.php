<?php

namespace Modules\Location\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Location\Repositories\Interfaces\StateInterface;

class StateRule implements DataAwareRule, Rule
{
    protected $data = [];

    protected $countryKey;

    public function __construct(?string $countryKey = '')
    {
        $this->countryKey = $countryKey;
    }

    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    public function passes($attribute, $value): bool
    {
        $condition = [
            'id' => $value,
            'status' => DboardStatus::PUBLISHED,
        ];

        if ($this->countryKey) {
            $countryId = Arr::get($this->data, $this->countryKey);
            if (! $countryId) {
                return false;
            }
            $condition['country_id'] = $countryId;
        }

        return app(StateInterface::class)->count($condition);
    }

    public function message(): string
    {
        return trans('validation.exists');
    }
}
