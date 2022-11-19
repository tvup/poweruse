<?php

namespace App\Console\Commands;

use App\Services\GetSmartMeMeterData;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class SmartMeGetMeterDataFromDateTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smartme:get-meter-data-from-time {--start-date= : The date to start from}  {--show-count=10 : Number of rows to show. Use \'ALL\' to show everything}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from smart-me from given date and onwards';

    /**
     * @var bool
     */
    private $showAll;

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
        $showCount = $this->option('show-count');

        $rulesForShowCount = [
            'string' => 'in:ALL',
            'numeric' => 'integer'
        ];

        $rules = [
            'start-date' => ['nullable', 'date_format:Y-m-d'],
            'show-count' => ['required', $rulesForShowCount[$this->getShowCountType($showCount)]],
        ];

        $validator = Validator::make([
            'start-date' => $this->option('start-date'),
            'show-count' => $showCount,
        ], $rules);

        if ($validator->fails()) {
            $this->info('eloverblik:get-meter-data was not run. See errors below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $safeValues = $validator->validated();
        $optionShowCount = $safeValues['show-count'];
        $start_date = $safeValues['start-date'];

        if (!$start_date) {
            $start_date = Carbon::now('Europe/Copenhagen')->startOfHour();
        }


        switch ($optionShowCount) {
            case is_numeric($optionShowCount):
                break;
            case 'ALL':
                $this->showAll = true;
                break;
            default:
                $this->error('Show-count should either be a number or \'ALL\'');
                return 1;
        }

        $getSmartMeMeterData = new GetSmartMeMeterData();
        $array = $getSmartMeMeterData->getInterval($start_date, null,  true);
        $returnArray = array();
        if ($array) {
            foreach ($array as $key => $value) {
                array_push($returnArray, [$key, $value]);
            }
            $this->table(['Time', 'Value'], $this->showAll ? $returnArray : array_slice($returnArray, 0, $optionShowCount));
            if (!$this->showAll) {
                $this->info('(..) table output truncated');
            }
        }

    }

    private function getShowCountType(mixed $showCount): string
    {
        if (filter_var($showCount, FILTER_VALIDATE_INT) !== false) {
            return 'numeric';
        } else {
            return gettype($showCount);
        }
    }
}
