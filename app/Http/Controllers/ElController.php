<?php

namespace App\Http\Controllers;

use App\Exceptions\DataUnavailableException;
use App\Models\Elspotprices;
use App\Models\GridOperatorNettariffProperty;
use App\Models\Operator;
use App\Services\GetDatahubPriceLists;
use App\Services\GetMeteringData;
use App\Services\GetPreliminaryInvoice;
use App\Services\GetSmartMeMeterData;
use App\Services\GetSpotPrices;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Tvup\ElOverblikApi\ElOverblikApiException;
use Tvup\EwiiApi\EwiiApiException;

class ElController extends Controller
{
    const TOKEN_FILENAME = 'eloverblik-token.serialized';

    /**
     * @var GetMeteringData
     */
    private $meteringDataService;
    /**
     * @var GetPreliminaryInvoice
     */
    private $preliminaryInvoiceService;

    /**
     * @var GetSpotPrices
     */
    private $spotPricesService;

    /**
     * @var GetSmartMeMeterData
     */
    private $smartMeMeterDataService;
    private GetDatahubPriceLists $datahubPriceListsService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GetMeteringData $meteringDataService, GetPreliminaryInvoice $preliminaryInvoiceService, GetSpotPrices $spotPricesService, GetSmartMeMeterData $smartMeMeterDataService, GetDatahubPriceLists $datahubPriceListsService)
    {
        $this->meteringDataService = $meteringDataService;
        $this->preliminaryInvoiceService = $preliminaryInvoiceService;
        $this->spotPricesService = $spotPricesService;
        $this->smartMeMeterDataService = $smartMeMeterDataService;
        $this->datahubPriceListsService = $datahubPriceListsService;
    }

    public function index() : View
    {
        $data = session('data');

        return view('el')->with('data', $data ? $data->original : null);
    }

    public function indexMeteringPoint() : View
    {
        $data = session('data');

        return view('el-meteringpoint')->with('data', $data ? : null);
    }

    public function indexCharges() : View
    {
        $data = session('data');

        return view('el-charges')->with('data', $data ? : null);
    }

    public function indexSpotprices() : View
    {
        $data = session('data');

        return view('el-spotprices')->with('data', $data ? : null);
    }

    public function indexConsumption() : View
    {
        $data = session('data');

        return view('consumption')->with('data', $data ? : null);
    }

    public function indexTotalPrices() : View
    {
        $data = session('data');
        $chart = session('chart');
        $companies = Operator::$operatorName;

        return view('el-totalprices')->with('data', $data ? : null)->with('chart', $chart ? : null)->with('companies', $companies);
    }

    public function indexCustomUsage() : View
    {
        $data = session('data');

        return view('el-custom')->with('data', $data ? : null);
    }

    public function processData(Request $request) : RedirectResponse|Response
    {
        try {
            switch ($request->de) {
                case 'on':
                    $dataSource = 'EWII';
                    break;
                default:
                    $dataSource = 'DATAHUB';
            }

            if($dataSource == 'DATAHUB' && !$request->token) {
                return redirect('el')->with('error', 'Failed - token cannot be empty when datahub is selected.')->withInput($request->all());
            }

            $smartMeCredentials = null;
            if ($request->smart_me == 'on') {
                $smartMeCredentials = array();
                $smartMeCredentials['username'] = $request->smartmeuser;
                $smartMeCredentials['password'] = $request->smartmepassword  ;
                $smartMeCredentials['id'] = $request->smartmeid;
            }
            $ewiiCredentials = [
                'ewiiEmail' => $request->ewiiEmail,
                'ewiiPassword' => $request->ewiiPassword
            ];


            $data = $this->getPreliminaryInvoice($request->token, $ewiiCredentials, $dataSource, $smartMeCredentials, $request->start_date, $request->end_date, $request->area, $request->subscription, $request->overhead);
        } catch (ElOverblikApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 429:
                case 500:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for mertering data at eloverblik failed</strong>' . '<br/>';
                    $message = $message . 'Datahub-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>'. $error['Code'] .'</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';
                    return redirect('el')->with('error', $message)->withInput($request->all());
                case 401:
                    return redirect('el')->with('error', 'Failed - cannot login with data-access token. MD5 of refresh token: ' . md5($request->token))->withInput($request->all());
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        } catch (EwiiApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 500:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for metering data at ewii failed</strong>' . '<br/>';
                    $message = $message . 'EWII-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>'. $error['Code'] .'</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';
                    return redirect('el')->with('error', $message)->withInput($request->all());
                case 2:
                    return redirect('el')->with('error', 'Failed - cannot login with ewii credentials.')->withInput($request->all());
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        } catch (DataUnavailableException $e) {
            return redirect('el')->with('error', $e->getMessage())->withInput($request->all());
        }
        return redirect('el')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all())->withCookie('refresh_token', $request->token, 5);
    }

    public function processCustom(Request $request) : RedirectResponse|Response
    {
        if(!$request->token) {
            return redirect('el-custom')->with('error', 'Failed - token cannot be empty is selected.')->withInput($request->all());
        }
        try {
            $fields = $request->all();
            $meterData = [];
            foreach ($fields as $key => $value) {
                if(strpos($key, 'usage') !== false) {
                    $timeslot = str_replace('usage', '', $key);
                    if(strlen($timeslot)==1) {
                        $timeslot = '0' . $timeslot . '';
                    }
                    $newKey = Carbon::now('Europe/Copenhagen')->toDateString() . 'T' . $timeslot . ':00:00';
                    $newValue = $value ? str_replace(',','.', $value) : null;
                    $meterData[$newKey] =($newValue ? : 0);
                }
            }
            $data = $this->getUsageCost($meterData, $request->token, $request->area, $request->overhead);
        } catch (ElOverblikApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 500:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for mertering data at eloverblik failed</strong>' . '<br/>';
                    $message = $message . 'Datahub-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>'. $error['Code'] .'</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';
                    return redirect('el')->with('error', $message)->withInput($request->all());
                case 401:
                    return redirect('el')->with('error', 'Failed - cannot login with data-access token. MD5 of refresh token: ' . md5($request->token))->withInput($request->all());
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        } catch (EwiiApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 500:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for metering data at ewii failed</strong>' . '<br/>';
                    $message = $message . 'EWII-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>'. $error['Code'] .'</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';
                    return redirect('el')->with('error', $message)->withInput($request->all());
                case 2:
                    return redirect('el')->with('error', 'Failed - cannot login with ewii credentials.')->withInput($request->all());
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        } catch (DataUnavailableException $e) {
            return redirect('el')->with('error', $e->getMessage())->withInput($request->all());
        }
        return redirect('el-custom')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
    }

    public function getMeteringPointData(Request $request) : RedirectResponse|Response
    {
        try {
            switch ($request->de) {
                case 'on':
                    $dataSource = 'EWII';
                    break;
                default:
                    $dataSource = 'DATAHUB';
            }
            switch ($dataSource) {
                case 'EWII':
                    $data = $this->meteringDataService->getMeteringPointDataFromEwii($request->ewiiemail, $request->ewiipassword);
                    break;
                case 'DATAHUB':
                    $data = $this->meteringDataService->getMeteringPointData($request->token);
                    break;
                default:
                    throw new \RuntimeException('Illegal provider for meteringdata given: ' . $dataSource);
            }


        } catch (ElOverblikApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for mertering-point data at eloverblik failed</strong>' . '<br/>';
                    $message = $message . 'Datahub-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>' . $error['Code'] . '</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';
                    return redirect('el-meteringpoint')->with('error', $message)->withInput($request->all());
                case 401:
                    return redirect('el-meteringpoint')->with('error', 'Failed - cannot login with token')->withInput($request->all());
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        }  catch (EwiiApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 500:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for metering-point data at ewii failed</strong>' . '<br/>';
                    $message = $message . 'EWII-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>'. $error['Code'] .'</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';
                    return redirect('el-meteringpoint')->with('error', $message)->withInput($request->all());
                case 2:
                    return redirect('el-meteringpoint')->with('error', 'Failed - cannot login with ewii credentials.')->withInput($request->all());
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        }
        return redirect('el-meteringpoint')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
    }

    public function get(string $refreshToken) : Response|JsonResponse
    {
        try {
            return $this->getPreliminaryInvoice($refreshToken);
        } catch (ElOverblikApiException | \InvalidArgumentException $e) {
            return response($e->getMessage(), $e->getCode(), ['Content-Type' => 'text/plain']);
        }
    }

    public function getWithSmartMe(string $refreshToken = null) : Response|JsonResponse
    {
        try {
            $smartMeCredentials = [
                config('services.smartme.id'),
                config('services.smartme.username'),
                config('services.smartme.paasword')];
            return $this->getPreliminaryInvoice($refreshToken, null, 'DATAHUB', $smartMeCredentials);
        } catch (ElOverblikApiException $exception) {
            $code = $exception->getCode();
            if($code==503 || $code==500) {
                try {
                    if($refreshToken != config('services.energioverblik.refresh_token')) {
                        logger('Can\'t try with fetching from ewii');
                        return response($exception->getMessage(), $code)
                            ->header('Content-Type', 'text/plain');
                    }
                    logger('Fetch by datahub failed - trying with ewii');
                    $ewiiCredentials = ['ewiiEmail' => config('services.ewii.email'), 'ewiiPassword' => config('services.ewii.password')];
                    return $this->getPreliminaryInvoice(null, $ewiiCredentials, 'EWII', $smartMeCredentials);
                } catch (EwiiApiException $exception) {
                    $code = $exception->getCode();
                }
            }
            return response($exception->getMessage(), $code)
                ->header('Content-Type', 'text/plain');
        }

    }

    public function getFromDate(string $start_date, string $end_date, string $price_area, string $refreshToken = null) : Response|JsonResponse
    {
        try {
            return $this->getPreliminaryInvoice($refreshToken, null, 'DATAHUB', null, $start_date, $end_date, $price_area);
        } catch (ElOverblikApiException $e) {
            if ($e->getCode() == 400) {
                $message = 'Request for mertering data at eloverblik failed' . PHP_EOL;
                $message = $message . 'Message: ' . $e->getErrors()['Message'] . PHP_EOL;
                return response($message, $e->getCode())
                    ->header('Content-Type', 'text/plain');
            }
            return response($e->getMessage(), $e->getCode())
                ->header('Content-Type', 'text/plain');
        }
    }

    public function delete(string $refreshToken) : Response
    {
        if ($refreshToken == 'MIT_LÆKRE_TOKEN_HER') {
            return response('Hov :) Du fik vist ikke læst, hvad jeg skrev', 200)
                ->header('Content-Type', 'text/plain');
        }

        $path = storage_path() . '/refresh_tokens/' . md5($refreshToken) . '-' . self::TOKEN_FILENAME;

        $result = false;
        if (File::exists($path)) {
            $result = File::delete($path);
        }
        $response = $result ? response('Data access-token deleted', 200) : response('Data access-token not found', 404);
        return $response->header('Content-Type', 'text/plain');
    }

    /**
     * @param string|null $refreshToken
     * @param array{'ewiiEmail': string, 'ewiiPassword': string}|null $ewiiCredentials
     * @param string|null $dataSource
     * @param array|null $smartMeCredentials
     * @param string|null $start_date
     * @param string|null $end_date
     * @param string $price_area
     * @param float $subscription
     * @param float $overhead
     * @return Response|JsonResponse
     * @throws DataUnavailableException
     * @throws ElOverblikApiException
     * @throws EwiiApiException
     */
    private function getPreliminaryInvoice(string $refreshToken = null, array $ewiiCredentials=null, string $dataSource=null, array $smartMeCredentials = null, string $start_date = null, string $end_date = null, string $price_area = 'DK2', float $subscription=23.20, float $overhead=0.015) : Response|JsonResponse
    {
        if(!$start_date) {
            $start_date = Carbon::now()->startOfMonth()->toDateString();
        }
        if(!$end_date) {
            $end_date = Carbon::now()->addMonth()->startOfMonth()->toDateString();
        }
        if ($refreshToken == 'MIT_LÆKRE_TOKEN_HER') {
            return response('Hov :) Du fik vist ikke læst, hvad jeg skrev', 200)
                ->header('Content-Type', 'text/plain');
        }
        $bill = $this->preliminaryInvoiceService->getBill($start_date, $end_date, $price_area, $smartMeCredentials, $dataSource, $refreshToken, $ewiiCredentials, $subscription, $overhead);

        return response()->json($bill);
    }

    /**
     * @param array<string, array<int, string>|int|string> $meterData
     * @param string|null $refreshToken
     * @param string $price_area
     * @param float $overhead
     * @return JsonResponse
     * @throws ElOverblikApiException
     */
    private function getUsageCost(array $meterData, string $refreshToken = null, string $price_area = 'DK2', float $overhead=0.015) : JsonResponse
    {
        $bill = $this->preliminaryInvoiceService->getCostOfCustomUsage($meterData, $refreshToken, $price_area, $overhead);

        return response()->json($bill);
    }

    public function getCharges(string $refreshToken = null) : Response|JsonResponse
    {
        if ($refreshToken == 'MIT_LÆKRE_TOKEN_HER') {
            return response('Hov :) Du fik vist ikke læst, hvad jeg skrev', 200)
                ->header('Content-Type', 'text/plain');
        }

        list($subscriptions, $tariffs) = $this->meteringDataService->getCharges($refreshToken);

        $list = array();

        foreach ($tariffs as $tariff) {
            $list[$tariff['name']] = $tariff['description'];

        }
        foreach ($subscriptions as $subscription) {
            $list[$subscription['name']] = $subscription['description'];
        }
        return response()->json($list);
    }

    public function getChargesForWeb(Request $request) : Response|RedirectResponse
    {
        try {
            $data = $this->meteringDataService->getCharges($request->token);
        } catch (ElOverblikApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for charges data at eloverblik failed</strong>' . '<br/>';
                    $message = $message . 'Datahub-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>' . $error['Code'] . '</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';
                    return redirect('el-charges')->with('error', $message)->withInput($request->all());
                case 401:
                    return redirect('el-charges')->with('error', 'Failed - cannot login with token')->withInput($request->all());
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        }
        return redirect('el-charges')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
    }

    public function getSpotprices(Request $request) : Response|RedirectResponse
    {

        switch ($request->outputformat) {
            case 'POWERUSE':
                $format = GetSpotPrices::FORMAT_INTERNAL;
                break;
            case 'JSON':
            case 'SQL':
            default:
                $format = GetSpotPrices::FORMAT_JSON;
                break;
        }
        $requestInputs = $request->collect()->filter(function ($value, $key) {
            if (strpos($key, 'Checkbox') !== false) {
                return true;
            }
        })->map(function ($item, $value) {
            return str_replace('Checkbox','', $value);
        })->flatten()->toArray();
        $data = $this->spotPricesService->getData($request->start_date, $request->end_date, $request->area, $requestInputs, $format);

        if ($request->outputformat == 'SQL') {
            $data = (array)$data;
            $data = $this->formatAsSql($data['records']);
            redirect('el-spotprices')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
        }

        return redirect('el-spotprices')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
    }

    public function apiGetSpotprices(Request $request) : Response
    {
        switch ($request->getAcceptableContentTypes()[0]) {
            case 'application/json':
            case 'text/sql':
                $spotprice_format = GetSpotPrices::FORMAT_JSON;
                break;
            case 'text/plain':
            case '*/*':
            default:
            $spotprice_format = GetSpotPrices::FORMAT_JSON;
        }
        $area = null;
        if(isset($request->filter)) {
            $json = json_decode($request->filter, true);
            $area = $json['PriceArea'];

            if($area == 'ALL')
            {
                $area = null;
            }

        }
        $requestInputs= array();
        if(isset($request->columns)) {
            $requestInputs = explode(',', $request->columns);
        }


        $data = $this->spotPricesService->getData($request->start, $request->end, $area, $requestInputs, $spotprice_format);

        if ($request->getAcceptableContentTypes()[0] == 'text/sql') {
            $data = (array)$data;
            return response($this->formatAsSql($data['records']))->header('Content-Type', 'text/sql');;
        }

        return response($data);
    }

    /**
     * @param array<array{HourUTC?: Carbon, HourDK?: Carbon, PriceArea?: string, SpotPriceDKK?: float, SpotPriceEUR?: float}> $records
     * @return string
     */
    private function formatAsSql(array $records): string
    {
        $response = '';
        $something = DB::pretend(function () use ($records) {
            foreach ($records as $record) {
                /** @var Elspotprices $elspotprices */
                $elspotprices = new Elspotprices();
                $elspotprices->HourUTC = array_key_exists('HourUTC', $record) ? $record['HourUTC'] : null;
                $elspotprices->HourDK = array_key_exists('HourDK', $record) ? $record['HourDK'] : null;
                $elspotprices->PriceArea = array_key_exists('PriceArea', $record) ? $record['PriceArea'] : null;
                $elspotprices->SpotPriceDKK = array_key_exists('SpotPriceDKK', $record) ? $record['SpotPriceDKK'] : null;
                $elspotprices->SpotPriceEUR = array_key_exists('SpotPriceEUR', $record) ? $record['SpotPriceEUR'] : null;
                $elspotprices->save();
            }
        });
        foreach ($something as $anything) {
            $query = str_replace('?', '%s', $anything['query']);

            $bindings = collect($anything['bindings'])->map(function ($item) {
                switch (gettype($item)) {
                    case 'integer':
                        return $item;
                    case 'string':
                    case 'boolean':
                    case 'array':
                    case 'object':
                    case 'NULL':
                    case 'unknown type':
                    case 'double': //for historical reasons "double" is returned in case of a float, and not simply "float"
                    default:
                        return $item!='' ? '\'' . $item . '\'' : 'null';
                }
            })->toArray();
            $response = $response . vsprintf($query, $bindings) . ';' . PHP_EOL;
        }
        return $response;
    }

    public function getConsumption(Request $request) : Response|RedirectResponse
    {
        $dataSource = $request->source;
        $addSmartMe = $request->smart_me === 'on';
        $end_date = $request->end_date;

        $smartMe = null;
        if ($dataSource === 'SMART_ME' || $addSmartMe) {
            $smartMe = [];
            $smartMe['username'] = $request->smartmeuser;
            $smartMe['password'] = $request->smartmepassword;
            $smartMe['id'] = $request->smartmeid;
        }
        try {
            switch ($dataSource) {
                case 'EWII':
                    $data = $this->meteringDataService->getDataFromEwii($request->start_date, $end_date, $request->ewiiEmail, $request->ewiiPassword);
                    break;
                case 'DATAHUB':
                    $data = $this->meteringDataService->getData($request->start_date, $end_date, $request->token);
                    break;
                case 'SMART-ME':
                    $data = $this->smartMeMeterDataService->getInterval($request->start_date,$end_date, $smartMe);
                    break;
                default:
                    throw new \InvalidArgumentException('Illegal provider for meteringdata given: ' . $dataSource);
            }

            if ($request->smart_me) {
                $dataSource = ($dataSource ?: '') . ', Smart-Me';
                $start_from = Carbon::parse(array_key_last($data), 'Europe/Copenhagen')->addHour()->toDateTimeString();
                $smart_me_end_date = Carbon::parse($end_date, 'Europe/Copenhagen')->toDateTimeString();

                $smartMeIntervalFromDate = $this->smartMeMeterDataService->getInterval($start_from, $smart_me_end_date);
                $data = array_merge($data, $smartMeIntervalFromDate);
            }

            $data = array_merge($data, ['Antal i serien' => count($data)]);
            $data = array_merge($data, ['Sum' => collect(array_values($data))->sum()]);
            $data = array_merge($data, ['Source' => $dataSource]);
        } catch (EwiiApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 500:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for consumption-point data at ewii failed</strong>' . '<br/>';
                    $message = $message . 'EWII-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>' . $error['Code'] . '</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';
                    return redirect('consumption')->with('error', $message)->withInput($request->all());
                case 2:
                    return redirect('consumption')->with('error', 'Failed - cannot login with ewii credentials.')->withInput($request->all());
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        }

        return redirect('consumption')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
    }

    public function getTotalPrices(Request $request) : RedirectResponse
    {
        $includeTomorrow = false;
        if (Carbon::now('Europe/Copenhagen')->gt(Carbon::now()->startOfHour()->hour(13))) {
            $includeTomorrow = true;
        }

        $operator = $request->netcompany;

        $gridOperatorGLNNumber = Operator::$operatorName[$operator];
        $gridprices = $this->getGridOperatorNettariff($gridOperatorGLNNumber);
        $priceArea = Operator::$gridOperatorArea[$gridOperatorGLNNumber];
        $spotPrices = $this->doGetSpotPrices($priceArea);
        if(count($spotPrices)==0) {
            $message = 'It wasn\'t possible to get day-ahead prices from "ENERGI DATA SERVICE" ( https://api.energidataservice.dk )';
            return redirect('el-totalprices')->with('error', $message)->withInput($request->all());
        }
        if ($includeTomorrow) {
            $toMorrowSpotPrices = $this->doGetSpotPrices($priceArea, Carbon::now('Europe/Copenhagen')->startOfDay()->addDay());
            $spotPrices = array_merge($spotPrices, $toMorrowSpotPrices);
        }
        $tsoNetTariffPrices = $this->getTSOOperatorNettariff('Energinet Systemansvar A/S (SYO)');
        $tsoSystemTariffPrices = $this->getTSOOperatorSystemtariff('Energinet Systemansvar A/S (SYO)');
        $tsoBalanceTariffPrices = $this->getTSOOperatorBalancetariff('Energinet Systemansvar A/S (SYO)');
        $tsoAfgiftTariffPrices = $this->getTSOOperatorAfgifttariff('Energinet Systemansvar A/S (SYO)');



        $totalPrice = array();
        $now = Carbon::now('Europe/Copenhagen')->startOfHour()->startOfDay();
        $limit = $includeTomorrow ? 47 : 23;
        for ($i = 0; $i <= $limit; $i++) {
            $j = ($i <= 23 ? $i : $i - 24);
            $now2 = clone $now;
            $totalPrice[$now2->addHours($i)->toDateTimeString()] = round(($gridprices[$j] + ($spotPrices[$i] / 1000) + $tsoNetTariffPrices[0] + $tsoSystemTariffPrices[0] + $tsoBalanceTariffPrices[0] + $tsoAfgiftTariffPrices[0]) * 1.25, 2);
        }
        $companies = Operator::$operatorName;

        $colours = $this->makeColors(array_values($totalPrice));

        $chart = new \stdClass();
        $chart->labels = (array_keys($totalPrice));
        $chart->dataset = (array_values($totalPrice));
        $chart->colours = $colours;

        return redirect('el-totalprices')->with('status', 'Alt data hentet')->with(['data' => $totalPrice])->with(['chart' => $chart])->with('companies', $companies)->withInput($request->all());

    }

    /**
     * @param array<float> $array
     * @return array<string>
     */
    private function makeColors(array $array) : array
    {
        $min = (float)min($array);
        $max = (float)max($array);
        $colours = [];
        foreach ($array as $value) {
            $value = (float)$value;
            $percentage = ($value - $min) / ($max - $min);
            $percentage = $percentage * 100.0;

            $R = 0;
            $G = 0;
            $B = 0;

            // 255 ÷ 50 = 5.1
            if ($percentage > 50) {
                $R = 5.1 * ($percentage - 50);
            } elseif ($percentage < 50) {
                $G = 255 - (5.1 * $percentage);
            }

            $dechex_r = dechex((int)$R) === '0' ? '00' : dechex((int)$R);
            $dechex_g = dechex((int)$G) === '0' ? '00' : dechex((int)$G);
            $dechex_b = dechex((int)$B) === '0' ? '00' : dechex((int)$B);

            $colours[] = '#' . $dechex_r . $dechex_g . $dechex_b;
        }
        return $colours;
    }

    /**
     * @param string $operator
     * @param string $chargeType
     * @param string $chargeTypeCode
     * @param string $note
     * @param string $startDate
     * @param string $endDate
     * @return array<int, float>
     */
    private function getChargePrice(string $operator, string $chargeType, string $chargeTypeCode, string $note, string $startDate, string $endDate): array
    {
        $data = $this->datahubPriceListsService->getDatahubTariffPriceLists($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate);
        $collection = collect($data[0]);
        $gridprices = array();
        $collection->each(function ($item, $key) use (&$gridprices) {
            if (Str::contains($key, 'Price')) {
                $key = ((int) Str::replace('Price', '', $key)) - 1;
                $gridprices[$key] = $item;
            }
        });
        return $gridprices;
    }

    /**
     * @param string $operatorName
     * @return array<int, float>
     */
    private function getGridOperatorNettariff(string $operatorName) : array
    {
        $GLN_number = Operator::$operatorNumber[$operatorName];
        $operator = GridOperatorNettariffProperty::getByGLNNumber($GLN_number);

        return $this->getChargePrice($operatorName, $operator->charge_type, $operator->charge_type_code, $operator->note, $operator->valid_from, $operator->valid_to);
    }

    /**
     * @param string $operator
     * @return array<int, float>
     */
    private function getTSOOperatorNettariff(string $operator) : array
    {
        $chargeType = 'D03';
        $chargeTypeCode = '40000';
        $note = 'Transmissions nettarif';
        $startDate = '2022-01-01';
        $endDate = '2022-12-31';

        return $this->getChargePrice($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate);
    }

    /**
     * @param string $area
     * @param Carbon|null $from
     * @return array<float>
     */
    private function doGetSpotPrices(string$area, Carbon $from = null) : array
    {
        if(!$from) {
            $from = Carbon::now('Europe/Copenhagen')->startOfDay();
        }
        $startDate = $from->toDateString();
        $endDate = $from->addDay()->toDateString();
        $spotPrices = array_values($this->spotPricesService->getData($startDate, $endDate, $area, ['HourDK', 'SpotPriceDKK']));
        return $spotPrices;
    }

    /**
     * @param string $operator
     * @return array<int, float>
     */
    private function getTSOOperatorSystemtariff(string $operator) : array
    {
        $chargeType = 'D03';
        $chargeTypeCode = '41000';
        $note = 'Systemtarif';
        $startDate = '2022-01-01';
        $endDate = '2022-12-31';

        return $this->getChargePrice($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate);
    }

    /**
     * @param string $operator
     * @return array<int, float>
     */
    private function getTSOOperatorBalancetariff(string $operator) : array
    {
        $chargeType = 'D03';
        $chargeTypeCode = '45013';
        $note = 'Balancetarif for forbrug';
        $startDate = '2022-01-01';
        $endDate = '2022-12-31';

        return $this->getChargePrice($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate);
    }

    /**
     * @param string $operator
     * @return array<int, float>
     */
    private function getTSOOperatorAfgifttariff(string $operator) : array
    {
        $chargeType = 'D03';
        $chargeTypeCode = 'EA-001';
        $note = 'Elafgift';
        $startDate = '2022-10-01';
        $endDate = '2022-12-31';

        return $this->getChargePrice($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate);
    }

    /**
     * @param string $glnNumber
     * @return array{result: array{data: array<int, array{time: string, price: float}>}}
     */
    public function apiGetTotalPriceToday(string $glnNumber) : array
    {
        $includeTomorrow = false;
        if (Carbon::now('Europe/Copenhagen')->gt(Carbon::now()->startOfHour()->hour(13))) {
            $includeTomorrow = true;
        }

        $operatorName = Operator::$operatorName[$glnNumber];

        $gridprices = $this->getGridOperatorNettariff($operatorName);
        $priceArea = Operator::$gridOperatorArea[$operatorName];
        $spotPrices = $this->doGetSpotPrices($priceArea);
        if ($includeTomorrow) {
            $toMorrowSpotPrices = $this->doGetSpotPrices($priceArea, Carbon::now('Europe/Copenhagen')->startOfDay()->addDay());
            $spotPrices = array_merge($spotPrices, $toMorrowSpotPrices);
        }
        $tsoNetTariffPrices = $this->getTSOOperatorNettariff('Energinet Systemansvar A/S (SYO)');
        $tsoSystemTariffPrices = $this->getTSOOperatorSystemtariff('Energinet Systemansvar A/S (SYO)');
        $tsoBalanceTariffPrices = $this->getTSOOperatorBalancetariff('Energinet Systemansvar A/S (SYO)');
        $tsoAfgiftTariffPrices = $this->getTSOOperatorAfgifttariff('Energinet Systemansvar A/S (SYO)');



        $totalPrice = array();
        $now = Carbon::now('Europe/Copenhagen')->startOfHour()->startOfDay();
        $limit = $includeTomorrow ? 47 : 23;
        for ($i = 0; $i <= $limit; $i++) {
            $j = ($i <= 23 ? $i : $i - 24);
            $now2 = clone $now;
            array_push($totalPrice, ['time' => $now2->addHours($i)->toDateTimeString(), 'price' => round(($gridprices[$j] + ($spotPrices[$i] / 1000) + $tsoNetTariffPrices[0] + $tsoSystemTariffPrices[0] + $tsoBalanceTariffPrices[0] + $tsoAfgiftTariffPrices[0]) * 1.25, 2)]);
        }

        return ['result'=>['data' =>$totalPrice]];
    }

}
