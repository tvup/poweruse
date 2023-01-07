<?php

namespace App\Console\Commands;

use App\Models\DatahubPriceList;
use App\Services\GetDatahubChargeGroups;
use App\Services\GetDatahubPriceLists;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\RecordsNotFoundException;

class LoadDataDatahubPriceLists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'energidata:load-datahub-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    private GetDatahubPriceLists $datahubPriceListsService;
    private GetDatahubChargeGroups $datahubChargeGroups;



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GetDatahubPriceLists $datahubPriceLists, GetDatahubChargeGroups $getDatahubChargeGroups)
    {
        $this->datahubPriceListsService = $datahubPriceLists;
        $this->datahubChargeGroups = $getDatahubChargeGroups;
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
        $i = 0;
        while ($more) {
            $records = $this->datahubPriceListsService->getAllDatahubTariffPriceLists(100, $i);
            foreach ($records as $record) {
                //GLN-number hack because energinet doesn't return gln number as they should
                $chargeOwner = $record['ChargeOwner'];
                $gln = cache()->remember('ChargeOwner-' . $chargeOwner, 3600, function () use ($chargeOwner) {
                    try {
                        $chargeGroup = $this->datahubChargeGroups->getChargeGroup($chargeOwner);
                    } catch (ModelNotFoundException $e) {
                        dump($e->getMessage() . ' with GridOperatorName = ' . $chargeOwner);
                        return '';
                    }
                    return substr($chargeGroup->grid_operator_gln, 0, -4);
                });
                try {
                    DatahubPriceList::create([

                        'ChargeOwner' => $record['ChargeOwner'],
                        'GLN_Number' => $gln,
                        'ChargeType' => $record['ChargeType'],
                        'ChargeTypeCode' => $record['ChargeTypeCode'],
                        'Note' => $record['Note'],
                        'Description' => $record['Description'],
                        'ValidFrom' => $record['ValidFrom'],
                        'ValidTo' => $record['ValidTo'],
                        'VATClass' => $record['VATClass'],
                        'Price1' => $record['Price1'],
                        'Price2' => $record['Price2'],
                        'Price3' => $record['Price3'],
                        'Price4' => $record['Price4'],
                        'Price5' => $record['Price5'],
                        'Price6' => $record['Price6'],
                        'Price7' => $record['Price7'],
                        'Price8' => $record['Price8'],
                        'Price9' => $record['Price9'],
                        'Price10' => $record['Price10'],
                        'Price11' => $record['Price11'],
                        'Price12' => $record['Price12'],
                        'Price13' => $record['Price13'],
                        'Price14' => $record['Price14'],
                        'Price15' => $record['Price15'],
                        'Price16' => $record['Price16'],
                        'Price17' => $record['Price17'],
                        'Price18' => $record['Price18'],
                        'Price19' => $record['Price19'],
                        'Price20' => $record['Price20'],
                        'Price21' => $record['Price21'],
                        'Price22' => $record['Price22'],
                        'Price23' => $record['Price23'],
                        'Price24' => $record['Price24'],
                        'TransparentInvoicing' => $record['TransparentInvoicing'],
                        'TaxIndicator' => $record['TaxIndicator'],
                        'ResolutionDuration' => $record['ResolutionDuration']]);

                } catch (QueryException $e) {
                    if($e->getCode() == 23000) {
                        //NOP
                    } else {
                        throw $e;
                    }
                }
            }

            $i = $i + 100;
            $more = count($records) != 0;
            $newone++;
        }
        dump('$newone: ' . $newone);
        return Command::SUCCESS;

    }
}
