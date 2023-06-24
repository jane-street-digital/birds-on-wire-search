<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory;
    use Searchable;


    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function searchableAs(): string
    {
        return 'posts_index';
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->title,
            'link' => $this->link,
            'published_at' => $this->published_at,
            'category' => $this->category,
        ];
    }
}
