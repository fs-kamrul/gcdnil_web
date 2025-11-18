<?php

namespace Modules\Newsletter\Http\packages;

use Html;
use Modules\KamrulDashboard\Packages\Supports\Enum;

/**
 * @method static NewsletterStatus SUBSCRIBED()
 * @method static NewsletterStatus UNSUBSCRIBED()
 */
class NewsletterStatus  extends Enum
{
    public const SUBSCRIBED = 'Subscribed';
    public const UNSUBSCRIBED = 'Unsubscribed';
//    public const DATA = [self::SUBSCRIBED,self::UNSUBSCRIBED];

    /**
     * @var string
     */
    public static $langPath = 'newsletter::lang.statuses';

    /**
     * @return string
     */
    public function toHtml()
    {
        switch ($this->value) {
            case self::SUBSCRIBED:
                return Html::tag('span', self::SUBSCRIBED()->label(), ['class' => 'label-success status-label'])
                    ->toHtml();
            case self::UNSUBSCRIBED:
                return Html::tag('span', self::UNSUBSCRIBED()->label(), ['class' => 'label-warning status-label'])
                    ->toHtml();
            default:
                return parent::toHtml();
        }
    }
}
