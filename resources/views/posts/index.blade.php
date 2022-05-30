@extends('layouts.app')

@section('title', 'list of post')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 col-lg-8 col-md-8 col-sm-8">
                @forelse($posts as $post)
                    @include('posts.partials.post')
                @empty
                    <p>No Blog Post !</p>
                @endforelse
            </div>
            <div class="col-4 col-lg-4 col-md-4 col-sm-4">
                <div class="card mb-4">
                    <div class="card-header">
                        Most Commented BlogPost
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($mostCommented as $post)
                            <li class="list-group-item">
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                    {{ $post->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        Most Active Users
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($mostActive as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        Most Active Last Month
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($mostActiveLastMonth as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
