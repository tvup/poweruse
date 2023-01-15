<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChargeRequest;
use App\Http\Requests\UpdateChargeRequest;
use App\Models\Charge;
use App\Models\ChargePrice;
use App\Models\MeteringPoint;
use App\Services\GetMeteringData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Tvup\ElOverblikApi\ElOverblikApiException;

class ChargeController extends Controller
{
    private GetMeteringData $meteringDataService;
    private bool $userIsLoggedIn;

    public function __construct(GetMeteringData $meteringDataService)
    {
        if(auth('api')->check()) {
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
    public function index(string $refresh_token = null) : JsonResponse
    {
        $meteringPointId = '';
        if($this->userIsLoggedIn) {
            if(!$refresh_token) {
                $meteringPoint = MeteringPoint::whereUserId(auth('api')->user()->id)->first();
                if($meteringPoint) {
                    $meteringPointId = $meteringPoint->metering_point_id;
                    $firstQuery = Charge::with('prices')->whereMeteringPointId($meteringPointId)->orderBy('id', 'desc')->whereType('Abonnement');
                    $secondQuery = Charge::with('prices')->whereMeteringPointId($meteringPointId)->orderBy('id', 'desc')->whereType('Tarif');
                    $thirdQuery = Charge::with('prices')->whereMeteringPointId($meteringPointId)->orderBy('id', 'desc')->whereType('Gebyr');
                    if ($firstQuery->count() + $secondQuery->count() + $thirdQuery->count() != 0) {
                        $data = [$firstQuery->get(), $secondQuery->get(), $thirdQuery->get(), [['metering_point_id' => $meteringPointId]]];
                        $data = collect($data);
                        $data = PaginationHelper::paginate($data, 10);
                        return response()->json($data);
                    }
                    $refresh_token = auth('api')->user()->refresh_token;
                }
            }
        }

        if(!$refresh_token) {
            return response()->json();
        }

        try {
            $data = $this->meteringDataService->getCharges($refresh_token);
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
        }
        array_push($data, [['metering_point_id' => $meteringPointId]]);
        $data = collect($data);
        $data = PaginationHelper::paginate($data, 10);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChargeRequest  $request
     * @return JsonResponse
     */
    public function store(StoreChargeRequest $request) : JsonResponse
    {
        $this->validate($request, [
                'type' => 'required|string',
                'name' => 'required|string',
                'description' => 'required|string',
                'owner' => 'required',
                'valid_from' => 'required|date',
                'valid_to' => 'nullable|date',
                'period_type' => 'required|string|max:5',
                'price' => 'nullable|string',
                'quantity' => 'nullable|string|max:4',
            ]
        );
        /** @var Charge $charge */
        $charge = Charge::create([
            'type' => $request['type'],
            'name' => $request['name'],
            'description' => $request['description'],
            'owner' => $request['owner'],
            'valid_from' => Carbon::parse($request['valid_from'],'UTC')->timezone('Europe/Copenhagen')->toDateTimeString(),
            'valid_to' => Carbon::parse($request['valid_to'],'UTC')->timezone('Europe/Copenhagen')->toDateTimeString(),
            'period_type' => $request['period_type'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
            'metering_point_id' => $request['metering_point_id']
        ]);

        if($request['prices']) {
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
     * @param  \App\Models\Charge  $charge
     * @return JsonResponse
     */
    public function show(Charge $charge) : JsonResponse
    {
        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChargeRequest  $request
     * @param  \App\Models\Charge  $charge
     * @return JsonResponse
     */
    public function update(UpdateChargeRequest $request, Charge $charge) : JsonResponse
    {
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Charge  $charge
     * @return JsonResponse
     */
    public function destroy(Charge $charge) : JsonResponse
    {
        return response()->json();
    }
}
