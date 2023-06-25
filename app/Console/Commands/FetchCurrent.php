<?php

namespace App\Console\Commands;

use App\Models\Post;
use \Illuminate\Support\Facades\Http;


use Illuminate\Console\Command;

class FetchCurrent extends Command
{
    protected $signature = 'rss:fetch-current';

    protected $description = 'Fetch current data by using the most current rss feed';

    public function handle()
    {

        $blogResponse = HTTP::get('https://birdsonawiremoms.com/blog?format=rss');
        $blogResults = $blogResponse->body();
        $blogData = simplexml_load_string($blogResults);

        foreach ($blogData->channel->item as $item) {
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

        $podcastResponse = Http::get('https://birdsonawiremoms.com/podcast?format=rss');
        $podcastResults = $podcastResponse->body();
        $podcastData = simplexml_load_string($podcastResults);

        foreach ($podcastData->channel->item as $item) {
            try {
                Post::create([
                    'title' => $item->title,
                    'description' => (string) $item->description,
                    'link' => $item->link,
                    'published_at' => $item->pubDate,
                    'thumbnail' => $item->thumbnail,
                    'category' => 'Podcast',
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        $this->info('Current rss content has been inserted into its respective table.');
    }
}
