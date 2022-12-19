<?php

namespace App\Http\Controllers;

use App\Events\BlogPostedEvent;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use App\Services\Counter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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
            $post->image()->save(
                Image::make(['path' => $path])
            );
        }

        event(new BlogPostedEvent($post));

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
        $counter = resolve(Counter::class);

        return view('posts.show', [
            'post' => $blogPost,
            'counter' => $counter->increment("blog-post-{$id}"),
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

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }

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
