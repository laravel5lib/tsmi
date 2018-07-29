<?php

namespace App\Console\Commands;

use App\Article;
use App\Group;
use App\Robot\Feed\Channel;
use App\Robot\Robot;
use App\Source;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Console\Command;

/**
 * Class ParseNews
 */
class ParseNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Скачать новости';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $source = Source::all();

        $robot = new Robot();
        $robot->browse(
            $source->pluck('rss', 'id')->toArray()
            , function (Response $response, $id) use ($source) {
            $content = $response->getBody()->getContents();
            $lastUpdate = new Carbon();
            $lastUpdate->subMinute(5);
            $channel = Channel::getItems($content, $source[$id]->id, $lastUpdate);
            Article::insert($channel);
            $this->line('Добавлено: ' . count($channel));
        });
    }

}
