@forelse($comments as $comment)
    <p class="mb-0">
        {{$comment->content}}
    </p>
    @component('components.tags', ['tags' => $comment->tags])
    @endcomponent
    @component('components.author-information', ['author' => $comment->user->name, 'date' => $comment->created_at, 'userId' => $comment->user->id])
    @endcomponent
@empty
    <p>No comments yet !</p>
@endforelse
