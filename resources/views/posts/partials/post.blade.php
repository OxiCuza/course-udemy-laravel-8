<h3>
    <a href="{{route('posts.show', ['post' => $post->id])}}">
        {{$post->title}}
    </a>
</h3>

<div class="text-muted mb-3">
    Added {{$post->created_at->diffForHumans()}}
    by {{ $post->user->name }}
</div>

@if($post->comments_count)
    <p>
        {{$post->comments_count}} comments
    </p>
@else
    <p>
        No comment yet !
    </p>
@endif

<div class="mb-3">
    <a href="{{route('posts.edit', ['post' => $post->id])}}" class="btn btn-primary">Edit</a>
    <form class="d-inline" action="{{route('posts.destroy', ['post' => $post->id])}}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>
</div>
