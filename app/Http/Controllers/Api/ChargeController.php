<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChargeRequest;
use App\Http\Requests\UpdateChargeRequest;
use App\Models\Charge;
use App\Services\GetMeteringData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Tvup\ElOverblikApi\ElOverblikApiException;

class ChargeController extends Controller
{
    private GetMeteringData $meteringDataService;

    public function __construct(GetMeteringData $meteringDataService)
    {
        $this->meteringDataService = $meteringDataService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $refreshToken = config('services.energioverblik.refresh_token');

        try {
            $data = $this->meteringDataService->getCharges($refreshToken);
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
                'prices' => 'nullable|string|max:40',
            ]
        );

        return response()->json(Charge::create([
            'type' => $request['type'],
            'name' => $request['name'],
            'description' => $request['description'],
            'owner' => $request['owner'],
            'valid_from' => Carbon::parse($request['valid_from'],'UTC')->timezone('Europe/Copenhagen')->toDateTimeString(),
            'valid_to' => Carbon::parse($request['valid_to'],'UTC')->timezone('Europe/Copenhagen')->toDateTimeString(),
            'period_type' => $request['period_type'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
            //'prices' => $request['prices'],
            'metering_point_id' => $request['metering_point_id']
        ]));
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
