<?php

namespace Modules\KamrulDashboard\Packages\Supports;

use Html;

/**
 * @method static DboardStatus DRAFT()
 * @method static DboardStatus PUBLISHED()
 * @method static DboardStatus UNPUBLISHED()
 * @method static DboardStatus PENDING()
 */
class DboardStatus extends Enum
{
    public const PUBLISHED = 1;
    public const UNPUBLISHED = 0;
    public const PENDING = 3;
    public const DRAFT = 2;

    /**
     * @var string
     */
    public static $langPath = 'kamruldashboard::enums.statuses';
//    public function toStatusHtml(){
//
//        return 3;
//    }
    public function toHtml(): string
    {
        switch ($this->value) {
            case self::DRAFT:
                return Html::tag('span', self::DRAFT()->label(), ['class' => 'label-info status-label'])
                    ->toHtml();
            case self::PENDING:
                return Html::tag('span', self::PENDING()->label(), ['class' => 'label-warning status-label'])
                    ->toHtml();
            case self::PUBLISHED:
                return Html::tag('span', self::PUBLISHED()->label(), ['class' => 'label-success status-label'])
                    ->toHtml();
            case self::UNPUBLISHED:
                return Html::tag('span', self::UNPUBLISHED()->label(), ['class' => 'label-warning status-label'])
                    ->toHtml();
            default:
                return parent::toHtml();
        }
    }
}
