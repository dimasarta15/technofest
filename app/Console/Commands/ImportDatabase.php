<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class ImportDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import an SQL file into the current database';

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
     * @return int
     */
    public function handle()
    {
        $sqlPath = base_path('database/existing-data/mysql-technofest.sql');
        $sql = file_get_contents($sqlPath);

        DB::unprepared($sql);

        $this->info('Database imported successfully!');
    }
}
