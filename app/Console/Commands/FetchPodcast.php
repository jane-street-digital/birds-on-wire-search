<?php

namespace App\Console\Commands;

use App\Models\Podcast;
use \Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;

class FetchPodcast extends Command
{
    protected $signature = 'rss:podcast';

    protected $description = 'Fetches RSS content and inserts it into respective tables.';

    public function handle()
    {
        $response = Http::get('https://birdsonawiremoms.com/blog?&format=rss');
        $results = $response->body();
        $data = simplexml_load_string($results);

        foreach ($data->channel->item as $item) {
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

        $this->info('RSS content has been inserted into the respective table.');
    }
}
