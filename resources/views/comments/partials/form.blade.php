<div class="mb-2 mt-2">
    @auth
        <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="POST">
            @csrf

            <div class="form-group">
                <textarea type="text" id="content" name="content" class="form-control"></textarea>
            </div>
            @error('title')
            <div class="alert alert-danger">
                {{$message}}
            </div>
            @enderror

            <div>
                <input type="submit" value="Add Comment" class="btn btn-primary btn-block">
            </div>
        </form>
    @else
        <a href="{{ route('login') }}">Sign in</a> to post comments!
    @endauth
</div>
