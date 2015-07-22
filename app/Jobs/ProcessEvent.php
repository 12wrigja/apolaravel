<?php

namespace APOSite\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\App;
use APOSite\Models\Requirement;
use APOSite\Models\Filter;
use Mail;

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
    public function handle()
    {
        $report = App::call($this->reportType.'@query')->find($this->reportID);
        if($report == null){
            $errorText = 'Unable to process report of type '.$this->reportType . ' with id ' . $this->reportID;
            Log::error($errorText);
            Mail::raw($errorText,function($message){
                $message->to(env('ADMIN_EMAIL','webmaster@apo.case.edu'));
                $message->subject('Report Processing Error');
            });
        } else {
            //Process the event for the contract that each connected user is currently on.
            $requirements = Requirement::all();
            foreach($requirements as $requirementIndex=>$requirement){
                $filters = $requirement->filters;
                foreach($filters as $filterIndex=>$filter){
                    if($filter->validate($report)){
                        $requirement->Reports()->attach($report);
                    }
                }
            }
        }


    }
}
