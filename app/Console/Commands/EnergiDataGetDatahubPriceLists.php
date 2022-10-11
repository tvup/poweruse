<?php

namespace App\Console\Commands;

use App\Models\DatahubPriceList;
use App\Services\GetDatahubPriceLists;
use Illuminate\Console\Command;

class EnergiDataGetDatahubPriceLists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'energidata:get-datahub-prices '
    . '{--operator= : Name of the operator to query prices for} '
    . '{--charge-type= : The type of charge to query for. One of: D01=Subscription, D02=Fee, D03=Tariff} '
    . '{--charge-type-code= : The code of the charge type to query for} '
    . '{--note= : The text that represents the note of the tariff in question} '
    . '{--start-date= : The date from which the price should be valid}'
    . '{--end-date= : The date to which the price should be valid}'
    . '{--save-to-db : Save to database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get price-lists from datahub';

    private GetDatahubPriceLists $datahubPriceListsService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GetDatahubPriceLists $datahubPriceListsService)
    {
        $this->datahubPriceListsService = $datahubPriceListsService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $returnCode = 0;
        $operator = $this->option('operator');
        if (!$operator) {
            $this->error('Operator cannot be empty');
            return 1;
        }

        $chargeType = $this->option('charge-type');
        if (!$chargeType || !in_array($chargeType, ['D01', 'D02', 'D03'])) {
            $this->error('Charge type cannot be empty and must be one of D01, D02, or D03');
            return 1;
        }

        $chargeTypeCode = $this->option('charge-type-code');
        if (!$chargeTypeCode) {
            $this->error('Charge type code cannot be empty');
            return 1;
        }

        $note = $this->option('note');
        if (!$note) {
            $this->error('Note cannot be empty');
            return 1;
        }

        $startDate = $this->option('start-date');
        if (!$startDate) {
            $this->error('Start-date cannot be empty');
            return 1;
        }

        $endDate = $this->option('end-date');

        $records = $this->datahubPriceListsService->getDatahubTariffPriceLists($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate);
        $this->table(array_keys($records[0]), array_values($records));
        if ($this->option('save-to-db')) {
            foreach ($records as $record) {
                /** @var DatahubPriceList $datahubPriceList */
                $datahubPriceList = new DatahubPriceList();
                $datahubPriceList->fill($record);
                if (!$datahubPriceList->getMatchingInDb()) {
                    $datahubPriceList->save();
                } else {
                    $this->warn('Price existed already in database - record wasn\'t saved: ');
                    $this->line('GLN_Number    : ' . $datahubPriceList->GLN_Number . PHP_EOL
                        . 'ChargeType    : ' . $datahubPriceList->ChargeType . PHP_EOL
                        . 'ChargeTypeCode: ' . $datahubPriceList->ChargeTypeCode . PHP_EOL
                        . 'Note          : ' . $datahubPriceList->Note . PHP_EOL
                        . 'ValidFrom     : ' . $datahubPriceList->ValidFrom . PHP_EOL
                        . 'ValidTo       : ' . $datahubPriceList->ValidTo . PHP_EOL);
                    $returnCode = 1;
                }
            }
        }
        return $returnCode;
    }
}
