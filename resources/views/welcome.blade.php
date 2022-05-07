@extends('layouts.app')

@section('title')
    Example Page
@endsection

@section('content')
    This is example of content

    @can('secret-link')
        <div>
            <a href="{{ route('home.secret') }}">
                This is route for secret page !
            </a>
        </div>
    @endcan
@endsection
