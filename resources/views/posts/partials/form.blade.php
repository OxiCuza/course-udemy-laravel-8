<div class="form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" class="form-control" value="{{old('title', optional($post ?? null)->title)}}" />
</div>
@error('title')
    <div class="alert alert-danger">
        {{$message}}
    </div>
@enderror

<div class="form-group">
    <label for="content">Content</label>
    <textarea name="content" id="content" class="form-control">{{old('content', optional($post ?? null)->content)}}</textarea>
</div>
@error('content')
    <div class="alert alert-danger">
        {{$message}}
    </div>
@enderror