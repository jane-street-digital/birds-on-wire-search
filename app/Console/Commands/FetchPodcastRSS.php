<?php

namespace App\Console\Commands;

use App\Models\Podcast;
use Illuminate\Console\Command;

class FetchPodcastRSS extends Command
{
    protected $signature = 'rss:podcast';

    protected $description = 'Fetches RSS content and inserts it into respective tables.';

    public function handle()
    {
        $response = \Illuminate\Support\Facades\Http::get('https://birdsonawiremoms.com/podcast?format=rss');
        $results = $response->body();
        $xml = simplexml_load_string($results);

        Podcast::truncate();

        foreach ($xml->channel->item as $item) {
            Podcast::create([
                'name' => $item->title,
                'description' => (string) $item->description,
                'link' => $item->link,
                'thumbnail' => $item->thumbnail,
            ]);
        }

        $this->info('RSS content has been inserted into the respective tables.');
    }
}
