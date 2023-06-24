<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Post;
use Illuminate\Console\Command;
use \Illuminate\Support\Facades\Http;

class FetchBlog extends Command
{
    protected $signature = 'rss:blog';

    protected $description = 'Fetches RSS content and inserts it into respective tables.';

    public function handle()
    {
        $response = HTTP::get('https://birdsonawiremoms.com/blog?format=rss');
        $results = $response->body();
        $data = simplexml_load_string($results);

        foreach ($data->channel->item as $item) {
            try {
                Post::create([
                    'title' => $item->title,
                    'description' => (string) $item->description,
                    'link' => $item->link,
                    'published_at' => $item->pubDate,
                    'thumbnail' => $item->thumbnail,
                    'category' => 'Blog',
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        $this->info('RSS content has been inserted into the respective table.');
    }
}
