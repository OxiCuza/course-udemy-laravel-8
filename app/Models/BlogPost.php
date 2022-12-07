<?php

namespace App\Models;

use App\Scopes\AdminDeletedScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes, Taggable;

    protected $fillable = [
        'title', 'content', 'user_id'
    ];

    public static function boot()
    {
        static::addGlobalScope(new AdminDeletedScope);

        parent::boot();

        //        static::addGlobalScope(new LatestScope);

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });

        static::updating(function (BlogPost $blogPost) {
            Cache::forget("blog-post-$blogPost->id");
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->descOrder();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    //    SCOPE QUERY
    public function scopeDescOrder(Builder $query)
    {
        return $query->orderByDesc(static::CREATED_AT);
    }

    public function scopeMostCommented(Builder $query)
    {
        # return attribute comments_count
        return $query->withCount('comments')->orderByDesc('comments_count');
    }
}
