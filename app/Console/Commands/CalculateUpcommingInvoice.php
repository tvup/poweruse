<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\OutputApiExceptionMessages;
use App\Services\GetPreliminaryInvoice;
use Illuminate\Console\Command;

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
     *½
     * @return mixed
     */
    public function handle()
    {
        $refreshToken = $this->argument('refresh_token') ? : config('services.energioverblik.refresh_token');
        $start_date = $this->option('start-date');
        $end_date = $this->option('end-date');
        $smartMe = $this->option('smartme');
        $price_area = $this->option('price-area');
        $dataSource = 'DATAHUB';
        $ewiiCredentials = [
            'ewiiEmail' => '',
            'ewiiPassword' => ''
        ];

        $bill = $this->preliminaryInvoiceService->getBill($start_date, $end_date, $price_area, $smartMe, $dataSource, $refreshToken, $ewiiCredentials);

        $this->line(json_encode($bill, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT));
    }
}
