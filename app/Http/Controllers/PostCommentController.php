<?php

namespace App\Http\Controllers;

use App\Events\CommentPostedEvent;
use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsers;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        // * IF YOU NEED SEND EMAIL TO ALL USERS, YOU SHOULD USE RATE LIMITER

        # SEND EMAIL TO AUTHOR
        // Mail::to($post->user)->send(
        // new CommentPosted($comment)
        // new CommentPostedMarkdown($comment)
        // );

        // Mail::to($post->user)->queue(
        //     new CommentPostedMarkdown($comment)
        // );

        # SEND EMAIL TO ANOTHER USERS ON WATCHED POST
        // NotifyUsers::dispatch($comment);

        // $when = now()->addMinutes(5);
        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment)
        // );

        // * TRY TO USE CUSTOM EVENT AND LISTENER FOR SENDING NOTIF / EMAIL
        event(new CommentPostedEvent($comment));

        $request->session()->flash('status', 'Comment was created!');
        return redirect()->back();
    }
}
