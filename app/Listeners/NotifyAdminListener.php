<?php

namespace App\Listeners;

use App\Events\BlogPostedEvent;
use App\Mail\BlogPostAdded;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BlogPostedEvent $event)
    {
        User::isAdmin()->get()
            ->map(function (User $user) {
                Mail::to($user)->queue(
                    new BlogPostAdded
                );
            });
    }
}
