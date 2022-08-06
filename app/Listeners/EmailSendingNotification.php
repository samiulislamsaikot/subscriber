<?php

namespace App\Listeners;

use App\Events\EmailSending;
use App\Jobs\MailSend;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSendingNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmailSending  $event
     * @return void
     */
    public function handle(EmailSending $event)
    {
        $post = $event->post;

        $this->dispatch(new MailSend($post));
    }
}
