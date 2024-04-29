<?php

namespace Tests\Http\Controllers\Api;

use App\Http\Controllers\Api\ElController;
use App\Models\User;
use App\Services\GetPreliminaryInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use Tvup\ElOverblikApi\ElOverblikApiException;

class ElController2Test extends TestCase
{
    protected ElController $controller;

    protected MockObject $invoiceServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->invoiceServiceMock = $this->createMock(GetPreliminaryInvoice::class);
        $this->controller = new ElController($this->invoiceServiceMock);

        Auth::shouldReceive('user')
            ->andReturn(User::factory()->create(['refresh_token' => 'valid_token', 'smartme_directory_id' => 'dir123', 'smartme_username' => 'user', 'smartme_password' => 'pass']));
    }

    public function testPreliminaryInvoice() : void
    {
        $request = Request::create('/api/el', 'GET');

        $this->invoiceServiceMock
            ->method('getBill')
            ->willReturn(['status' => 'success', 'data' => 'Invoice Data']);

        $response = $this->controller->preliminaryInvoice($request);

        $this->assertEquals(200, $response->status());
        $this->assertEquals('{"status":"success","data":"Invoice Data"}', $response->getContent());
    }

    public function testPreliminaryInvoiceWithElOverblikApiException() : void
    {
        $request = Request::create('/api/el', 'GET');

        $this->invoiceServiceMock
            ->method('getBill')
            ->willThrowException(new ElOverblikApiException(['API Error'], '', 400));

        $response = $this->controller->preliminaryInvoice($request);

        $this->assertEquals(400, $response->status());
        $this->assertEquals('API Error', $response->getContent());
    }

    public function testPreliminaryInvoiceWithSmartMe() : void
    {
        $request = Request::create('/api/el/smartme', 'GET');

        $this->invoiceServiceMock
            ->method('getBill')
            ->willReturn(['status' => 'success', 'data' => 'Detailed Invoice Data']);

        $response = $this->controller->preliminaryInvoiceWithSmartMe($request);

        $this->assertEquals(200, $response->status());
    }

    public function testPreliminaryInvoiceWithSmartMeWithElOverblikApiException() : void
    {
        $request = Request::create('/api/el/smartme', 'GET');

        $this->invoiceServiceMock
            ->method('getBill')
            ->willThrowException(new ElOverblikApiException(['API Error'], '', 500));

        $response = $this->controller->preliminaryInvoiceWithSmartMe($request);

        $this->assertEquals(500, $response->status());
        $this->assertEquals('API Error', $response->getContent());
    }

//    public function testPreliminaryInvoiceWithSmartMeAndEwiiApiFallback() : void
//    {
//        $request = Request::create('/api/el/smartme', 'GET');
//
//        $this->invoiceServiceMock
//            ->expects($this->exactly(2))
//            ->method('getBill')
//            ->willThrowException(new ElOverblikApiException(['API Unavailable'], '', 503))
//            ->willReturnOnConsecutiveCalls(['status' => 'success', 'data' => 'Fallback Invoice Data']);
//
//        $response = $this->controller->preliminaryInvoiceWithSmartMe($request);
//
//        $this->assertEquals(200, $response->status());
//    }
}
