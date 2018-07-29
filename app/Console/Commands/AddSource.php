<?php

namespace App\Console\Commands;

use App\Source;
use Illuminate\Console\Command;

class AddSource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:source {rss}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавить источник';

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
        Source::updateOrCreate([
            'rss' => $this->argument('rss')
        ],[
            'rss' => $this->argument('rss')
        ]);
    }
}
