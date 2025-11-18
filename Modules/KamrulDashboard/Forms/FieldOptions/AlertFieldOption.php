<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class AlertFieldOption extends HtmlFieldOption
{
    protected $type = 'info';

    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        $data['attr'] = $this->getAttributes();

        $data['type'] = $this->type;

        if ($this->colspan) {
            $data['colspan'] = $this->getColspan();
        }

        return $data;
    }
}
