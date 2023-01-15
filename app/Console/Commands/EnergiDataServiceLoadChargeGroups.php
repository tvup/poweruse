<?php

namespace App\Console\Commands;

use App\Models\ChargeGroup;
use App\Services\GetEnergiDataServiceChargeGroups;
use Illuminate\Console\Command;

class EnergiDataServiceLoadChargeGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'energidata:request-and-store-charge-groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Requests data about grid areas from EnergiDataService. Subarea is called "Charge Groups" at EnergiDataService. All data is stored to local data storage';

    private GetEnergiDataServiceChargeGroups $getDatahubChargeGroups;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GetEnergiDataServiceChargeGroups $datahubPriceLists)
    {
        $this->getDatahubChargeGroups = $datahubPriceLists;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $more = 1;
        $i = 0;
        while ($more) {
            $records = $this->getDatahubChargeGroups->requestChargeGroups(100, $i);
            foreach ($records as $record) {
                ChargeGroup::create([
                    'year' => substr($record['Year'], 0, 4),
                    'charge_group_1' => $record['ChargeGroup1'],
                    'charge_group_2' => $record['ChargeGroup2'],
                    'grid_operator_gln' => $record['GridOperatorGLN'],
                    'grid_operator_name' => $record['GridOperatorName'],
                    'number_of_metering_points' => $record['NumberMP'],
                    'consumption_kwh' => $record['ConsumptionkWh']]);
            }
            $i = $i + 100;
            $more = count($records) != 0;
        }

        return Command::SUCCESS;
    }
}
