<?php

namespace Modules\KamrulDashboard\Widgets;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Http\helpers\ChartHelper;

abstract class Widget
{
    protected $view;

    protected $columns;

    /**
     * @var CarbonInterface
     */
    protected $endDate;

    /**
     * @var CarbonInterface
     */
    protected $startDate;

    protected $dateFormat;

    public function __construct()
    {

        [$this->startDate, $this->endDate] = ChartHelper::getDateRange();

        $diffInDays = $this->startDate->diffInDays($this->endDate);

        $this->dateFormat = '';
        switch (true) {
            case ($diffInDays < 1):
                $this->dateFormat = '%h %d';
                break;
            case ($diffInDays <= 30):
                $this->dateFormat = '%d %b';
                break;
            case ($diffInDays > 30):
                $this->dateFormat = '%b %Y';
                break;
            case ($diffInDays > 365):
                $this->dateFormat = '%Y';
                break;
        }
    }

    public function getLabel()
    {
        return null;
    }

    public function getPriority()
    {
        return null;
    }

    public function getColumns(): int
    {
        return 12;
    }

    public function getViewData(): array
    {
        return [
            'id' => strtolower(Str::snake(class_basename(static::class . 'Widget'), '-')),
            'label' => $this->getLabel(),
            'priority' => $this->getPriority(),
            'columns' => $this->columns ?? null,
        ];
    }

    public function render(): View
    {
        return view('kamruldashboard::widgets.' . $this->view, $this->getViewData());
    }

    protected function translateCategories(array $data): array
    {
        $categories = [];

        foreach (array_keys($data) as $key => $item) {
            $replacement = [
                '%h %d' => '%h',
                '%d %b' => '%d M',
                '%b %Y' => '%M Y',
                '%' => '',
            ];

            $displayFormat = $this->dateFormat;

            foreach ($replacement as $replacementKey => $value) {
                $displayFormat = str_replace($replacementKey, $value, $displayFormat);
            }

            $dataFormat = str_replace('%', '', str_replace('%b', '%M', $this->dateFormat));

            $categories[$key] = Carbon::createFromFormat($dataFormat, $item)->translatedFormat($displayFormat);
        }

        return $categories;
    }
}
