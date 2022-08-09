<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function index($tag)
    {
        $tagCollection = Tag::with(['blogPosts' => function($query) {
            $query->withCount('comments');
        }])->find($tag);

        return view(
            'posts.index',
            [
                'posts' => $tagCollection->blogPosts()
                    ->with(['user', 'tags'])
                    ->withCount('comments')
                    ->descOrder()
                    ->get()
            ]
        );
    }
}
