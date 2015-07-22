<?php

namespace APOSite\Jobs;

use APOSite\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class ProcessEventJobThing extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
