<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Podcast;
use App\Models\Post;
use Illuminate\Console\Command;
use \Illuminate\Support\Facades\Http;


class FetchHistory extends Command
{
    protected $signature = 'rss:fetch-history';

    protected $description = 'Fetch historical data by using offsets';

    public function handle()
    {
        $endDate = now();
        $startDate = now()->subYears(7);

        while ($endDate >= $startDate) {
            $offset = $endDate->timestamp * 1000;

            $blogResponse = HTTP::get('https://birdsonawiremoms.com/blog?offset=' . $offset . '&format=rss');
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

            $podcastResponse = Http::get('https://birdsonawiremoms.com/podcast?offset=' . $offset . '&format=rss');
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

            $this->info('RSS content for ' . $endDate->format('Y-m-d') . ' has been inserted into the respective tables.');

            $endDate->subWeek();
        }

        $this->info('RSS content has been inserted for all weeks.');
    }
}
