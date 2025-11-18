<?php

namespace Modules\ContactForm\Repositories\Caches;


use Modules\ContactForm\Repositories\Interfaces\ContactReplyInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class ContactReplyCacheDecorator extends CacheAbstractDecorator implements ContactReplyInterface
{
}
