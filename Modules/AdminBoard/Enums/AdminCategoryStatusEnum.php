<?php


namespace Modules\AdminBoard\Enums;

use DboardHelper;
use Modules\KamrulDashboard\Packages\Supports\Enum;

/**
 * @method static AdminCategoryStatusEnum PUBLISHED()
 * @method static AdminCategoryStatusEnum DRAFT()
 * @method static AdminCategoryStatusEnum PENDING()
 */
class AdminCategoryStatusEnum extends Enum
{
    public const PUBLISHED = 'published';
    public const DRAFT = 'draft';
    public const PENDING = 'pending';

    public static $langPath = 'adminboard::admincategory.statuses';

    public function toHtml()
    {
        switch ($this->value) {
            case self::DRAFT:
                $color = 'warning';
                break;
            case self::PENDING:
                $color = 'danger';
                break;
            case self::PUBLISHED:
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
