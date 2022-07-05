<div class="card mb-4">
    <div class="card-header">
        {{ $title }}
    </div>
    <ul class="list-group list-group-flush">
        @foreach($collections as $collection)
            <li class="list-group-item">
                @if($isBlogPost)
                    <a href="{{ route('posts.show', ['post' => $collection->id]) }}">
                        {{ $collection->title }}
                    </a>
                @else
                    {{ $collection->name }}
                @endif
            </li>
        @endforeach
    </ul>
</div>
