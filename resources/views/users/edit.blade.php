@extends('layouts.app')

@section('title', 'Update the Post')

@section('content')
    <form action="{{route('users.update', ['user' => $user->id])}}"
          method="POST"
          enctype="multipart/form-data"
          class="form-horizontal">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : '' }}" alt="avatar" class="img-thumbnail avatar" />
                <div class="card mt-4">
                    <div class="card-body">
                        <h6>
                            Upload a different photo
                        </h6>
                        <input type="file" class="form-control-file" name="avatar" />
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <label for="name">Name :</label>
                    <input type="text" id="name" name="name" class="form-control" />
                </div>
                @error('name')
                <div class="alert alert-danger">
                    {{$message}}
                </div>
                @enderror
                <div class="form-group">
                    <input type="submit" value="Update" class="btn btn-primary btn-block">
                </div>
            </div>
        </div>
    </form>
@endsection
