<?php

namespace App\Console\Commands;

use App\Services\GetSmartMeMeterData;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
     * @var int|string
     */
    private $showCount;
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
        $start_date = $this->option('start-date');
        if (!$start_date) {
            $start_date = Carbon::now('Europe/Copenhagen')->startOfHour();
        }
        $this->option('show-count');
        $optionShowCount = $this->option('show-count');
        switch ($optionShowCount) {
            case is_numeric($optionShowCount):
                $this->showCount = $optionShowCount;
                break;
            case 'ALL':
                $this->showAll = true;
                break;
            default:
                $this->error('Show-count should either be a number of \'ALL\'');
                return 1;
        }

        $getSmartMeMeterData = new GetSmartMeMeterData();
        $array = $getSmartMeMeterData->getInterval($start_date);
        $returnArray = array();
        if ($array) {
            foreach($array as $key => $value) {
                array_push($returnArray, [$key, $value]);
            }
            $this->table(['Time' , 'Value'], $this->showAll ? $returnArray : array_slice($returnArray, 0, $this->showCount));
            if(!$this->showAll) {
                $this->info('(..) table output truncated');
            }
        }

    }
}
