<?php


namespace Modules\AdminBoard\Enums;

use DboardHelper;
use Modules\KamrulDashboard\Packages\Supports\Enum;

/**
 * @method static AdminBoardEnum WORKSHOP()
 * @method static AdminBoardEnum EVENT()
 * @method static AdminBoardEnum NEWS()
 * @method static AdminBoardEnum TEAM()
 */
class AdminBoardEnum extends Enum
{
    public const TEAM = 'team';
    public const WORKSHOP = 'workshop';
    public const EVENT = 'event';
    public const NEWS = 'news';
    public const NOTICEBOARD = 'noticeboard';

    public static $langPath = 'adminboard::admin_board.statuses';

    public function toHtml()
    {
        switch ($this->value) {
            case self::WORKSHOP:
                $color = 'warning';
                break;
            case self::EVENT:
                $color = 'primary';
                break;
            case self::NEWS:
                $color = 'success';
                break;
            case self::TEAM:
                $color = 'success';
                break;
            case self::NOTICEBOARD:
                $color = 'danger';
                break;
            default:
                $color = 'primary';
                break;
        }

        return DboardHelper::renderBadge($this->label(), $color);
    }
}
