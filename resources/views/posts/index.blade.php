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
