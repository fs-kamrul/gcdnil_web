<?php

namespace Modules\KamrulDashboard\Listeners;

use Exception;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Modules\KamrulDashboard\Events\SendMailEvent;
use Modules\KamrulDashboard\Packages\Supports\EmailAbstract;

class SendMailListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * SendMailListener constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param SendMailEvent $event
     * @return void
     * @throws Exception
     */
    public function handle(SendMailEvent $event)
    {
        try {
            $this->mailer->to($event->to)->send(new EmailAbstract($event->content, $event->title, $event->args));
        } catch (Exception $exception) {
            if ($event->debug) {
                throw $exception;
            }
            Log::error($exception->getMessage());
        }
    }
}
