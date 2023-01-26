<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;

class DbImport extends Command
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
    protected $description = 'Imports CSV-files to DB';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mysql_connection = 'database.connections.mysql';

        $mysql_host = config('database.connections.mysql.host');
        $csv_file = database_path('fixtures/poweruse_datahub_price_lists.csv');
        $csv_file2 = storage_path('poweruse_datahub_price_lists_null_handled.csv');

        if (file_exists($csv_file)) {
            $this->info('Importing CSV export from ' . $csv_file);

            //Replace text NULL with \N
            exec('sed \'s/NULL/\\\\N/g\' ' . $csv_file . ' > ' . $csv_file2);

            //Load file
            exec(sprintf(
                'mysql -h%s -u%s %s --local-infile %s -e "LOAD DATA LOCAL INFILE \'%s\'  INTO TABLE %s  FIELDS TERMINATED BY \',\' OPTIONALLY ENCLOSED BY \'\"\' LINES TERMINATED BY \'\\n\'"',
                $mysql_host,
                config($mysql_connection . '.username'),
                config($mysql_connection . '.password') != '' ? '-p\'' . config($mysql_connection . '.password') . '\'' : '',
                config($mysql_connection . '.database'),
                $csv_file2,
                'datahub_price_lists'
            ));
        }

        return Command::SUCCESS;
    }
}
