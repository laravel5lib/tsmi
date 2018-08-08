<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearImageCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удалить старые изображения';

    /**
     * @var
     */
    protected $storage;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->storage = Storage::disk('public');

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }

    /**
     *
     */
    public function clearEmptyDirectory()
    {
        $directories = $this->storage->allDirectories();
        foreach ($directories as $directory){
            if($this->storage->allFiles($directory)){
                $this->storage->deleteDirectory($directory);
            }
        }
    }
}
