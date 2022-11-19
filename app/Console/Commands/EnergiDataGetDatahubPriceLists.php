<?php

namespace App\Console\Commands;

use App\Models\DatahubPriceList;
use App\Services\GetDatahubPriceLists;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

/**
 * Example: energidata:get-datahub-prices --operator="Radius Elnet A/S" --charge-type=D01 --charge-type-code=DA_A_F_01 --note="Netabo A0 forbrug" --start-date=2023-01-01
 */
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

        $validator = Validator::make([
            'operator' => $this->option('operator'),
            'charge-type' => $this->option('charge-type'),
            'charge-type-code' => $this->option('charge-type-code'),
            'note' => $this->option('note'),
            'start_date' => $this->option('start-date'),
            'end_date' => $this->option('end-date'),
        ], [
            'operator' => ['required','string'],
            'charge-type' => ['required','in:D01,D02,D03'],
            'charge-type-code' => ['required'],
            'note' => ['string', 'required'],
            'start_date' => ['required','date_format:Y-m-d'],
            'end_date' => ['nullable','date_format:Y-m-d','after:start_date'],
        ]);

        if ($validator->fails()) {
            $this->info('calculate:invoice was not run. See errors below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $safeValues = $validator->validated();

        $operator = $safeValues['operator'];;
        $chargeType = $safeValues['charge-type'];
        $chargeTypeCode = $safeValues['charge-type-code'];
        $note = $safeValues['note'];
        $startDate = $safeValues['start_date'];
        $endDate = $safeValues['end_date'];


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
