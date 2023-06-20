# Search App For birdsonawiremoms.com
1. Here is the repo you’ll use: `git@github.com:jane-street-digital/birds-on-wire-search.git`
2. Create a new Laravel App
	1. Podcast Model
	2. Blog Model
	3. You can create a model and migration at the same time
	4. example  `php artisan make:model -m Podcast`
3. Install Laravel Scout (Search package)
	1. Lets try the database driver
	2. [Laravel Scout - Laravel - The PHP Framework For Web Artisans](https://laravel.com/docs/10.x/scout#database-engine)
4. Create a command that gets the rss content and inserts into into the respectable table. Each job run we can probably truncate the whole table and reinsert it
	1. `php artisan make:command`
	2. Schedule the command `app/Console/Kernel.php` for `->daily()`
	3. Name, description, link to the post, and image thumb nail
5. You can parse the xml with this
```
$xml = file_get_contents($rssUrl);
$xml = simplexml_load_string($xml);

$json = json_encode($xml);

$array = json_decode($json,TRUE);
```
5. You only need one route for this project. So at the root `/` create a new search view and search controller that should be invoke-able (that’s a single method controller)
