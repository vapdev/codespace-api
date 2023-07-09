<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $fillable=[
        'title',
        'content',
        'user_id',
        'community_id',
        'is_published',
        'published_at',
        'slug'
    ];
}
