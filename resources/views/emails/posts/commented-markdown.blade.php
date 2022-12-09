@component('mail::message')
# Commented was posted on your {{$comment->commentable->title}} blog post

Hi {{$comment->commentable->user->name}}

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id])])
View The Blog Post
@endcomponent

@component('mail::panel')
{{$comment->content}}
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id])])
Visit {{$comment->user->name}} profile
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
