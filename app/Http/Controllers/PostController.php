<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
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

        return view(
            'posts.index',
            [
                'posts' => BlogPost::descOrder()->withCount('comments')->with('user')->get(),
                'mostCommented' => $mostCommented,
                'mostActive' => $mostActive,
                'mostActiveLastMonth' => $mostActiveLastMonth,
            ]
        );
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $post = new BlogPost();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'The blog post was created !');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function show($id)
    {
        $blogPost = Cache::remember("blog-post-$id", now()->addMinute(30), function () use ($id) {
            return BlogPost::with(['user', 'comments' => function ($query) {
                return $query->descOrder();
            }])->findOrFail($id);
        });

        return view('posts.show', ['post' => $blogPost]);
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

//        if (Gate::denies('update-post', $post)) {
//            abort(403, "You can't edit this post!");
//        }

        $this->authorize('update', $post);

        return view('posts.edit', ['post' => $post]);
    }

    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('update', $post);

        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'The blog post was updated !');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('delete', $post);

        $post->delete();

        session()->flash('status', 'Blog post was deleted !');

        return redirect()->route('posts.index');
    }
}
