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
        $endDate = now(); // Current date
        $startDate = now()->subYears(3); // 3 years ago

        while ($endDate >= $startDate) {
            $offset = $endDate->timestamp * 1000;

            $response = \Illuminate\Support\Facades\Http::get('https://birdsonawiremoms.com/blog?offset=' . $offset . '&format=rss');
            $results = $response->body();
            $xml = simplexml_load_string($results);

            foreach ($xml->channel->item as $item) {
                Podcast::create([
                    'name' => $item->title,
                    'description' => (string) $item->description,
                    'link' => $item->link,
                    'thumbnail' => $item->thumbnail,
                ]);
            }

            $this->info('RSS content for ' . $endDate->format('Y-m') . ' has been inserted into the respective tables.');

            // Move to the previous month
            $endDate->subMonth();
        }

        $this->info('RSS content has been inserted for all months.');
    }
}
