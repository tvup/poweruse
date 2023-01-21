<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\OutputApiExceptionMessages;
use App\Enums\SourceEnum;
use App\Services\GetPreliminaryInvoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CalculateUpcommingInvoice extends Command
{
    use OutputApiExceptionMessages;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:invoice {refresh_token?} {--start-date=2022-09-01} {--end-date=2022-10-01} {--price-area=DK2} {--smartme}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate prelimiary invoice';

    /**
     * @var GetPreliminaryInvoice
     */
    private $preliminaryInvoiceService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GetPreliminaryInvoice $getPreliminaryInvoiceService)
    {
        $this->preliminaryInvoiceService = $getPreliminaryInvoiceService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *½.
     * @return mixed
     */
    public function handle()
    {
        $dataSource = SourceEnum::DATAHUB;
        $ewiiCredentials = [
            'ewiiEmail' => '',
            'ewiiPassword' => '',
        ];

        $validator = Validator::make([
            'refresh_token' => $this->argument('refresh_token') ?: config('services.energioverblik.refresh_token'),
            'start_date' => $this->option('start-date'),
            'end_date' => $this->option('end-date'),
            'price-area' => $this->option('price-area'),
        ], [
            'refresh_token' => ['string'],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date_format:Y-m-d', 'after:start_date'],
            'price-area' => ['string', 'required'],
        ]);

        if ($validator->fails()) {
            logger()->info('calculate:invoice was not run. See errors below:');

            foreach ($validator->errors()->all() as $error) {
                logger()->error($error);
            }

            return 1;
        }

        $safeValues = $validator->validated();

        $refreshToken = $safeValues['refresh_token'];
        $start_date = $safeValues['start_date'];
        $end_date = $safeValues['end_date'];
        $price_area = $safeValues['price-area'];

        $smartMeCredentials = null;
        if ($this->option('smartme')) {
            $smartMeCredentials = [
                config('services.smartme.id'),
                config('services.smartme.username'),
                config('services.smartme.paasword')];
        }

        $bill = $this->preliminaryInvoiceService->getBill($start_date, $end_date, $price_area, $smartMeCredentials, $dataSource, $refreshToken, $ewiiCredentials);

        $outputLine = json_encode($bill, JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
        if ($outputLine) {
            $this->line($outputLine);
        }
    }
}
