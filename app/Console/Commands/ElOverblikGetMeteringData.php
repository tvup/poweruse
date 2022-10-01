<?php

namespace App\Console\Commands;

use App\Services\GetMeteringData;
use Illuminate\Console\Command;
use Tvup\ElOverblikApi\ElOverblikApiException;

class ElOverblikGetMeteringData extends Command
{
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

    private $meteringDataService;

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
     * @return mixed
     */
    public function handle()
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
            $response = $this->meteringDataService->getData(null, $this->option('start-date'), $this->option('end-date'), $this->getOutput()->isVerbose());
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
    }

    /**
     * @param $response
     * @return array
     */
    private function output($response): array
    {
        $returnArray = array();
        foreach ($response as $key => $value) {
            array_push($returnArray, [$key, $value]);
        }
        $this->table(['Time', 'Value'], $this->showAll ? $returnArray : array_slice($returnArray, 0, $this->showCount));
        if (!$this->showAll) {
            $this->info('(..) table output truncated');
        }
        return $returnArray;
    }

}
