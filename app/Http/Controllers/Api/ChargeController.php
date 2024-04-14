<?php

namespace App\Http\Controllers\Api;

use App\Enums\SourceEnum;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChargeRequest;
use App\Http\Requests\UpdateChargeRequest;
use App\Models\Charge;
use App\Models\ChargePrice;
use App\Models\MeteringPoint;
use App\Services\GetMeteringData;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Tvup\ElOverblikApi\ElOverblikApiException;

class ChargeController extends Controller
{
    private GetMeteringData $meteringDataService;

    private bool $userIsLoggedIn;

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
     * isplay a listing of the resource.
     *
     * @param string|null $refresh_token
     * @return JsonResponse
     */
    public function index(string $refresh_token = null): JsonResponse
    {
        $meteringPointId = '';
        $meteringPoint = null;

        $user = $this->userIsLoggedIn ? auth('api')->user() : null;

        if ($this->userIsLoggedIn) {
            $meteringPoint = MeteringPoint::whereUserId($user->id)->first();
            $meteringPointId = $meteringPoint ? $meteringPoint->id : '';
            if (!$refresh_token) {
                if ($meteringPoint) {
                    $meteringPointId = $meteringPoint->id;
                    $firstQuery = Charge::with('prices')->whereMeteringPointId($meteringPointId)->orderBy('id', 'desc')->whereType('Abonnement');
                    $secondQuery = Charge::with('prices')->whereMeteringPointId($meteringPointId)->orderBy('id', 'desc')->whereType('Tarif');
                    $thirdQuery = Charge::with('prices')->whereMeteringPointId($meteringPointId)->orderBy('id', 'desc')->whereType('Gebyr');
                    if ($firstQuery->count() + $secondQuery->count() + $thirdQuery->count() != 0) {
                        $data = [$firstQuery->get(), $secondQuery->get(), $thirdQuery->get(), [['metering_point_id' => $meteringPointId]], [['metering_point_gsrn' => $meteringPoint->metering_point_id]]];
                        $data = collect($data);
                        $data = PaginationHelper::paginate($data, 10);

                        return response()->json($data);
                    }
                    $refresh_token = $user->refresh_token;
                }
            }
        }

        if (!$refresh_token) {
            return response()->json();
        }

        try {
            $data = $this->meteringDataService->getCharges(null, null, SourceEnum::DATAHUB, ['refresh_token' => $refresh_token], $user);
        } catch (ElOverblikApiException $e) {
            switch ($e->getCode()) {
                case 400:
                case 503:
                    $error = $e->getErrors();
                    $payload = $error['Payload'] ? ' with ' . json_encode($error['Payload'], JSON_PRETTY_PRINT) : '';
                    $message = '<strong>Request for charges data at eloverblik failed</strong>' . '<br/>';
                    $message = $message . 'Datahub-server for ' . $error['Verb'] . ' ' . '<i>' . $error['Endpoint'] . '</i>' . $payload . ' gave a code <strong>' . $error['Code'] . '</strong> and this response: ' . '<strong>' . $error['Response'] . '</strong>';

                    return response()->json(['error' => $message]);
                case 401:
                    return response()->json(['error' => 'Failed - cannot login with token']);
                default:
                    return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()]);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
        array_push($data, [['metering_point_id' => $meteringPointId]]);
        array_push($data, [['metering_point_gsrn' => $meteringPoint ? $meteringPoint->metering_point_id : '']]);
        $data = collect($data);
        $data = PaginationHelper::paginate($data, 10);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreChargeRequest $request
     * @return JsonResponse
     */
    public function store(StoreChargeRequest $request): JsonResponse
    {
        /** @var Charge $charge */
        $charge = Charge::create([
            'type' => $request['type'],
            'name' => $request['name'],
            'description' => $request['description'],
            'owner' => $request['owner'],
            'valid_from' => Carbon::parse($request['valid_from'], 'UTC')->timezone('Europe/Copenhagen')->toDateTimeString(),
            'valid_to' => $request['valid_to'] ? Carbon::parse($request['valid_to'], 'UTC')->timezone('Europe/Copenhagen')->toDateTimeString() : null,
            'period_type' => $request['period_type'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
            'metering_point_id' => $request['metering_point_id'],
        ]);

        if ($request['prices']) {
            foreach ($request['prices'] as $price) {
                /** @var ChargePrice $chargePrice */
                $chargePrice = app()->make(ChargePrice::class);
                $chargePrice->position = $price['position'];
                $chargePrice->price = $price['price'];
                $chargePrice->charge_id = $charge->id;
                $chargePrice->save();
            }
        }

        return response()->json($charge);
    }

    /**
     * Display the specified resource.
     *
     * @param Charge $charge
     * @return JsonResponse
     */
    public function show(Charge $charge): JsonResponse
    {
        return response()->json($charge);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateChargeRequest $request
     * @param Charge $charge
     * @return JsonResponse
     */
    public function update(UpdateChargeRequest $request, Charge $charge): JsonResponse
    {
        $requestArray = [
            'type' => $request['type'],
            'name' => $request['name'],
            'description' => $request['description'],
            'owner' => $request['owner'],
            'valid_from' => $request['valid_from'],
            'valid_to' => $request['valid_to'],
            'period_type' => $request['period_type'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
        ];
        $charge->update($requestArray);
        foreach ($charge->chargePrices as $price) {
            $price->delete();
        }
        if ($request['prices']) {
            foreach ($request['prices'] as $price) {
                $chargePrice = app()->make(ChargePrice::class);
                $chargePrice->position = $price['position'];
                $chargePrice->price = $price['price'];
                $chargePrice->charge_id = $charge->id;
                $chargePrice->save();
            }
        }

        return response()->json($charge);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Charge $charge
     * @return JsonResponse
     */
    public function destroy(Charge $charge): JsonResponse
    {
        foreach ($charge->chargePrices as $chargePrice) {
            $chargePrice->delete();
        }
        $charge->delete();

        return response()->json($charge);
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param MeteringPoint $meteringPoint
     * @return JsonResponse
     */
    public function destroyAll(MeteringPoint $meteringPoint): JsonResponse
    {
        $chargesQuery = Charge::whereMeteringPointId($meteringPoint->id);
        $charges = $chargesQuery->get();
        foreach ($charges as $charge) {
            ChargePrice::whereChargeId($charge->id)->delete();
        }
        $chargesQuery->delete();

        return response()->json($charges);
    }
}
