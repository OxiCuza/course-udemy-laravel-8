<?php

namespace App\View\Composers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view)
    {
        $mostCommented = Cache::remember('mostCommented', now()->addMinute(30), function () {
            return BlogPost::mostCommented()->take(3)->get();
        });

        $mostActive = Cache::remember('mostActive', now()->addMinute(30), function () {
            return User::withMostBlogPosts()->take(3)->get();
        });

        $mostActiveLastMonth = Cache::remember('mostActiveLastMonth', now()->addMinute(15), function () {
            return User::withMostBlogPostsLastMonth()->take(3)->get();
        });

        $view->with('mostCommented', $mostCommented);
        $view->with('mostActive', $mostActive);
        $view->with('mostActiveLastMonth', $mostActiveLastMonth);
    }
}
