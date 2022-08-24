<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogPost = BlogPost::all();
        $users = User::all();

        if (($blogPost->count() === 0) || ($users->count() === 0)) {
            $this->command->info('You do not have blog post, so no need comments !');
            return;
        }

        $sumComments = $this->command->ask('How many comment would you like to added ?', 50);

        Comment::factory($sumComments)->make()->each(function ($comment) use ($blogPost, $users) {
            $comment->commentable_id = $blogPost->random()->id;
            $comment->commentable_type = BlogPost::class;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        Comment::factory($sumComments)->make()->each(function ($comment) use ($users) {
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = User::class;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
