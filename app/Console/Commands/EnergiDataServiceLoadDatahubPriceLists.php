<?php

namespace App\Console\Commands;

use App\Models\DatahubPriceList;
use App\Services\GetDatahubPriceLists;
use App\Services\GetEnergiDataServiceChargeGroups;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as CommandAlias;

class EnergiDataServiceLoadDatahubPriceLists extends Command
{
    public const INTEGRITY_CONSTRAINT_VIOLATION = 'SQLSTATE[23000]';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'energidata:request-and-store-datahub-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Requests all prices from EnergiDataService. Subarea for prices is called "Datahub Price List" at EnergiDataService. All data is stored to local data storage';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        /** @var GetDatahubPriceLists $datahubPriceListsService */
        $datahubPriceListsService = app(GetDatahubPriceLists::class);
        /** @var GetEnergiDataServiceChargeGroups $datahubChargeGroups */
        $datahubChargeGroups = app(GetEnergiDataServiceChargeGroups::class);

        $more = 1;
        $i = 0;
        $bar = $this->output->createProgressBar(266516);
        $bar->start();
        while ($more) {
            $records = $datahubPriceListsService->requestAllDatahubPriceListsFromEnergiDataService(100, $i);
            $data = [];
            foreach ($records as $record) {
                //GLN-number hack because energinet doesn't return gln number as they should
                $chargeOwner = $record['ChargeOwner'];
                try {
                    $gln = cache()->remember('ChargeOwner-' . $chargeOwner, 3600, function () use ($chargeOwner, $datahubChargeGroups) {
                        try {
                            $chargeGroup = $datahubChargeGroups->getChargeGroup($chargeOwner);
                        } catch (ModelNotFoundException $e) {
                            throw new RecordsNotFoundException(Str::replaceLast('.', '', $e->getMessage()) . ' with GridOperatorName: ' . $chargeOwner);
                        }

                        return substr($chargeGroup->grid_operator_gln, 0, -4);
                    });
                } catch (RecordsNotFoundException $e) {
                    logger()->warning($e->getMessage());
                    continue;
                }

                $data[] = [
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
                    'ResolutionDuration' => $record['ResolutionDuration']];
            }
            try {
                DatahubPriceList::insert($data);
            } catch (QueryException $e) {
                //We have seen that data from EnergiDataService wasn't as expected from documentation
                //The documentation states that ChargeType, ChargeTypeCode, Note, and ValidFrom are primary key for dataset
                //but that gives integrity violations for the primary key. Adding 'Note' to the primary key seems to fix this.
                //In case there is more to it, we'll handle integrity violations by writing a warning.
                if (Str::contains($e->getMessage(), self::INTEGRITY_CONSTRAINT_VIOLATION)) {
                    logger()->warning('Duplicate entry');
                    logger()->warning($e->getMessage());
                } else {
                    throw $e;
                }
            }
            $bar->advance(100);
            $i += 100;
            $more = count($records) !== 0;
        }
        $bar->finish();

        return CommandAlias::SUCCESS;
    }
}
