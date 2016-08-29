<?php

namespace APOSite\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use SSH;
use App;
use DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UpdateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apo:database {--test}';

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
        global $fileLoc;
	if(!App::environment('local')){
		$this->error("This command is to be run in development enviroments only.");
		return;
	}

	$fileName = str_replace(' ', '_','APODump_'.env('APO_SERVER_USERNAME').'_'.Carbon::now()->toDateTimeString().'.sql');
	$localFileName = './backups/'.$fileName;

	if(!$this->option('test')){
		$dumpLoc = env('APO_REMOTE_DUMP_LOCATION');
		if(substr($dumpLoc,-1)!=='/'){
			$this->error("The remote dump location does not have a trailing slash.\nPlease check the environment variable APO_REMOTE_DUMP_LOCATION.");
			return;
		}
		//Some error prevention here - check and make sure the path is valid.

		$remoteFileName = $fileName;
		$exportCommand = 'mysqldump -u '.env('APO_SERVER_DB_USERNAME',null).' -p'.env('APO_SERVER_DB_PASSWORD',null).' '.env('APO_SERVER_DATABASE',null).' > ' . $fileName;
		$this->info('Exporting database on server...');
		SSH::into('APO')->run([
		    'cd '.$dumpLoc,
		    $exportCommand
		],function($line) use (&$fileLoc){
			//Check for errors here. 
		});
		$this->info('Remote file: '.$fileLoc.$fileName);
		$this->info('Copying dump to local filesystem...');
		SSH::into('APO')->get($remoteFileName,$localFileName);
		$this->info('Copied to: '.$localFileName);
	} else {
		$localFileName = "./databases/APODumpTest.sql";	
	}
	$this->info('Destroying schema...');
	$destroyProcess = new Process("mysql -u ".env('DB_USERNAME')." -p".env('DB_PASSWORD')." -e 'drop schema if exists ".env('DB_DATABASE')."'"); 
	$destroyProcess->run();
	if(!$destroyProcess->isSuccessful()){
		$this->error('Unable to destroy the existing database.');
		return;
	}
	$this->info('Recreating schema...');
	$createProcess = new Process("mysql -u ".env('DB_USERNAME')." -p".env('DB_PASSWORD')." -e 'create schema ".env('DB_DATABASE')."'"); 
	$createProcess->run();	
	if(!$createProcess->isSuccessful()){
		$this->error('Unable to recreate the database schema.');
		return;
	}
	$this->info('Importing data...');
	$importCMD = "mysql -u ".env("DB_USERNAME")." -p".env("DB_PASSWORD")." ".env("DB_DATABASE")." < ".$localFileName;
	$importProcess = new Process($importCMD);
	$importProcess->run();
	if(!$importProcess->isSuccessful()){
		$this->error('Unable to import the backup.');
		echo $importProcess->getOutput();
		return;
	}
	$this->info('Import complete.');
    }
}
