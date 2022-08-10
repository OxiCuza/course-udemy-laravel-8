<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
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
        return view(
            'posts.index',
            [
                'posts' => BlogPost::descOrder()->withCount('comments')->with(['user', 'tags'])->get()
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

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            $post->image()->create(['path' => $path]);
        }

        $request->session()->flash('status', 'The blog post was created !');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function show($id)
    {
        $blogPost = Cache::remember("blog-post-$id", now()->addMinute(30), function () use ($id) {
            return BlogPost::with(['user', 'tags', 'comments' => function ($query) {
                return $query->descOrder();
            }, 'comments.user'])->findOrFail($id);
        });

        /**
         * For counting currently show this blogpost +- 1 minutes
         */
        # define key for counter and listing users
        $counterKey = "blog-post-$id-counter";
        $usersKey = "blog-post-$id-users";

        # get cache listing users with default value is array if null
        $users = Cache::get($usersKey, array());

        # define counter initiate is 0
        $usersUpdate = array();

        # get session id user
        $sessionUser = session()->getId();

        # if cache listing users is null the result cache listing is 1 user
        if (!Cache::has($counterKey)) {
            Cache::forever($counterKey, 1);
            $usersUpdate[$sessionUser] = now();
        }

        # loop cache listing has users
        foreach ($users as $sessionId => $timeUser) {
            if (($sessionUser == $sessionId) && now()->diffInMinutes($timeUser) >= 1) {
                # if key current user is exist && time different >= 1 the result is counter--
                Cache::decrement($counterKey);
            } elseif (($sessionUser != $sessionId) && now()->diffInMinutes($timeUser) <= 1) {
                # else if key current user is not exist && time different <= 1 the result is counter++
                $usersUpdate[$sessionUser] = now();
                Cache::increment($counterKey);
            } else {
                # else create new array for temporary
                $usersUpdate[$sessionId] = $timeUser;
            }
        }

        # update cache listing users
        Cache::forever($usersKey, $usersUpdate);

        return view('posts.show', [
            'post' => $blogPost,
            'counter' => Cache::get($counterKey),
        ]);
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
