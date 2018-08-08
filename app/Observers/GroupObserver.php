<?php

namespace App\Observers;

use App\Group;
use App\Jobs\DownloadImageJob;

class GroupObserver
{
    /**
     * Handle to the source "saved" event.
     *
     * @param  \App\Group  $group
     * @return void
     */
    public function saved(Group $group)
    {
        dispatch(new DownloadImageJob($group));
    }

}
