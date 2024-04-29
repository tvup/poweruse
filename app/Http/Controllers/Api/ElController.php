<?php

namespace App\Http\Controllers\Api;

use App\Enums\SourceEnum;
use App\Exceptions\DataUnavailableException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GetPreliminaryInvoice;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tvup\ElOverblikApi\ElOverblikApiException;

class ElController extends Controller
{
    public function __construct(
        private readonly GetPreliminaryInvoice $preliminaryInvoiceService,
    ) {
    }

    public function preliminaryInvoice(Request $request) : Response|JsonResponse
    {
        try {
            return $this->getPreliminaryInvoice(auth()->user()->refresh_token);
        } catch (ElOverblikApiException | \InvalidArgumentException $e) {
            return response($e->getMessage(), $e->getCode(), ['Content-Type' => 'text/plain']);
        }
    }

    public function preliminaryInvoiceWithSmartMe(Request $request) : Response|JsonResponse
    {
        $user = auth()->user();
        try {
            $smartMeCredentials = [
                $user->smartme_directory_id,
                $user->smartme_username,
                $user->smartme_password];

            return $this->getPreliminaryInvoice(auth()->user()->refresh_token, null, SourceEnum::DATAHUB, $smartMeCredentials, now()->startOfMonth(), now(), 'DK2', 25, 1, auth()->user());
        } catch (ElOverblikApiException $exception) {
            return response($exception->getMessage(), $exception->getCode())
                ->header('Content-Type', 'text/plain');
        }
    }

    /**
     * @param string $refreshToken
     * @param array{'ewiiEmail': string, 'ewiiPassword': string}|null $ewiiCredentials
     * @param SourceEnum $dataSource
     * @param array|null $smartMeCredentials
     * @param string|null $start_date
     * @param string|null $end_date
     * @param string $price_area
     * @param float $subscription
     * @param float $overhead
     * @param User|null $user
     * @return Response|JsonResponse
     * @throws DataUnavailableException
     * @throws ElOverblikApiException
     */
    private function getPreliminaryInvoice(string $refreshToken, array $ewiiCredentials = null, SourceEnum $dataSource = SourceEnum::POWERUSE, array $smartMeCredentials = null, string $start_date = null, string $end_date = null, string $price_area = 'DK2', float $subscription = 23.20, float $overhead = 0.015, User $user = null) : Response|JsonResponse
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
        $bill = $this->preliminaryInvoiceService->getBill($start_date, $end_date, $price_area, $smartMeCredentials, $dataSource, $refreshToken, $subscription, $overhead, $user);

        return response()->json($bill);
    }
}
