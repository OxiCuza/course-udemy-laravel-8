@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <form action="{{route('register')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{old('email')}}" placeholder="Input your email" required class="form-control {{$errors->has('email') ? 'is-invalid' : '' }}" />
            @if($errors->has('email'))
                <span class="invalid-feedback">
                    {{$errors->first('email')}}
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Input your password" required class="form-control {{$errors->has('password') ? 'is-invalid' : '' }}" />
            @if($errors->has('password'))
                <span class="invalid-feedback">
                    {{$errors->first('password')}}
                </span>
            @endif
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="remember" id="remember" class="form-check-input" />
            <label for="remember" class="form-check-label">
                Remember Me
            </label>
        </div>
        <button type="submit" class="btn btn-primary btn-block">
            Login !
        </button>
    </form>
@endsection
