<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
    <p>
        Hi {{$comment->commentable->user->name}}
    </p>
    <p>
        Someone has commented on your blog post
        <a href="{{route('posts.show', ['post' => $comment->commentable->id])}}">
            {{$comment->commentable->title}}
        </a>
    </p>
    <hr>
    <p>
        <img src="{{$message->embed(Storage::path($comment->user->image->path))}}" alt="">
        <a href="{{route('users.show', ['user' => $comment->user->id])}}">
            {{$comment->user->name}}
        </a> said :
    </p>
    <p>
        {{$comment->content}}
    </p>
</body>
</html>