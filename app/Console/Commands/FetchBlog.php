<?php

namespace App\Console\Commands;

use App\Models\Blog;
use Illuminate\Console\Command;

class FetchBlog extends Command
{
    protected $signature = 'rss:blog';

    protected $description = 'Fetches RSS content and inserts it into respective tables.';

    public function handle()
    {
        $response = \Illuminate\Support\Facades\Http::get('https://birdsonawiremoms.com/blog?format=rss');
        $results = $response->body();
        $xml = simplexml_load_string($results);

        Blog::truncate();

        foreach ($xml->channel->item as $item) {
            Blog::create([
                'name' => $item->title,
                'description' => (string) $item->description,
                'link' => $item->link,
                'thumbnail' => $item->thumbnail,
            ]);
        }

        $this->info('RSS content has been inserted into the respective tables.');
    }
}
