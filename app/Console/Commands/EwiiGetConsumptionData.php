<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\OutputApiExceptionMessages;
use Illuminate\Console\Command;
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
     * @var int|string
     */
    private $showCount;
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
        $this->option('show-count');
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

        /** @var EwiiApi $ewiiApi */
        $ewiiApi = $this->ewiiApi;
        if($this->getOutput()->isVerbose()) {
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

        if ($response) {
            foreach($response as $key => $value) {
                $response[$key] = [array_keys($value)[0], array_values($value)[0]];
            }
            $this->table(['Time' , 'Value'], $this->showAll ? $response : array_slice($response, 0, $this->showCount));
        }

    }


}
