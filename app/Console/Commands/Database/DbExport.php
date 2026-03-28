<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbExport extends Command
{
    /**
     * @var string
     */
    protected $signature = 'db:export
        {--tables= : Comma-separated list of tables to export (default: all data tables)}';

    /**
     * @var string
     */
    protected $description = 'Exports database tables to CSV files in database/fixtures for backup before data reload';

    /** @var array<string> */
    private array $defaultTables = [
        'elspotprices',
        'metering_points',
        'charges',
        'charge_prices',
        'charge_groups',
        'datahub_price_lists',
        'users',
    ];

    public function handle(): int
    {
        $tables = $this->option('tables')
            ? explode(',', $this->option('tables'))
            : $this->defaultTables;

        $fixturesPath = database_path('fixtures');

        foreach ($tables as $table) {
            $table = trim($table);

            try {
                $count = DB::table($table)->count();
            } catch (\Illuminate\Database\QueryException $e) {
                $this->error("Table {$table} does not exist");

                return Command::FAILURE;
            }

            if ($count === 0) {
                $this->warn("Skipping {$table} — table is empty");
                continue;
            }

            $outputFile = $fixturesPath . '/poweruse-' . $table . '.csv';
            $this->info("Exporting {$table} ({$count} rows) to {$outputFile}");

            $handle = fopen($outputFile, 'w');
            if ($handle === false) {
                $this->error("Could not open {$outputFile} for writing");
                continue;
            }

            foreach (DB::table($table)->get() as $row) {
                /** @var array<string, mixed> $fields */
                $fields = array_map(function ($value) {
                    return $value === null ? 'NULL' : (string) $value;
                }, (array) $row);
                fputcsv($handle, $fields);
            }

            fclose($handle);
            $this->info("Exported {$table} successfully");
        }

        $this->newLine();
        $this->info('Export complete. Files saved to ' . $fixturesPath);

        return Command::SUCCESS;
    }
}
