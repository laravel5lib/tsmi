<?php

namespace App\Observers;

use App\Source;
use Illuminate\Support\Facades\Storage;

class SourceObserver
{

    /**
     * @param \App\Source $source
     */
    public function creating(Source $source){
        $url = parse_url($source->rss);
        $url = $url['host'];
        $source->host = $url;
        $source->title = $url;
    }

    /**
     * Handle to the source "created" event.
     *
     * @param  \App\Source  $source
     * @return void
     */
    public function created(Source $source)
    {
        $url = parse_url($source->rss);
        $url = $url['host'];

        $file = file_get_contents('https://www.google.com/s2/favicons?domain='.$url);
        $name = 'favicons/'.$url.'.png';

        Storage::disk('public')->put($name, $file);
        $source->logo = $name;
        $source->host = $url;
        $source->save();
    }

    /**
     * Handle the source "updated" event.
     *
     * @param  \App\Source  $source
     * @return void
     */
    public function updated(Source $source)
    {
        //
    }

    /**
     * Handle the source "deleted" event.
     *
     * @param  \App\Source  $source
     * @return void
     */
    public function deleted(Source $source)
    {
        //
    }
}
