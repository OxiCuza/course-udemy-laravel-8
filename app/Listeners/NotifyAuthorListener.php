<?php

namespace App\Listeners;

use App\Events\CommentPostedEvent;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAuthorListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPostedEvent $event)
    {
        # SEND EMAIL TO AUTHOR
        Mail::to($event->user)->queue(
            new CommentPostedMarkdown($event)
        );
    }
}
