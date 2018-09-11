<?php

namespace App\Console\Commands;

use App\Article;
use App\Robot\Feed\Channel;
use App\Robot\Robot;
use App\Source;
use GuzzleHttp\Exception\RequestException;
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
     * @param \App\Robot\Robot $robot
     *
     * @return mixed
     */
    public function handle(Robot $robot)
    {
        $source = Source::all();
        $robot->browse($source->pluck('rss', 'id')->toArray(), function (Response $response, $id) use ($source) {
            $content = $response->getBody()->getContents();
            $channel = Channel::getItems($content, $source[$id]->id, now()->subMinute(5));
            Article::insert($channel);
            $source[$id]->save([
                'status'      => 'success',
                'last_update' => time(),
            ]);
            $this->line('Добавлено: ' . count($channel));
        }, function (RequestException $exception, $id) use ($source) {
            $source[$id]->save([
                'status_last_update' => 'fail',
                'last_update'        => time(),
            ]);
        });
    }

}
