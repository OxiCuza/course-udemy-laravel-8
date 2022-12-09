<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    protected $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Commented was posted on your {$this->comment->commentable->title} blog post";

        return $this->subject($subject)
            // ->attach(
            //     Storage::path('thumbnails/dummy-people-image.jpg'),
            //     [
            //         'as' => 'try_attach.jpg',
            //         'mime' => 'image/jpeg'
            //     ]
            // )
            ->attachFromStorageDisk('public', 'thumbnails/dummy-people-image.jpg', 'try_attach.jpg')
            ->view('emails.posts.commented', ['comment' => $this->comment]);
    }
}
