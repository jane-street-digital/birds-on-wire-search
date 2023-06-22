<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Podcast;
use Illuminate\Console\Command;
use \Illuminate\Support\Facades\Http;


class FetchHistory extends Command
{
    protected $signature = 'rss:fetch-history';

    protected $description = 'Command description';

    public function handle()
    {
        $endDate = now();
        $startDate = now()->subYears(1);

        while ($endDate >= $startDate) {
            $offset = $endDate->timestamp * 1000;

            $blogResponse = HTTP::get('https://birdsonawiremoms.com/blog?offset=' . $offset . '&format=rss');
            $blogResults = $blogResponse->body();
            $blogData = simplexml_load_string($blogResults);

            $podcastResponse = Http::get('https://birdsonawiremoms.com/podcast?offset=' . $offset . '&format=rss');
            $podcastResults = $podcastResponse->body();
            $podcastData = simplexml_load_string($podcastResults);

            foreach ($blogData->channel->item as $item) {
                try {
                    Blog::create([
                        'title' => $item->title,
                        'description' => (string) $item->description,
                        'link' => $item->link,
                        'pubDate' => $item->pubDate,
                        'thumbnail' => $item->thumbnail,
                    ]);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }

            foreach ($podcastData->channel->item as $item) {
                try {
                    Podcast::create([
                        'title' => $item->title,
                        'description' => (string) $item->description,
                        'link' => $item->link,
                        'pubDate' => $item->pubDate,
                        'thumbnail' => $item->thumbnail,
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
