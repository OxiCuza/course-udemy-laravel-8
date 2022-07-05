<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TagController extends Controller
{
    public function index($tag)
    {
        $mostCommented = array();

        $mostActive = array();

        $mostActiveLastMonth = array();

        $tag = Tag::with(['blogPosts' => function($query) {
            $query->withCount('comments');
        }])->get();

        return view(
            'posts.index',
            [
                'posts' => $tag->blogPosts,
                'mostCommented' => $mostCommented,
                'mostActive' => $mostActive,
                'mostActiveLastMonth' => $mostActiveLastMonth,
            ]
        );
    }
}
