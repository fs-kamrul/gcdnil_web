<?php

namespace Modules\ContactForm\Enums;

use Html;
use Illuminate\Support\HtmlString;
use Modules\KamrulDashboard\Packages\Supports\Enum;

/**
 * @method static ContactStatus UNREAD()
 * @method static ContactStatus READ()
 */
class ContactStatus extends Enum
{
    public const READ = 'read';
    public const UNREAD = 'unread';

    public static $langPath = 'contactform::contact.statuses';

    public function toHtml()
    {
        switch ($this->value) {
            case self::UNREAD:
                return Html::tag('span', self::UNREAD()->label(), ['class' => 'label-warning status-label'])
                    ->toHtml();
            case self::READ:
                return Html::tag('span', self::READ()->label(), ['class' => 'label-success status-label'])
                    ->toHtml();
            default:
                return parent::toHtml();
        }
    }
}
