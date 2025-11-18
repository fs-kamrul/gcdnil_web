<?php

namespace Modules\ContactForm\Repositories\Caches;

use Illuminate\Database\Eloquent\Collection;
use Modules\ContactForm\Repositories\Interfaces\ContactInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class ContactCacheDecorator extends CacheAbstractDecorator implements ContactInterface
{
    public function getUnread($select = ['*']): Collection
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function countUnread(): int
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
