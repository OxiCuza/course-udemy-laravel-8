@extends('layouts.app')

@section('title', 'list of post')

@section('content')
    <div class="container">
        @foreach($posts as $post)
            @include('posts.partials.post')
        @endforeach
    </div>
@endsection
