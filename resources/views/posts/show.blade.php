@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <h1>
        {{$post->title}}
    </h1>
    <p class="text-justify">
        {{$post->content}}
    </p>
    @component('components.author-information', ['author' => $post->user->name, 'date' => $post->created_at])
        Added
    @endcomponent

    @if(now()->diffInMinutes($post->created_at) < 5)
        <div class="alert alert-info">
            New!
        </div>
    @endif

    <h4 class="mb-3">Comments</h4>
    @forelse($post->comments as $comment)
        <p class="mb-0">
            {{$comment->content}}
        </p>
        <p class="text-muted">
            {{$comment->created_at->diffForHumans()}}
        </p>
    @empty
        <p>No comments yet !</p>
    @endforelse
@endsection
