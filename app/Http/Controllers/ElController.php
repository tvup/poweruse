<?php

namespace App\Http\Controllers;

use App\Enums\SourceEnum;
use App\Exceptions\DataUnavailableException;
use App\Exceptions\MissingDataException;
use App\Models\Elspotprices;
use App\Models\GridOperatorNettariffProperty;
use App\Models\Operator;
use App\Models\User;
use App\Services\GetDatahubPriceLists;
use App\Services\GetMeteringData;
use App\Services\GetPreliminaryInvoice;
use App\Services\GetSmartMeMeterData;
use App\Services\GetSpotPrices;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Tvup\ElOverblikApi\ElOverblikApiException;

class ElController extends Controller
{
    private const TOKEN_FILENAME = 'eloverblik-token.serialized';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private readonly GetMeteringData $meteringDataService,
        private readonly GetPreliminaryInvoice $preliminaryInvoiceService,
        private readonly GetSpotPrices $spotPricesService,
        private readonly GetSmartMeMeterData $smartMeMeterDataService,
        private readonly GetDatahubPriceLists $datahubPriceListsService
    ) {
    }

    public function index() : View
    {
        $data = session('data');

        return view('el')->with('data', $data->original ?? null)->with('refresh_token', auth()->user()?->refresh_token);
    }

    public function indexSpotprices() : View
    {
        $data = session('data');

        return view('el-spotprices')->with('data', $data ?: null);
    }

    public function indexConsumption() : View
    {
        $data = session('data');

        return view('consumption')->with('data', $data ?: null)->with('refresh_token', auth()->user()?->refresh_token);
    }

    public function indexCustomUsage() : View
    {
        $data = session('data');

        return view('el-custom')->with('data', $data ?: null)->with('refresh_token', auth()->user()?->refresh_token);
    }

    public function processData(Request $request) : RedirectResponse|Response
    {
        /** @var User|null $user */
        $user = auth()->check() ? auth()->user() : null;

        try {
            $refreshToken = null;
            if (!$request->token) {
                if (auth()->check() && auth()->user()->refresh_token) {
                    $refreshToken = auth()->user()->refresh_token;
                } else {
                    return redirect('consumption')->with('error', 'Failed - token cannot be empty.')->withInput($request->all());
                }
            } else {
                $refreshToken = $request->token;
            }

            $smartMeCredentials = null;
            if ($request->boolean('smart_me')) {
                $smartMeCredentials = [];
                $smartMeCredentials['username'] = $request->smartmeuser;
                $smartMeCredentials['password'] = $request->smartmepassword;
                $smartMeCredentials['id'] = $request->smartmeid;
            }
            $data = $this->getPreliminaryInvoice($refreshToken, $smartMeCredentials, $request->start_date, $request->end_date, $request->area, $request->subscription, $request->overhead, $user);
        } catch (ElOverblikApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 429:
                case 500:
                case 503:
                    $error = $e->getErrors();
                    $payload = isset($error['Payload']) ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for mertering data at eloverblik failed</strong>' . '<br/>';
                    $message = $message . 'Datahub-server for ' . (array_key_exists('verb', $error) ? $error['Verb'] : 'UNKNOWN VERB') . ' ' . '<i>' . (array_key_exists('Endpoint', $error) ? $error['Endpoint'] : 'UNKNOWN ENDPOINT') . '</i>' . $payload . ' gave a code <strong>' . (array_key_exists('Code', $error) ? $error['Code'] : 'UNKNOWN CODE') . '</strong> and this response: ' . '<strong>' . (array_key_exists('Response', $error) ? $error['Response'] : 'UNKNOWN RESPONSE') . '</strong>';

                    return redirect('el')->with('error', $message)->withInput($request->all());
                case 401:
                    return redirect('el')->with('error', 'Failed - cannot login with data-access token. MD5 of refresh token: ' . md5($refreshToken))->withInput($request->all());
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        } catch (DataUnavailableException|MissingDataException $e) {
            return redirect('el')->with('error', $e->getMessage())->withInput($request->all());
        }

        if (($data instanceof JsonResponse) && property_exists($data->getData(), 'warning')) {
            return redirect('el')->with('warning', $data->getData()->warning)->with(['data' => $data])->withInput($request->all())->withCookie('refresh_token', $refreshToken, 525600)->withCookie('smartmeid', $request->smartmeid, 525600)->withCookie('smartmeuser', $request->smartmeuser, 525600)->withCookie('smartmepassword', $request->smartmepassword, 525600)->withCookie('smart_me', $request->smart_me, 525600);
        }

        return redirect('el')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all())->withCookie('refresh_token', $refreshToken, 525600)->withCookie('smartmeid', $request->smartmeid, 525600)->withCookie('smartmeuser', $request->smartmeuser, 525600)->withCookie('smartmepassword', $request->smartmepassword, 525600)->withCookie('smart_me', $request->smart_me, 525600);
    }

    public function processCustom(Request $request) : RedirectResponse|Response
    {
        if (!$request->token) {
            return redirect('el-custom')->with('error', 'Failed - token cannot be empty is selected.')->withInput($request->all());
        }
        try {
            $fields = $request->all();
            $meterData = [];
            foreach ($fields as $key => $value) {
                if (str_contains($key, 'usage')) {
                    $timeslot = (int) str_replace('usage', '', $key);
                    $newKey = Carbon::now('Europe/Copenhagen')->startOfDay()->hour($timeslot)->format('c');
                    $newValue = $value ? str_replace(',', '.', $value) : null;
                    $meterData[$newKey] = ($newValue ?: 0);
                }
            }
            $data = $this->getUsageCost($meterData, $request->token, $request->area, $request->overhead, auth()->user());
        } catch (ElOverblikApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 500:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for mertering data at eloverblik failed</strong>' . '<br/>';
                    $message = $message . 'Datahub-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>' . $error['Code'] . '</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';

                    return redirect('el')->with('error', $message)->withInput($request->all());
                case 401:
                    return redirect('el')->with('error', 'Failed - cannot login with data-access token. MD5 of refresh token: ' . md5($request->token))->withInput($request->all());
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
            $dataSource = SourceEnum::DATAHUB;

            if (!$request->token) {
                if (auth()->check() && auth()->user()->refresh_token) {
                    $refreshToken = auth()->user()->refresh_token;
                } else {
                    return redirect('consumption')->with('error', 'Failed - token cannot be empty when datahub is selected.')->withInput($request->all());
                }
            } else {
                $refreshToken = $request->token;
            }

            switch ($dataSource) {
                case SourceEnum::DATAHUB:
                    $data = $this->meteringDataService->getMeteringPointData($refreshToken);
                    break;
                default:
                    throw new \RuntimeException('Illegal provider for meteringdata given: ' . $dataSource->value);
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

    public function getFromDate(string $start_date, string $end_date, string $price_area, string $refreshToken = null) : Response|JsonResponse
    {
        try {
            return $this->getPreliminaryInvoice($refreshToken, null, $start_date, $end_date, $price_area, 25, 1, auth()->user());
        } catch (ElOverblikApiException $e) {
            if ($e->getCode() == 400) {
                $message = 'Request for metering data at eloverblik failed' . PHP_EOL;
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
     * @param string $refreshToken
     * @param array|null $smartMeCredentials
     * @param string|null $start_date
     * @param string|null $end_date
     * @param string $price_area
     * @param float $subscription
     * @param float $overhead
     * @return Response|JsonResponse
     * @throws DataUnavailableException
     * @throws ElOverblikApiException
     */
    private function getPreliminaryInvoice(string $refreshToken, array $smartMeCredentials = null, string $start_date = null, string $end_date = null, string $price_area = 'DK2', float $subscription = 23.20, float $overhead = 0.048, User $user = null) : Response|JsonResponse
    {
        if (!$start_date) {
            $start_date = Carbon::now()->startOfMonth()->toDateString();
        }
        if (!$end_date) {
            $end_date = Carbon::now()->addMonth()->startOfMonth()->toDateString();
        }
        if ($refreshToken == 'MIT_LÆKRE_TOKEN_HER') {
            return response('Hov :) Du fik vist ikke læst, hvad jeg skrev', 200)
                ->header('Content-Type', 'text/plain');
        }

        $bill = $this->preliminaryInvoiceService->getBill($start_date, $end_date, $price_area, $smartMeCredentials, SourceEnum::POWERUSE, $refreshToken, $subscription, $overhead, $user);

        return response()->json($bill);
    }

    /**
     * @param array<string, array<int, string>|int|string> $meterData
     * @param string|null $refreshToken
     * @param string $price_area
     * @param float $overhead
     * @param User $user
     * @return JsonResponse
     * @throws ElOverblikApiException
     */
    private function getUsageCost(array $meterData, string $refreshToken = null, string $price_area = 'DK2', float $overhead = 0.048, User $user = null) : JsonResponse
    {
        $bill = $this->preliminaryInvoiceService->getCostOfCustomUsage($meterData, $refreshToken, $price_area, $overhead, $user);

        return response()->json($bill);
    }

    public function getCharges(string $refreshToken = null) : Response|JsonResponse
    {
        if ($refreshToken == 'MIT_LÆKRE_TOKEN_HER') {
            return response('Hov :) Du fik vist ikke læst, hvad jeg skrev', 200)
                ->header('Content-Type', 'text/plain');
        }

        list($subscriptions, $tariffs) = $this->meteringDataService->getCharges(request()->start_date, request()->end_date, null, ['refresh_token'=>$refreshToken]);

        $list = [];

        foreach ($tariffs as $tariff) {
            $list[$tariff['name']] = $tariff['description'];
        }
        foreach ($subscriptions as $subscription) {
            $list[$subscription['name']] = $subscription['description'];
        }

        return response()->json($list);
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
            return str_replace('Checkbox', '', $value);
        })->flatten()->toArray();
        $data = $this->spotPricesService->getData($request->start_date, $request->end_date, $request->area, $requestInputs, $format);

        if ($request->outputformat == 'SQL') {
            $data = (array) $data;
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
        if (isset($request->filter)) {
            $json = json_decode($request->filter, true);
            $area = $json['PriceArea'];

            if ($area == 'ALL') {
                $area = null;
            }
        }
        $requestInputs = [];
        if (isset($request->columns)) {
            $requestInputs = explode(',', $request->columns);
        }

        $data = $this->spotPricesService->getData($request->start, $request->end, $area, $requestInputs, $spotprice_format);

        if ($request->getAcceptableContentTypes()[0] == 'text/sql') {
            $data = (array) $data;

            return response($this->formatAsSql($data['records']))->header('Content-Type', 'text/sql');
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
                        return $item != '' ? '\'' . $item . '\'' : 'null';
                }
            })->toArray();
            $response .= vsprintf($query, $bindings) . ';' . PHP_EOL;
        }

        return $response;
    }

    public function getConsumption(Request $request) : Response|RedirectResponse
    {
        $dataSource = SourceEnum::from($request->source);
        $addSmartMe = $request->smart_me === 'on';
        $end_date = $request->end_date;

        $smartMe = null;
        if ($dataSource === SourceEnum::SMARTME || $addSmartMe) {
            $smartMe = [];
            $smartMe['username'] = $request->smartmeuser;
            $smartMe['password'] = $request->smartmepassword;
            $smartMe['id'] = $request->smartmeid;
        }
        $data = [];
        try {
            switch ($dataSource) {
                case SourceEnum::DATAHUB:
                    if (!$request->token) {
                        if (auth()->check() && auth()->user()->refresh_token) {
                            $refreshToken = auth()->user()->refresh_token;
                        } else {
                            $message = 'Request token should be provided either on input or saved on user';

                            return redirect('consumption')->with('error', $message)->withInput($request->all());
                        }
                    } else {
                        $refreshToken = $request->token;
                    }
                    $data = $this->meteringDataService->getData($request->start_date, $end_date, $refreshToken);
                    break;
                case SourceEnum::SMARTME:
                    try {
                        $data = $this->smartMeMeterDataService->getInterval($request->start_date, $end_date, $smartMe);
                    } catch (ConnectionException $e) {
                        if (Str::startsWith($e->getMessage(), 'cURL error 28')) {
                            return redirect('consumption')->with('error', 'Failed - Smart-Me service failed to reply. Request timed out.')->withInput($request->all());
                        }

                        return redirect('consumption')->with('error', $e->getMessage())->withInput($request->all());
                    } catch (\Exception $e) {
                        return redirect('consumption')->with('error', $e->getMessage())->withInput($request->all());
                    }
                    break;
            }

            if ($request->smart_me) {
                $dataSource = $dataSource->value . ', Smart-Me';
                $start_from = Carbon::parse(array_key_last($data), 'Europe/Copenhagen')->addHour()->toDateTimeString();
                $smart_me_end_date = Carbon::parse($end_date, 'Europe/Copenhagen')->toDateTimeString();

                try {
                    $smartMeIntervalFromDate = $this->smartMeMeterDataService->getInterval(
                        $start_from,
                        $smart_me_end_date,
                        $smartMe
                    );
                } catch (\Exception $e) {
                    return redirect('consumption')->with('error', $e->getMessage())->withInput($request->all());
                }
                $data = array_merge($data, $smartMeIntervalFromDate);
            }

            $data = array_merge($data, ['Antal i serien' => count($data)]);
            $data = array_merge($data, ['Sum' => collect(array_values($data))->sum()]);
            $data = array_merge($data, ['Source' => $dataSource]);
        } catch (ElOverblikApiException $e) {
            return match ($e->getCode()) {
                401 => redirect('consumption')->with('error', 'Failed - cannot login with credentials.')->withInput(
                    $request->all()
                ),
                default => response($e->getMessage(), $e->getCode())
                    ->header('Content-Type', 'text/plain'),
            };
        }

        return redirect('consumption')->with('status', 'Alt data hentet')->with(['data' => $data])->withInput($request->all());
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
        $data = $this->datahubPriceListsService->requestDatahubPriceListsFromEnergiDataService($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate);
        if (count($data) === 0) {
            throw new DataUnavailableException('Data is not available for ' . $operator . ' from ' . $startDate . ' to ' . $endDate . ' with charge type ' . $chargeType . ' and charge type code ' . $chargeTypeCode . ' and note ' . $note, 1);
        }
        $collection = collect($data[0]);
        $gridprices = [];
        $collection->each(function ($item, $key) use (&$gridprices) {
            if (is_string($key) && Str::contains($key, 'Price')) {
                $numericKey = Str::replace('Price', '', $key);
                if (is_numeric($numericKey)) {
                    $keyIndex = ((int) $numericKey) - 1;
                    $gridprices[$keyIndex] = $item;
                }
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
        $startDate = '2024-01-01';
        $endDate = '2024-12-31';

        return $this->getChargePrice($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate);
    }

    /**
     * @param string $area
     * @param Carbon|null $from
     * @return array<float>
     */
    private function doGetSpotPrices(string $area, Carbon $from = null) : array
    {
        if (!$from) {
            $from = Carbon::now('Europe/Copenhagen')->startOfDay();
        }
        $startDate = $from->toDateString();
        $endDate = $from->addDay()->toDateString();

        /** @var array $array */
        $array = $this->spotPricesService->getData($startDate, $endDate, $area, ['HourDK', 'SpotPriceDKK']);

        return array_values($array);
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
        $startDate = '2024-01-01';
        $endDate = '2024-12-31';

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
        $startDate = '2024-01-01';
        $endDate = '2024-12-31';

        return $this->getChargePrice($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate);
    }

    /**
     * @param string $glnNumber
     * @return array{result: array{data: array<int, array{time: string, price: float}>}}
     */
    public function apiGetTotalPriceToday(string $glnNumber) : array
    {
        $includeTomorrow = false;
        if (Carbon::now('Europe/Copenhagen')->gt(now()->startOfHour()->hour(13))) {
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
        $tsoAfgiftTariffPrices = $this->getTSOOperatorAfgifttariff('Energinet Systemansvar A/S (SYO)');

        $totalPrice = [];
        $now = Carbon::now('Europe/Copenhagen')->startOfHour()->startOfDay();
        $limit = $includeTomorrow ? 47 : 23;
        for ($i = 0; $i <= $limit; $i++) {
            $j = ($i <= 23 ? $i : $i - 24);
            $now2 = clone $now;
            $totalPrice[] = [
                'time' => $now2->addHours($i)->toDateTimeString(),
                'price' => round(
                    ($gridprices[$j] + ($spotPrices[$i] / 1000) + $tsoNetTariffPrices[0] + $tsoSystemTariffPrices[0] + $tsoAfgiftTariffPrices[0]) * 1.25,
                    2
                ),
            ];
        }

        return ['result'=>['data' =>$totalPrice]];
    }
}
