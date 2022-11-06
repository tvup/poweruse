<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\OutputApiExceptionMessages;
use App\Services\GetMeteringData;
use Illuminate\Console\Command;
use Tvup\ElOverblikApi\ElOverblikApiException;

class ElOverblikGetMeteringData extends Command
{
    use OutputApiExceptionMessages;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eloverblik:get-meter-data {--start-date=} {--end-date=} {--show-count=10 : Number of rows to show. Use \'ALL\' to show everything}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get metering data from energioverblik';

    /**
     * @var int|string
     */
    private $showCount;
    /**
     * @var bool
     */
    private $showAll;

    private GetMeteringData $meteringDataService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GetMeteringData $meteringDataService)
    {
        $this->meteringDataService = $meteringDataService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws ElOverblikApiException
     */
    public function handle() : int
    {
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

        try {
            $response = $this->meteringDataService->getData($this->option('start-date'), $this->option('end-date'), null, $this->getOutput()->isVerbose());
        } catch (ElOverblikApiException $e) {
            if ($e->getCode() == 400) {
                $this->logExceptionApiMessages($e->getErrors(), 'Request for mertering data at eloverblik failed');
                return 1;
            }
            throw $e;
        }

        if ($response) {
            $this->output($response);
        }
        return 0;
    }

    /**
     * @param array<string, string> $response
     * @return array<int, array{string, string}>
     */
    private function output(array $response): array
    {
        $returnArray = [];
        foreach ($response as $dateKey => $quantity) {
            array_push($returnArray, [$dateKey, $quantity]);
        }
        $this->table(['Time', 'Value'], $this->showAll ? $returnArray : array_slice($returnArray, 0, $this->showCount));
        if (!$this->showAll) {
            $this->info('(..) table output truncated');
        }
        return $returnArray;
    }

}
