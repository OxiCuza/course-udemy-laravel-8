<div class="text-muted mb-3">
    {{ $slot }} {{$date->diffForHumans()}} by
    @if(isset($userId))
        <a href="{{ route('users.show', ['user' => $userId]) }}">
            {{ $author }}
        </a>
    @else
        {{ $author }}
    @endif
</div>
