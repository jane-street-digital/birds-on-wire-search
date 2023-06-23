<?php

namespace App\Console\Commands;

use App\Models\Podcast;
use Illuminate\Console\Command;

class FetchPodcast extends Command
{
    protected $signature = 'rss:podcast';

    protected $description = 'Fetches RSS content and inserts it into respective tables.';

    public function handle()
    {
        $endDate = now();
        $startDate = now()->subYears(1);

        while ($endDate >= $startDate) {
            $offset = $endDate->timestamp * 1000;

            $response = \Illuminate\Support\Facades\Http::get('https://birdsonawiremoms.com/podcast?offset=' . $offset . '&format=rss');
            $results = $response->body();
            $xml = simplexml_load_string($results);

            foreach ($xml->channel->item as $item) {
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

            // Move to the previous week
            $endDate->subWeek();
        }

        $this->info('RSS content has been inserted for all weeks.');
    }
}
