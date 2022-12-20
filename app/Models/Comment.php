<?php

namespace App\Models;

use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Taggable;

    protected $fillable = [
        'content', 'user_id'
    ];

    protected $hidden = [
        'deleted_at', 'commentable_type', 'commentable_id', 'user_id'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //    SCOPE QUERY
    public function scopeDescOrder(Builder $query)
    {
        return $query->orderByDesc(static::CREATED_AT);
    }
}
