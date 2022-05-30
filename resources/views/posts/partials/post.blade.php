<h3>
    @if($post->trashed())
        <del>
            @endif
            <a href="{{route('posts.show', ['post' => $post->id])}}" class="{{ $post->trashed() ? 'text-muted' : '' }}">
                {{$post->title}}
            </a>
            @if($post->trashed())
        </del>
    @endif
</h3>

@component('components.author-information', ['author' => $post->user->name, 'date' => $post->created_at])
    Added
@endcomponent

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
    @can('update', $post)
        <a href="{{route('posts.edit', ['post' => $post->id])}}" class="btn btn-primary">Edit</a>
    @endcan

    @if(!$post->trashed())
        @can('delete', $post)
            <form class="d-inline" action="{{route('posts.destroy', ['post' => $post->id])}}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete" class="btn btn-danger">
            </form>
        @endcan
    @endif
</div>
