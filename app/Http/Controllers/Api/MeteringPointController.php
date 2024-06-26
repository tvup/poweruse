<?php

namespace App\Http\Controllers\Api;

use App\Enums\SourceEnum;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMeteringPointRequest;
use App\Http\Requests\UpdateMeteringPointRequest;
use App\Models\Charge;
use App\Models\MeteringPoint;
use App\Models\User;
use App\Services\GetMeteringData;
use App\Services\Transformers\Facades\MeteringPointTransformer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Tvup\ElOverblikApi\ElOverblikApiException;

class MeteringPointController extends Controller
{
    private bool $userIsLoggedIn;

    public function __construct(private GetMeteringData $meteringDataService)
    {
        $this->userIsLoggedIn = auth('api')->check();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(?string $refresh_token = null) : Response|JsonResponse
    {
        $source = request()->get('source') ?? SourceEnum::POWERUSE;
        $source = is_string($source) ? SourceEnum::from($source) : $source;
        /** @var User|null $user */
        $user = $this->userIsLoggedIn ? auth('api')->user() : null;
        $credentials = [
            'refresh_token' => $refresh_token ?? $user?->refresh_token,
        ];

        //We cannot get data from datahub without refresh token
        if (!$user && !$credentials['refresh_token']) {
            return response()->json();
        }

        try {
            $data = $this->meteringDataService->getMeteringPointData($source, $credentials, $user);
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
                    return response()->json(PaginationHelper::paginate(collect([['error' => 'Failed - cannot login with token']]), 10));
                default:
                    return response($e->getMessage(), $e->getCode())
                        ->header('Content-Type', 'text/plain');
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        if ($data) {
            $data = MeteringPointTransformer::prepareForJson($data);
            $data = collect([$data]);
            $data = PaginationHelper::paginate($data, 10);

            return response()->json($data);
        }

        return response()->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMeteringPointRequest $request
     * @return array
     */
    public function store(StoreMeteringPointRequest $request): array
    {
        $validated = $request->validated();

        /** @var array $meteringpoint */
        $meteringpoint = MeteringPointTransformer::prepareForJson(
            MeteringPoint::updateOrCreate(
                [
                    'metering_point_id' => $request['metering_point_id'],
                ],
                [
                    'parent_id' => Arr::get($validated, 'parent_id'),
                    'type_of_mp' => Arr::get($validated, 'type_of_mp'),
                    'settlement_method' => Arr::get($validated, 'settlement_method'),
                    'meter_number' => Arr::get($validated, 'meter_number'),
                    'consumer_c_v_r' => Arr::get($validated, 'consumer_c_v_r'),
                    'data_access_c_v_r' => Arr::get($validated, 'data_access_c_v_r'),
                    'consumer_start_date' => Carbon::parse($request['consumer_start_date'], 'UTC')->timezone(
                        'Europe/Copenhagen'
                    )->toDateString(),
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
                ]
            )
        );

        return $meteringpoint;
    }

    /**
     * Display the specified resource.
     *
     * @param MeteringPoint $meteringPoint
     */
    public function show(MeteringPoint $meteringPoint): JsonResponse
    {
        return response()->json($meteringPoint);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMeteringPointRequest $request
     * @param MeteringPoint $meteringPoint
     */
    public function update(UpdateMeteringPointRequest $request, MeteringPoint $meteringPoint): JsonResponse
    {
        $validated = $request->validate($request->rules());

        $meteringPoint->update($validated);

        return response()->json($meteringPoint);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MeteringPoint $meteringPoint
     * @return JsonResponse
     */
    public function destroy(MeteringPoint $meteringPoint): JsonResponse
    {
        $charges = $meteringPoint->charges ?? [];

        /** @var Charge $charge */
        foreach ($charges as $charge) {
            $chargePrices = $charge->chargePrices ?? [];
            foreach ($chargePrices as $chargePrice) {
                $chargePrice->delete();
            }
            $charge->delete();
        }
        $meteringPoint->delete();

        return response()->json(status: 204);
    }
}
