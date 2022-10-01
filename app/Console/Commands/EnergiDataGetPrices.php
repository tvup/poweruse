<?php

namespace App\Console\Commands;

use App\Services\GetSpotPrices;
use Illuminate\Console\Command;

class EnergiDataGetPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'energidata:get-prices {--start-date=} {--end-date=} {--area=DK2} {--show-count=10 : Number of rows to show. Use \'ALL\' to show everything}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get spot prices from energi data';

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

        $new = new GetSpotPrices();
        $array = $new->getData($this->option('start-date'),$this->option('end-date'),$this->option('area'));

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
