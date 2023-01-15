<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\OutputApiExceptionMessages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Tvup\EwiiApi\EwiiApi;
use Tvup\EwiiApi\EwiiApiException;
use Tvup\EwiiApi\EwiiApiInterface;

class EwiiGetConsumptionData extends Command
{
    use OutputApiExceptionMessages;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ewii:get-consumptiondata {--show-count=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all consumptions from Ewii for me';

    /**
     * @var EwiiApiInterface
     */
    private $ewiiApi;

    /**
     * @var bool
     */
    private $showAll;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EwiiApiInterface $ewiiApi)
    {
        $this->ewiiApi = $ewiiApi;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $showCount = $this->option('show-count');

        $rulesForShowCount = [
            'string' => 'in:ALL',
            'numeric' => 'integer',
        ];

        $rules = [
            'show-count' => ['required', $rulesForShowCount[$this->getShowCountType($showCount)]],
        ];

        $validator = Validator::make([
            'show-count' => $showCount,
        ], $rules);

        if ($validator->fails()) {
            $this->info('eloverblik:get-meter-data was not run. See errors below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;
        }

        $safeValues = $validator->validated();
        $optionShowCount = $safeValues['show-count'];

        switch ($optionShowCount) {
            case is_numeric($optionShowCount):
                break;
            case 'ALL':
                $this->showAll = true;
                break;
            default:
                $this->error('Show-count should either be a number or \'ALL\'');

                return 1;
        }

        /** @var EwiiApi $ewiiApi */
        $ewiiApi = $this->ewiiApi;
        if ($this->getOutput()->isVerbose()) {
            $ewiiApi->setDebug(true);
        }

        $email = config('services.ewii.email');
        $password = config('services.ewii.password');

        try {
            $ewiiApi->login($email, $password);
            $response = $ewiiApi->getAddressPickerViewModel();
            $ewiiApi->setSelectedAddressPickerElement($response);
            $response = $ewiiApi->getConsumptionMeters();
            $response = $ewiiApi->getConsumptionData('csv', $response);
        } catch (EwiiApiException $e) {
            $this->logExceptionApiMessages($e->getErrors(), 'Call to get consumption data from ewiiApi failed');

            return 1;
        }

        $outputTableArray = [];

        if ($response) {
            foreach ($response as $key => $value) {
                $outputTableArray[] = [$key, $value];
            }
            $this->table(['Time', 'Value'], $this->showAll ? $outputTableArray : array_slice($outputTableArray, 0, $optionShowCount));
        }
    }

    private function getShowCountType(mixed $showCount): string
    {
        if (filter_var($showCount, FILTER_VALIDATE_INT) !== false) {
            return 'numeric';
        } else {
            return gettype($showCount);
        }
    }
}
