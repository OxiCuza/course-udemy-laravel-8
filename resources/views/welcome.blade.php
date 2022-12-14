@extends('layouts.app')

@section('title')
    Example Page
@endsection

@section('content')
<div>
    {{__('messages.example')}}
</div>

<div>
    @lang('messages.example')
</div>


    @can('secret-link')
        <div>
            <a href="{{ route('home.secret') }}">
                This is route for secret page !
            </a>
        </div>
    @endcan
@endsection
