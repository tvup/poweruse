<?php

namespace App\Http\Controllers;

use App\Models\Elspotprices;
use App\Services\GetMeteringData;
use App\Services\GetPreliminaryInvoice;
use App\Services\GetSmartMeMeterData;
use App\Services\GetSpotPrices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Tvup\ElOverblikApi\ElOverblikApiException;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GetMeteringData $meteringDataService, GetPreliminaryInvoice $preliminaryInvoiceService, GetSpotPrices $spotPricesService, GetSmartMeMeterData $smartMeMeterDataService)
    {
        $this->meteringDataService = $meteringDataService;
        $this->preliminaryInvoiceService = $preliminaryInvoiceService;
        $this->spotPricesService = $spotPricesService;
        $this->smartMeMeterDataService = $smartMeMeterDataService;
    }

    public function index()
    {
        $data = session('data');

        return view('el')->with('data', $data ? $data->original : null);
    }

    public function indexMeteringPoint()
    {
        $data = session('data');

        return view('el-meteringpoint')->with('data', $data ? : null);
    }

    public function indexCharges()
    {
        $data = session('data');

        return view('el-charges')->with('data', $data ? : null);
    }

    public function indexSpotprices()
    {
        $data = session('data');

        return view('el-spotprices')->with('data', $data ? : null);
    }

    public function indexConsumption()
    {
        $data = session('data');

        return view('consumption')->with('data', $data ? : null);
    }

    public function processData(Request $request)
    {
        try {
            switch ($request->de) {
                case 'on':
                    $dataSource = 'EWII';
                    break;
                default:
                    $dataSource = 'DATAHUB';
            }

            $smartMe = false;
            if ($request->smart_me == 'on') {
                $smartMe = array();
                $smartMe['username'] = $request->smartmeuser;
                $smartMe['password'] = $request->smartmepassword  ;
                $smartMe['id'] = $request->smartmeid;
            }
            $ewiiCredentials = [
                'ewiiEmail' => $request->ewiiEmail,
                'ewiiPassword' => $request->ewiiPassword
            ];

            
            $data = $this->getPreliminaryInvoice($request->token, $ewiiCredentials, $dataSource, $smartMe, $request->start_date, $request->end_date, $request->area, $request->subscription, $request->overhead);
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
        }
        return redirect('el')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
    }

    public function getMeteringPointData(Request $request)
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
        }
        return redirect('el-meteringpoint')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
    }

    public function get($refreshToken)
    {
        try {
            return $this->getPreliminaryInvoice($refreshToken);
        } catch (ElOverblikApiException | \InvalidArgumentException $e) {
            return response($e->getMessage(), $e->getCode(), ['Content-Type' => 'text/plain']);
        }
    }

    public function getWithSmartMe($refreshToken = null)
    {
        try {
            return $this->getPreliminaryInvoice($refreshToken, null, 'DATAHUB', true);
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
                    return $this->getPreliminaryInvoice(null, $ewiiCredentials, 'EWII', true);
                } catch (EwiiApiEx½ception $exception) {
                    $code = $exception->getCode();
                }
            }
            return response($exception->getMessage(), $code)
                ->header('Content-Type', 'text/plain');
        }

    }

    public function getFromDate($start_date, $end_date, $price_area, $refreshToken = null)
    {
        try {
            return $this->getPreliminaryInvoice($refreshToken, null, 'DATAHUB', false, $start_date, $end_date, $price_area);
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

    public function delete($refreshToken)
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
     * @return mixed
     */
    private function getPreliminaryInvoice($refreshToken = null, $ewiiCredentials=null, $dataSource=null, $smartMe = false, string $start_date = null, string $end_date = null, $price_area = 'DK2', $subscription=23.20, $overhead=0.015)
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
        $bill = $this->preliminaryInvoiceService->getBill($start_date, $end_date, $smartMe, $dataSource, $refreshToken, $ewiiCredentials, $price_area, $subscription, $overhead);

        return response()->json($bill);
    }

    public function getCharges($refreshToken = null)
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

    public function getChargesForWeb(Request $request)
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

    public function getSpotprices(Request $request)
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

        if($request->outputformat == 'SQL') {
            $data= $this->formatAsSql($data['records']);
            redirect('el-spotprices')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
        }

        return redirect('el-spotprices')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
    }

    public function apiGetSpotprices(Request $request)
    {
        switch ($request->getAcceptableContentTypes()[0]) {
            case 'application/json':
            case 'text/sql':
                $spotprice_format = GetSpotPrices::FORMAT_JSON;
                break;
            case 'text/plain':
            case '*/*':
            default:
            $spotprice_format = GetSpotPrices::$spotprice_format;
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

        if($request->getAcceptableContentTypes()[0] == 'text/sql') {
            return response($this->formatAsSql($data['records']))->header('Content-Type', 'text/sql');;
        }

        return response($data);
    }

    /**
     * @param $records
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function formatAsSql($records)
    {
        $response = '';
        $something = DB::pretend(function () use ($records) {
            foreach ($records as $record) {
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
                        break;
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

    public function getConsumption(Request $request)
    {
        $data = null;
        $dataSource = $request->source;
        $end_date = $request->end_date;
        switch ($dataSource) {
            case 'EWII':
                $data = $this->meteringDataService->getDataFromEwii(null, null, $request->start_date, $end_date);
                break;
            case 'DATAHUB':
                $data = $this->meteringDataService->getData(null, $request->start_date, $end_date);
                break;
            case 'SMART-ME':
                $data = $this->smartMeMeterDataService->getInterval(false, $request->start_date, $end_date);
                break;
            default:
                throw new \InvalidArgumentException('Illegal provider for meteringdata given: ' . $dataSource);
        }

        if ($request->smart_me) {
            $dataSource = ($dataSource ?: '') . ', Smart-Me';
            $start_from = Carbon::parse(array_key_last($data), 'Europe/Copenhagen')->addHour()->toDateTimeString();
            $smart_me_end_date = Carbon::parse($end_date, 'Europe/Copenhagen')->toDateTimeString();

            $smartMeIntervalFromDate = $this->smartMeMeterDataService->getInterval(false, $start_from, $smart_me_end_date);
            $data = array_merge($data, $smartMeIntervalFromDate);
        }

        $data = array_merge($data, ['Antal i serien' => count($data)]);
        $data = array_merge($data, ['Sum' => collect(array_values($data))->sum()]);
        $data = array_merge($data, ['Source' => $dataSource]);

        return redirect('consumption')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
    }

}
