<?php


namespace Modules\Option\Enums;

use DboardHelper;
use Modules\KamrulDashboard\Packages\Supports\Enum;

/**
 * @method static OptionSetStatusEnum ACTIVE()
 * @method static OptionSetStatusEnum INACTIVE()
 * @method static OptionSetStatusEnum CANCELED()
 */
class OptionSetStatusEnum extends Enum
{
//    public const PENDING = 'pending';
//    public const PROCESSING = 'processing';
//    public const COMPLETED = 'completed';
//    public const CANCELED = 'canceled';
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';
    public const CANCELED = 'canceled';

    public static $langPath = 'option::optionset.statuses';

    public function toHtml()
    {
        switch ($this->value) {
            case self::CANCELED:
                $color = 'warning';
                break;
            case self::INACTIVE:
                $color = 'danger';
                break;
            case self::ACTIVE:
                $color = 'success';
                break;
            default:
                $color = 'primary';
                break;
        }
//        switch ($this->value) {
//            case self::PENDING:
//                $color = 'warning';
//                break;
//            case self::PROCESSING:
//                $color = 'secondary';
//                break;
//            case self::CANCELED:
//                $color = 'danger';
//                break;
//            case self::COMPLETED:
//                $color = 'success';
//                break;
//            default:
//                $color = 'primary';
//                break;
//        }

        return DboardHelper::renderBadge($this->label(), $color);
    }
}
