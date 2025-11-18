<?php

namespace Modules\KamrulDashboard\Traits\Forms;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Fields\FormField;
use Modules\KamrulDashboard\Http\Models\DboardModel;

trait HasMetadata
{
    protected $metadataFields;

    public function isMetadataField(FormField $field): bool
    {
        $options = $field->getOptions();

        if (! $options) {
            return false;
        }

        return (bool) Arr::get($options, 'metadata', false);
    }

    public function getMetadataFields(): array
    {
        if (!isset($this->metadataFields)) {
            $this->metadataFields = collect($this->fields)
                ->filter(function (FormField $field) {
                    return $this->isMetadataField($field);
                })
                ->all();
        }

        return $this->metadataFields;
    }

    public function hasMetadataFields(): bool
    {
        return count($this->getMetadataFields()) > 0;
    }

    public function setupMetadataFields(): void
    {
        $model = $this->model;

        if (! $model instanceof DboardModel || ! $model->exists) {
            return;
        }

        if (! $this->hasMetadataFields()) {
            return;
        }

        $model->loadMissing('metadata');

        foreach ($this->getMetadataFields() as $field) {
            $field->setValue(
                $model->getMetaData($this->getMetadataFieldName($field), true)
            );
        }
    }

    public function saveMetadataFields(): void
    {
        if (! $this->model instanceof  DboardModel) {
            return;
        }

        if (! $this->hasMetadataFields()) {
            return;
        }

        foreach ($this->getMetadataFields() as $field) {
            $name = $this->getMetadataFieldName($field);

            $this->model->saveMetaDataFromFormRequest($name, $this->getRequest());
        }
    }

    protected function getMetadataFieldName(FormField $field): string
    {
        return Str::before($field->getName(), '[');
    }
}
