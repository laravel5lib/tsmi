<?php

namespace App\Console\Commands;

use App\Article;
use App\Robot\Robot;
use Faker\Provider\Image;
use GuzzleHttp\Psr7\Response;
use Illuminate\Console\Command;

class DownloadImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Загрузка изображений';

    /**
     * @var \App\Robot\Robot
     */
    protected $robot;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->robot = new Robot();

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $articles = Article::whereNotNull('image')
            ->whereNull('local_image')
            ->whereBetween('created_at', [
                now()->subMinute(20),
                now(),
            ])
            ->pluck('image','id')
            ->toArray();

        dd($articles);

        $downloadImages = [];

        $this->robot = new Robot();
        $this->robot->browse($articles, function (Response $response, $id) use (&$articles,&$downloadImages) {

            dd($id,'1');

            $articles = array_map('array_values', $articles);

            $name = date("/Y/m/d/").sha1($articles[$id]) . '.'. pathinfo($articles[$id], PATHINFO_EXTENSION);

            $content = $response->getBody()->getContents();
            Image::image($content)->save(storage_path('public'.$name),75);
            $downloadImages[$id] = $name;
        },function ($test,$id){
            dd($id,'2');
        });

        dd($downloadImages);
    }
}
