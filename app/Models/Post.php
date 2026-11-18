<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',     
        'views_count',
    ];

    protected $casts = [
        'views_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'published');
    }
    public function scopeDrafts(Builder $query): void
    {
        $query->where('status', 'draft');
    }

    public function scopePopular(Builder $query): void
    {
        $query->orderBy('views_count', 'desc');
    }
}