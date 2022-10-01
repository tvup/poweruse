<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;

class DbDrop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:drop {database? :  Drop only specific database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drops databases and recreates them again';

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
        $defaultDatabaseConnectionName = config('database.default');
        $databaseName = config('database.connections.' . $defaultDatabaseConnectionName. ' . database');
        if (config('env') =='production') {
            $this->warn('Warning! Application in production. Proceed?');
            $choice = $this->choice('Yes/No', array('Yes','No'), 0, 1);
            if ($choice == 'No') {
                $this->warn('Abort');
                return 1;
            }
            $this->dropDatabase($databaseName);
            return 0;
        }
        $this->dropDatabase($databaseName);
    }

    /**
     * Drop and create database specified by connection name.
     * @param $connection
     */
    private function dropDatabase($connection)
    {
        try {
            info('Dropping all tables in ' . $connection);

            $conn = \DB::connection();

            $colname = 'Tables_in_' . $connection;
            $tables = $conn->select('SHOW TABLES');
            $droplist = [];

            foreach ($tables as $table) {
                $droplist[] = $table->$colname;
            }

            if (count($droplist) > 0) {
                $droplist = implode(',', $droplist);
                $conn->statement('SET FOREIGN_KEY_CHECKS = 0');
                $conn->statement('DROP TABLE ' . $droplist);
                $conn->statement('SET FOREIGN_KEY_CHECKS = 1');
            }


        } catch (\Illuminate\Database\QueryException $e) {
            if (preg_match("/Unknown database/", $e->getMessage())) {
                $this->error(sprintf('Missing database %s', $connection));
            }
        }
    }

}
