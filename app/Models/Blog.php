<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Blog extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    public function searchableAs(): string
    {
        return 'blogs_index';
    }

    public function toSearchableArray()
    {
        /**
         * Get the indexable data array for the model.
         *
         * @return array<string, mixed>
         */
        $array = $this->toArray();
        return [
            'id' => $this->getKey(),
            'title' => $array['title'],
            'description' => $array['description'],
            'link' => $array['link'],
            'pubDate' => $array['pubDate'],
            'blog' => $array['blog']
        ];
    }
}
