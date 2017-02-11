<?php

namespace APOSite\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;

class BackupToDrive extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {connection?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        // Get connection name to use
        $connection = $this->argument('connection');
        if (!isset($connection)) {
            $connection = config('database.default');
        }
        if (!isset($connection)) {
            $this->error('No default connection and no specified connection. Exiting.');
            return;
        }

        // Check the connection exists, and uses a db driver we know how to back up.
        $connections = config('database.connections');
        if (!array_key_exists($connection, $connections)) {
            $this->error('Invalid connection. Exiting.');
            return;
        }
        $key = $connection;
        $connection = $connections[$connection];

        $driver = $connection['driver'];
        if ($driver !== 'mysql') {
            $this->error('Unable to back up using driver' .
                         $driver .
                         '. Right now, we only know how to backup MySQL dbs.');
            return;
        }

        $this->info('Connecting with connection ' .
                    $key .
                    ', using driver ' .
                    $driver);

        $connSchema = $connection['database'];

        // Create the filename for this backup.
        $backupFileName = $connSchema .
                          '___backup_' .
                          str_replace(' ',
                                      '_',
                                      Carbon::now()
                                            ->toDateTimeString()) .
                          '.sql';

        $configuredDisks = config('filesystems.disks');
        if(!isset($configuredDisks['local'])){
            $this->error('Where is the \'local\' disk configuration?');
            return;
        }
        $localDisk = $configuredDisks['local'];
        $localDiskRoot = $localDisk['root'];

        $this->info('Creating local backup (' .
                    $backupFileName .
                    ') and storing it in ' .
                    $localDiskRoot);

        // Back up the database locally.
        $connUsername = $connection['username'];
        $connPassword = $connection['password'];

        $backupCommand =
            'mysqldump -u ' .
            $connUsername .
            ' -p' .
            $connPassword .
            ' ' .
            $connSchema .
            ' > ' .
            $localDiskRoot .'/'.
            $backupFileName;

        $backupProcess = new Process($backupCommand);
        $backupProcess->run();
        if (!$backupProcess->isSuccessful()) {
            $this->error('There was an error running the backup command. Exiting.');
            return;
        }

        // Local backup has completed at this point, so lets try and use Filesystem to transfer
        // this file!
        $localFileContents = Storage::disk('local')->get($backupFileName);
        Storage::disk('google')->put($backupFileName, $localFileContents);

        $this->info('Remote backup complete.');

        Storage::disk('local')->delete($backupFileName);
    }
}
