@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <form action="{{route('register')}}" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{old('name')}}" placeholder="Input your name" required class="form-control" />
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{old('email')}}" placeholder="Input your email" required class="form-control" />
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Input your password" required class="form-control" />
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Retype your password" required class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary btn-block">
            Register !
        </button>
    </form>
@endsection
