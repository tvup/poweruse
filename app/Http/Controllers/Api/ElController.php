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
        $this->logApiAccess('preliminaryInvoice', $request);
        try {
            return $this->getPreliminaryInvoice(auth()->user()->refresh_token);
        } catch (ElOverblikApiException | \InvalidArgumentException $e) {
            return response($e->getMessage(), $e->getCode(), ['Content-Type' => 'text/plain']);
        }
    }

    public function preliminaryInvoiceWithSmartMe(Request $request) : Response|JsonResponse
    {
        $this->logApiAccess('preliminaryInvoiceWithSmartMe', $request);
        $user = auth()->user();
        try {
            $smartMeCredentials = [
                'id' => $user->smartme_directory_id,
                'username' => $user->smartme_username,
                'password' => $user->smartme_password,
            ];

            return $this->getPreliminaryInvoice(auth()->user()->refresh_token, null, SourceEnum::DATAHUB, $smartMeCredentials, now()->startOfMonth(), now(), 'DK2', 23.20, 0.048, auth()->user());
        } catch (ElOverblikApiException $exception) {
            return response($exception->getMessage(), $exception->getCode())
                ->header('Content-Type', 'text/plain');
        }
    }

    private function logApiAccess(string $method, Request $request): void
    {
        $user = auth()->user();
        $authMethod = $request->bearerToken() ? 'Bearer token' : ($request->header('Authorization') ? 'API key' : 'Session');
        $userName = $user ? $user->name : 'Anonymous';

        logger()->info("API call: {$method} | Auth: {$authMethod} | User: {$userName} | Time: " . now('Europe/Copenhagen')->format('Y-m-d H:i:s'));
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
    private function getPreliminaryInvoice(string $refreshToken, ?array $ewiiCredentials = null, SourceEnum $dataSource = SourceEnum::POWERUSE, ?array $smartMeCredentials = null, ?string $start_date = null, ?string $end_date = null, string $price_area = 'DK2', float $subscription = 23.20, float $overhead = 0.048, ?User $user = null) : Response|JsonResponse
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
