<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\SendOrderUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendOrderListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        Mail::to($event->email)->send(new SendOrderUser());
    }
}
