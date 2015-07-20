<?php

namespace APOSite\Jobs;

use APOSite\Http\Controllers\EventPipelineController;
use APOSite\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailer;

class ProcessEvent extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $reportID;
    protected $reportType;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $type)
    {
        $this->reportID = $id;
        $this->reportType = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $eventController = new EventPipelineController();
        $class = $eventController->getClass($this->reportType);
        $report = $class->getMethod('find')->invoke(null,$this->reportID);
        if($report == null){
            Log::error('Unable to process report of type '.$this->reportType . ' with id ' . $this->reportID);

        } else {
            //Process the event for the contract that each connected user is currently on.

        }
    }
}
