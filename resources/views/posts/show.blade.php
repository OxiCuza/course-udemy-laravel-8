@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 col-lg-8 col-md-8 col-sm-8">
                @if($post->image)
                    <div style="background-image: url('{{ $post->image->url() }}');
                        min-height: 500px;
                        color: white;
                        text-align: center;
                        background-attachment: fixed;">
                        <h1 style="padding-top: 100px; text-shadow: 1px 2px #000;">
                            @else
                                <h1>
                                    @endif

                                    {{$post->title}}

                                    @if($post->image)
                                </h1>
                    </div>
                    @else
                        </h1>
                @endif
                <p class="text-justify">
                    {{$post->content}}
                </p>

                @component('components.author-information', ['author' => $post->user->name, 'date' => $post->created_at, 'userId' => $post->user->id])
                    Added
                @endcomponent

                @component('components.tags', ['tags' => $post->tags])
                @endcomponent

                <p>
                    Currently read by {{ $counter }} people
                </p>

                @if(now()->diffInMinutes($post->created_at) < 5)
                    <div class="alert alert-info">
                        New!
                    </div>
                @endif

                <h4 class="mb-3">Comments</h4>

                @component('components.comment-form', ['route' => route('posts.comments.store', ['post' => $post->id])])
                @endcomponent

                @component('components.comment-list', ['comments' => $post->comments])
                @endcomponent
            </div>
            <div class="col-4 col-lg-4 col-md-4 col-sm-4">
                @component('components.card')
                    @slot('title', 'Most Commented Post')
                    @slot('collections', $mostCommented)
                    @slot('isBlogPost', true)
                @endcomponent

                @component('components.card')
                    @slot('title', 'Most Active Users')
                    @slot('collections', $mostActive)
                    @slot('isBlogPost', false)
                @endcomponent

                @component('components.card')
                    @slot('title', 'Most Active Last Month')
                    @slot('collections', $mostActiveLastMonth)
                    @slot('isBlogPost', false)
                @endcomponent
            </div>
        </div>
    </div>

@endsection
