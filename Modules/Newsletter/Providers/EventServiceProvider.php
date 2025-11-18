<?php

namespace Modules\Newsletter\Providers;

use Modules\Newsletter\Events\SubscribeNewsletterEvent;
use Modules\Newsletter\Events\UnsubscribeNewsletterEvent;
use Modules\Newsletter\Listeners\AddSubscriberToMailchimpContactListListener;
use Modules\Newsletter\Listeners\AddSubscriberToSendGridContactListListener;
use Modules\Newsletter\Listeners\RemoveSubscriberToMailchimpContactListListener;
use Modules\Newsletter\Listeners\SendEmailNotificationAboutNewSubscriberListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SubscribeNewsletterEvent::class => [
            SendEmailNotificationAboutNewSubscriberListener::class,
            AddSubscriberToMailchimpContactListListener::class,
            AddSubscriberToSendGridContactListListener::class,
        ],
        UnsubscribeNewsletterEvent::class => [
            RemoveSubscriberToMailchimpContactListListener::class,
        ],
    ];
}
