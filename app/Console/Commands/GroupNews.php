<?php

namespace App\Console\Commands;

use App\Group;
use Illuminate\Console\Command;

class GroupNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Группирует новости';

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
        $group = new Group();
        $group->updateGroupTime();
    }
}
