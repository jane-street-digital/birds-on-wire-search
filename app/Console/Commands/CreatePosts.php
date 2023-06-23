<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Podcast;
use App\Models\Post;
use Illuminate\Console\Command;

class CreatePosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:create-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $blog = Blog::get();
        $podcast = Podcast::get();
        $posts = $blog->concat($podcast);

        foreach ($posts as $post) {
            Post::create([
                'title' => $post->title,
                'description' => (string) $post->description,
                'link' => $post->link,
                'pubDate' => $post->pubDate,
                'thumbnail' => $post->thumbnail,
                'category' => 'test',
            ]);
        }
        $this->info('Posts table has been filled');
    }
}
