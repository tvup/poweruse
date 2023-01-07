<?php

namespace App\Console\Commands;

use App\Models\ChargeGroup;
use App\Services\GetDatahubChargeGroups;
use Illuminate\Console\Command;

class LoadEnergiDataHubChargeGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'energidata:load-datahub-charge-groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private GetDatahubChargeGroups $getDatahubChargeGroups;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GetDatahubChargeGroups $datahubPriceLists)
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
        $newone = 0;
        $i= 0;
        while ($more) {
            $records = $this->getDatahubChargeGroups->getDatahubChargeGroups(100, $i);
            foreach ($records as $record) {
                ChargeGroup::create([
                    'year' => substr($record['Year'], 0, 4),
                    'charge_group_1'=>$record['ChargeGroup1'],
                    'charge_group_2'=>$record['ChargeGroup2'],
                    'grid_operator_gln'=>$record['GridOperatorGLN'],
                    'grid_operator_name'=>$record['GridOperatorName'],
                    'number_of_metering_points'=>$record['NumberMP'],
                    'consumption_kwh'=>$record['ConsumptionkWh']]);
            }
            $i = $i + 100;
            $more = count($records) != 0;
            $newone++;
            dump($newone . ' '. count($records));
        }
        dump('$newone: ' . $newone);
        return Command::SUCCESS;
    }
}
