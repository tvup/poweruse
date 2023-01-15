<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMeteringPointRequest;
use App\Http\Requests\UpdateMeteringPointRequest;
use App\Models\MeteringPoint;
use App\Services\GetMeteringData;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Tvup\ElOverblikApi\ElOverblikApiException;

class MeteringPointController extends Controller
{
    private GetMeteringData $meteringDataService;

    private bool $userIsLoggedIn = false;


    public function __construct(GetMeteringData $meteringDataService)
    {
        if (auth('api')->check()) {
            $this->userIsLoggedIn = true;
        } else {
            $this->userIsLoggedIn = false;
        }
        $this->meteringDataService = $meteringDataService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response | JsonResponse
     */
    public function index(string $refresh_token = null)
    {
        if ($this->userIsLoggedIn) {
            if (!$refresh_token) {
                $data = MeteringPoint::whereUserId(auth('api')->user()->id)->orderBy('id', 'desc')->paginate(10);
                if ($data->count() != 0) {
                    return response()->json($data);
                }
                $refresh_token = auth('api')->user()->refresh_token;
            }
        }

        if (!$refresh_token) {
            return response('', 200);
        }

        try {
            $data = $this->meteringDataService->getMeteringPointData($refresh_token);
        } catch (ElOverblikApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for mertering-point data at eloverblik failed</strong>' . '<br/>';
                    $message = $message . 'Datahub-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>' . $error['Code'] . '</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';
                    return response()->json(['error' => $message]);
                case 401:
                    return response()->json(['error' => 'Failed - cannot login with token']);
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        }
        $meteringPoint = app()->make(MeteringPoint::class);
        $meteringPoint->metering_point_id = $data['meteringPointId'];
        $meteringPoint->type_of_mp = $data['typeOfMP'];
        $meteringPoint->settlement_method = $data['settlementMethod'];
        $meteringPoint->meter_number = $data['meterNumber'];
        $meteringPoint->consumer_c_v_r = $data['consumerCVR'];
        $meteringPoint->data_access_c_v_r = $data['dataAccessCVR'];
        $meteringPoint->consumer_start_date = $data['consumerStartDate'];
        $meteringPoint->meter_reading_occurrence = $data['meterReadingOccurrence'];
        $meteringPoint->balance_supplier_name = $data['balanceSupplierName'];
        $meteringPoint->street_code = $data['streetCode'];
        $meteringPoint->street_name = $data['streetName'];
        $meteringPoint->building_number = $data['buildingNumber'];
        $meteringPoint->floor_id = $data['floorId'];
        $meteringPoint->room_id = $data['roomId'];
        $meteringPoint->city_name = $data['cityName'];
        $meteringPoint->city_sub_division_name = $data['citySubDivisionName'];
        $meteringPoint->municipality_code = $data['municipalityCode'];
        $meteringPoint->location_description = $data['locationDescription'];
        $meteringPoint->first_consumer_party_name = $data['firstConsumerPartyName'];
        $meteringPoint->second_consumer_party_name = $data['secondConsumerPartyName'];
        $meteringPoint->hasRelation = $data['hasRelation'];

        $data = collect([$meteringPoint]);
        $data = PaginationHelper::paginate($data, 10);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMeteringPointRequest $request
     * @return MeteringPoint
     */
    public function store(StoreMeteringPointRequest $request)
    {
        $validated = $request->validated();

        return MeteringPoint::updateOrCreate(
            [
                'metering_point_id' => $request['metering_point_id']
            ],
            [
                'parent_id' => Arr::get($validated, 'parent_id'),
                'type_of_mp' => Arr::get($validated, 'type_of_mp'),
                'settlement_method' => Arr::get($validated, 'settlement_method'),
                'meter_number' => Arr::get($validated, 'meter_number'),
                'consumer_c_v_r' => Arr::get($validated, 'consumer_c_v_r'),
                'data_access_c_v_r' => Arr::get($validated, 'data_access_c_v_r'),
                'consumer_start_date' => Carbon::parse($request['consumer_start_date'], 'UTC')->timezone('Europe/Copenhagen')->toDateString(),
                'meter_reading_occurrence' => Arr::get($validated, 'meter_reading_occurrence'),
                'balance_supplier_name' => Arr::get($validated, 'balance_supplier_name'),
                'street_code' => Arr::get($validated, 'street_code'),
                'street_name' => Arr::get($validated, 'street_name'),
                'building_number' => Arr::get($validated, 'building_number'),
                'floor_id' => Arr::get($validated, 'floor_id'),
                'room_id' => Arr::get($validated, 'room_id'),
                'city_name' => Arr::get($validated, 'city_name'),
                'city_sub_division_name' => Arr::get($validated, 'city_sub_division_name'),
                'municipality_code' => Arr::get($validated, 'municipality_code'),
                'location_description' => Arr::get($validated, 'location_description'),
                'first_consumer_party_name' => Arr::get($validated, 'first_consumer_party_name'),
                'second_consumer_party_name' => Arr::get($validated, 'second_consumer_party_name'),
                'hasRelation' => Arr::get($validated, 'hasRelation'),
                'user_id' => auth('api')->user()->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\MeteringPoint $meteringPoint
     * @return \Illuminate\Http\Response
     */
    public function show(MeteringPoint $meteringPoint)
    {
        return response(MeteringPoint::first()); //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMeteringPointRequest $request
     * @param \App\Models\MeteringPoint $meteringPoint
     * @return MeteringPoint
     */
    public function update(UpdateMeteringPointRequest $request, MeteringPoint $meteringPoint): MeteringPoint
    {
        $validated = $request->validate($request->rules());

        $meteringPoint->update($validated);

        return $meteringPoint;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\MeteringPoint $meteringPoint
     * @return MeteringPoint
     */
    public function destroy(MeteringPoint $meteringPoint): MeteringPoint
    {
        $meteringPoint->delete();

        return $meteringPoint;
    }
}
