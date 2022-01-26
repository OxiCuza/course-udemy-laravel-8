@extends('layouts.app')

@section('title', 'list of post')

@section('content')
    <div class="container">
        @forelse($posts as $post)
            @include('posts.partials.post')
        @empty
            <p>No Blog Post !</p>
        @endforelse
    </div>
@endsection
