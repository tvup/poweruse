<?php

namespace App\Console\Commands;

use App\Services\GetSpotPrices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

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
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date_format:Y-m-d', 'after:start_date'],
            'area' => ['string', 'required'],
            'show-count' => ['required', $rulesForShowCount[$this->getShowCountType($showCount)]],
        ];

        $validator = Validator::make([
            'start_date' => $this->option('start-date'),
            'end_date' => $this->option('end-date'),
            'area' => $this->option('area'),
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

        $start_date = $safeValues['start_date'];
        $end_date = $safeValues['end_date'];
        $area = $safeValues['area'];
        $optionShowCount = $safeValues['show-count'];

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

        $new = new GetSpotPrices();

        //The return-type of this call is array because of the missing format-parameter.
        //Casted for the sake of phpstan
        $array = (array)$new->getData($start_date, $end_date, $area);

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
