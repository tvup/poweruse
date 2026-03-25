<?php

namespace Tests\Services;

use App\Services\GetSmartMeMeterData;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetSmartMeMeterDataTest extends TestCase
{
    public const EXPECTED_COUNTER_READING = 100042;

    public const SMART_ME_ID = 'MY_PRECISOUS_ID';

    public const SMART_ME_USERNAME = 'MY_GLORIOUS_USERNAME';

    public const SMART_ME_PASSWORD = 'MY_AWAESOME_PASSWORD';

    /**
     * 15-minute counter readings for 2022-09-01 from 01:00 UTC to 03:15 UTC.
     * Consumption per 15-min interval is the difference between consecutive readings.
     * Readings plateau at 100080 from 03:00 UTC onward to terminate the loop.
     *
     * @var array<string, float>
     */
    public const COUNTER_READINGS_15MIN = [
        '2022-09-01T01:00:00Z' => 100000,
        '2022-09-01T01:15:00Z' => 100010,
        '2022-09-01T01:30:00Z' => 100020,
        '2022-09-01T01:45:00Z' => 100030,
        '2022-09-01T02:00:00Z' => 100040,
        '2022-09-01T02:15:00Z' => 100050,
        '2022-09-01T02:30:00Z' => 100060,
        '2022-09-01T02:45:00Z' => 100070,
        '2022-09-01T03:00:00Z' => 100080,
        '2022-09-01T03:15:00Z' => 100080,
    ];

    /**
     * 15-minute counter readings for DST transition on 2022-10-30.
     * Start at 01:00 UTC (02:00 CET). DST transition at 01:00 UTC (03:00 CEST -> 02:00 CET).
     * Readings plateau at 02:00 UTC onward to terminate the loop.
     *
     * @var array<string, float>
     */
    public const COUNTER_READINGS_DST = [
        '2022-10-30T01:00:00Z' => 200000,
        '2022-10-30T01:15:00Z' => 200010,
        '2022-10-30T01:30:00Z' => 200020,
        '2022-10-30T01:45:00Z' => 200030,
        '2022-10-30T02:00:00Z' => 200040,
        '2022-10-30T02:15:00Z' => 200040,
    ];

    private array $smartMeCredentials;

    protected function setUp(): void
    {
        parent::setUp();
        $this->smartMeCredentials = [
            'id' => self::SMART_ME_ID,
            'username' => 'test-user',
            'password' => 'test-pass',
        ];
    }

    /**
     * Build Http::fake URL map from a counter readings array.
     *
     * @param array<string, float> $readings
     * @return void
     */
    private function fakeSmartMeResponses(array $readings): void
    {
        $fakes = [];
        foreach ($readings as $timestamp => $value) {
            $fakes['smart-me.com/api/MeterValues/' . self::SMART_ME_ID . '?date=' . urlencode($timestamp)] =
                Http::response(['CounterReading' => $value], 200);
        }
        $fakes['smart-me.com/*'] = Http::response(['CounterReading' => self::EXPECTED_COUNTER_READING], 200);
        Http::fake($fakes);
    }

    public function test_get_from_date() : void
    {
        $this->fakeSmartMeResponses(self::COUNTER_READINGS_15MIN);
        $service = new GetSmartMeMeterData();
        $reading = $service->getFromDate($this->smartMeCredentials);
        $this->assertEquals(self::EXPECTED_COUNTER_READING, $reading);
        Http::assertSent(function (Request $request) {
            $date = Carbon::now('Europe/Copenhagen')->startOfHour()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');

            return
                $request->url() == 'https://smart-me.com/api/MeterValues/' . self::SMART_ME_ID . '?date=' . urlencode($date) &&
                $request['date'] == $date;
        });
        Http::assertSentCount(1);
    }

    public function test_get_from_date_where_smart_me_true() : void
    {
        $this->fakeSmartMeResponses(self::COUNTER_READINGS_15MIN);
        $service = new GetSmartMeMeterData();
        $reading = $service->getFromDate($this->smartMeCredentials);
        $this->assertEquals(self::EXPECTED_COUNTER_READING, $reading);
        Http::assertSent(function (Request $request) {
            $date = Carbon::now('Europe/Copenhagen')->startOfHour()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');

            return
                $request->url() == 'https://smart-me.com/api/MeterValues/' . self::SMART_ME_ID . '?date=' . urlencode($date) &&
                $request['date'] == $date;
        });
        Http::assertSentCount(1);
    }

    public function test_get_from_date_with_smart_credentials() : void
    {
        $this->fakeSmartMeResponses(self::COUNTER_READINGS_15MIN);
        $service = new GetSmartMeMeterData();
        $smartMe = ['id'=>self::SMART_ME_ID, 'username'=>self::SMART_ME_USERNAME, 'password'=>self::SMART_ME_PASSWORD];
        $reading = $service->getFromDate($smartMe);
        $this->assertEquals(self::EXPECTED_COUNTER_READING, $reading);
        Http::assertSent(function (Request $request) {
            $date = Carbon::now('Europe/Copenhagen')->startOfHour()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');

            return
                $request->url() == 'https://smart-me.com/api/MeterValues/' . self::SMART_ME_ID . '?date=' . urlencode($date) &&
                $request['date'] == $date &&
                $request->header('Authorization')[0] == 'Basic ' . base64_encode(self::SMART_ME_USERNAME . ':' . self::SMART_ME_PASSWORD);
        });
        Http::assertSentCount(1);
    }

    public function test_get_interval_from_date() : void
    {
        $this->fakeSmartMeResponses(self::COUNTER_READINGS_15MIN);
        $service = new GetSmartMeMeterData();
        $smartMe = ['id' => self::SMART_ME_ID, 'username' => self::SMART_ME_USERNAME, 'password' => self::SMART_ME_PASSWORD];
        $reading = $service->getInterval('2022-09-01 03:00:00', null, $smartMe);
        // 9 entries: 8 intervals of 10 kWh each, plus the final 0 that terminates the loop
        $expectedResult = [
            '2022-09-01T03:00:00+02:00' => 10.0,
            '2022-09-01T03:15:00+02:00' => 10.0,
            '2022-09-01T03:30:00+02:00' => 10.0,
            '2022-09-01T03:45:00+02:00' => 10.0,
            '2022-09-01T04:00:00+02:00' => 10.0,
            '2022-09-01T04:15:00+02:00' => 10.0,
            '2022-09-01T04:30:00+02:00' => 10.0,
            '2022-09-01T04:45:00+02:00' => 10.0,
            '2022-09-01T05:00:00+02:00' => 0.0,
        ];
        $this->assertEquals($expectedResult, $reading);
        Http::assertSent(function (Request $request) {
            $date = '2022-09-01T01:00:00Z';

            return
                $request->url() == 'https://smart-me.com/api/MeterValues/' . self::SMART_ME_ID . '?date=' . urlencode($date) &&
                $request['date'] == $date &&
                $request->header('Authorization')[0] == 'Basic ' . base64_encode(self::SMART_ME_USERNAME . ':' . self::SMART_ME_PASSWORD);
        });
        // 1 initial call + 9 loop iterations = 10 total API calls
        Http::assertSentCount(10);
    }

    public function test_get_interval_from_date_during_dls() : void
    {
        $this->fakeSmartMeResponses(self::COUNTER_READINGS_DST);
        $service = new GetSmartMeMeterData();
        $smartMe = ['id' => self::SMART_ME_ID, 'username' => self::SMART_ME_USERNAME, 'password' => self::SMART_ME_PASSWORD];
        $reading = $service->getInterval('2022-10-30 02:00:00', null, $smartMe);
        // 5 iterations: 4 intervals of 10 kWh, DST extra entry, and final 0 that terminates
        $expectedResult = [
            '2022-10-30T02:00:00+01:00' => 10.0,
            '2022-10-30T02:15:00+01:00' => 10.0,
            '2022-10-30T02:30:00+01:00' => 10.0,
            '2022-10-30T02:00:00+02:00' => 10.0,
            '2022-10-30T02:45:00+01:00' => 10.0,
            '2022-10-30T03:00:00+01:00' => 0.0,
        ];
        $this->assertEquals($expectedResult, $reading);
        Http::assertSent(function (Request $request) {
            $date = '2022-10-30T01:00:00Z';

            return
                $request->url() == 'https://smart-me.com/api/MeterValues/' . self::SMART_ME_ID . '?date=' . urlencode($date) &&
                $request['date'] == $date &&
                $request->header('Authorization')[0] == 'Basic ' . base64_encode(self::SMART_ME_USERNAME . ':' . self::SMART_ME_PASSWORD);
        });
        // 1 initial call + 5 loop iterations = 6 total API calls
        Http::assertSentCount(6);
    }
}
