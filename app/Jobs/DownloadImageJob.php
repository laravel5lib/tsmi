<?php

namespace App\Jobs;

use App\Article;
use App\Group;
use App\Robot\Robot;
use GuzzleHttp\Psr7\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DownloadImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Group
     */
    protected $group;

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $storage;

    /**
     * @var false|string
     */
    protected $date;

    /**
     * Create a new job instance.
     *
     * DownloadImageJob constructor.
     *
     * @param \App\Group $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
        $this->storage = Storage::disk('public');
        $this->date = date("/Y/m/d/");

        //$this->storage->isDirectory($this->date) or
        //$this->storage->makeDirectory($this->date, 0777, true, true);
    }

    /**
     * Execute the job.
     *
     * @param \App\Robot\Robot $robot
     */
    public function handle(Robot $robot)
    {
        $articles = Article::whereNotNull('image')
            ->whereIn('id', array_keys($this->group->news))
            ->get();

        $robot->browse($articles->pluck('image', 'id')->toArray(), function (Response $response, $id) use ($articles) {

            $article = $articles[$id];

            $content = $response->getBody()->getContents();

            $extension = pathinfo($article->getAttribute('image'), PATHINFO_EXTENSION);

            $name = $this->date . "{$article->getAttribute('id')}.{$extension}";

            $this->storage->put($name, $content);
            $article->local_image = $name;
            $article->save();
        });

    }
}
