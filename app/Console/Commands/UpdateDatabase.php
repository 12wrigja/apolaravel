<?php

namespace APOSite\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use SSH;

class UpdateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apo:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets your database to be the exact same as the database from the apo server.';

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
        $fileLoc = null;
        $fileName = str_replace(' ', '_','~/APODump'.Carbon::now()->toDateTimeString().'.sql');
        $localFileName = './'.substr($fileName,2);
        $exportCommand = 'mysqldump -u '.env('DB_USERNAME',null).' -p'.env('DB_PASSWORD',null).' '.env('APO_SERVER_DATABASE',null).' > ' . $fileName;
        SSH::into('APO')->run([
            'pwd',
            $exportCommand
        ],function($line) use ($fileLoc){
            if($fileLoc == null){
                $fileLoc = $line;
            }
            $this->info($line);
        });
        SSH::into('APO')->get($fileName,$localFileName);
        $this->info('Exported to: '.$localFileName);
    }
}
