<?php

namespace APOSite\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class ReportCreator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:report {class} {schema?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new set of files for a new type of report.';

    protected $reportStub = 'Models/Contracts/Report.stub';

    protected $reportFolder = 'Models/Contracts/Reports/';

    protected $transformerFolder = 'APOSite/Http/Transformers/';

    protected $transformerStub = 'Transformer.stub';

    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $class = $this->argument('class');
        $schema = $this->argument('schema');

        //Create the migration
//        $migrationCommand = 'make:migration:schema create_'.$class.'_table --schema=\"'.$schema.'\" --model=false';
//        Artisan::call($migrationCommand);

        //Create report model class from stub
        $modelStub = $this->files->get('./../../' . $this->reportStub);
        $name = ucwords(camel_case($class));
        $modelStub = str_replace('{{class}}', $name, $modelStub);
        $this->files->put(__DIR__ . '/../' . $this->reportFolder . $name, $modelStub);
    }

    private function snakeToCamelCase($val)
    {
        $val = rtrim($val, 's');
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
    }
}
