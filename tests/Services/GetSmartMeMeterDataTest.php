<?php

namespace Tests\Services;

use App\Services\GetSmartMeMeterData;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetSmartMeMeterDataTest extends TestCase
{
    const EXPECTED_COUNTER_READING = 100042;
    const COUNTER_READING_20220901_0100 = 100042;
    const COUNTER_READING_20220901_0200 = 100084;
    const COUNTER_READING_20220901_0300 = 100118;
    const COUNTER_READING_20220901_0400 = 100118;
    const SMART_ME_ID = 'MY_PRECISOUS_ID';
    const SMART_ME_USERNAME = 'MY_GLORIOUS_USERNAME';
    const SMART_ME_PASSWORD = 'MY_AWAESOME_PASSWORD';

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake([
            'smart-me.com/api/MeterValues/'.self::SMART_ME_ID.'?date='. urlencode('2022-09-01T01:00:00Z')
                => Http::response(['CounterReading' => self::COUNTER_READING_20220901_0100], 200),
            'smart-me.com/api/MeterValues/'.self::SMART_ME_ID.'?date='. urlencode('2022-09-01T02:00:00Z')
                => Http::response(['CounterReading' => self::COUNTER_READING_20220901_0200], 200),
            'smart-me.com/api/MeterValues/'.self::SMART_ME_ID.'?date='. urlencode('2022-09-01T03:00:00Z')
                => Http::response(['CounterReading' => self::COUNTER_READING_20220901_0300], 200),
            'smart-me.com/api/MeterValues/'.self::SMART_ME_ID.'?date='. urlencode('2022-09-01T04:00:00Z')
                => Http::response(['CounterReading' => self::COUNTER_READING_20220901_0400], 200),
            'smart-me.com/*' => Http::response(['CounterReading' => self::EXPECTED_COUNTER_READING], 200),
        ]);
        config(['services.smartme.id'=> self::SMART_ME_ID]);
    }

    public function test_get_from_date()
    {
        $service = new GetSmartMeMeterData();
        $reading = $service->getFromDate();
        $this->assertEquals(self::EXPECTED_COUNTER_READING, $reading);
        Http::assertSent(function (Request $request) {
            $date = Carbon::now('Europe/Copenhagen')->startOfHour()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
            return
                $request->url() == 'https://smart-me.com/api/MeterValues/'.self::SMART_ME_ID.'?date='. urlencode($date) &&
                $request['date'] == $date;
        });
        Http::assertSentCount(1);
    }

    public function test_get_from_date_where_smart_me_true()
    {
        $service = new GetSmartMeMeterData();
        $reading = $service->getFromDate(true);
        $this->assertEquals(self::EXPECTED_COUNTER_READING, $reading);
        Http::assertSent(function (Request $request) {
            $date = Carbon::now('Europe/Copenhagen')->startOfHour()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
            return
                $request->url() == 'https://smart-me.com/api/MeterValues/'.self::SMART_ME_ID.'?date='. urlencode($date) &&
                $request['date'] == $date;
        });
        Http::assertSentCount(1);
    }

    public function test_get_from_date_with_smart_credentials()
    {
        $service = new GetSmartMeMeterData();
        $smartMe = ['id'=>self::SMART_ME_ID, 'username'=>self::SMART_ME_USERNAME, 'password'=>self::SMART_ME_PASSWORD];
        $reading = $service->getFromDate($smartMe);
        $this->assertEquals(self::EXPECTED_COUNTER_READING, $reading);
        Http::assertSent(function (Request $request) {
            $date = Carbon::now('Europe/Copenhagen')->startOfHour()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
            return
                $request->url() == 'https://smart-me.com/api/MeterValues/'.self::SMART_ME_ID.'?date='. urlencode($date) &&
                $request['date'] == $date &&
                $request->header('Authorization')[0] == 'Basic ' . base64_encode(self::SMART_ME_USERNAME . ':' . self::SMART_ME_PASSWORD);
        });
        Http::assertSentCount(1);
    }

    public function test_get_interval_from_date()
    {
        $service = new GetSmartMeMeterData();
        $smartMe = ['id' => self::SMART_ME_ID, 'username' => self::SMART_ME_USERNAME, 'password' => self::SMART_ME_PASSWORD];
        $reading = $service->getInterval($smartMe, '2022-09-01T01:00:00Z');
        $expectedResult = [
            '2022-09-01T03:00:00' => (string)(self::COUNTER_READING_20220901_0200 - self::COUNTER_READING_20220901_0100),
            '2022-09-01T04:00:00' => (string)(self::COUNTER_READING_20220901_0300 - self::COUNTER_READING_20220901_0200),
            '2022-09-01T05:00:00' => (string)(self::COUNTER_READING_20220901_0400 - self::COUNTER_READING_20220901_0300)
        ];
        $this->assertEquals($expectedResult, $reading);
        Http::assertSent(function (Request $request) {
            $date = '2022-09-01T01:00:00Z';
            return
                $request->url() == 'https://smart-me.com/api/MeterValues/' . self::SMART_ME_ID . '?date=' . urlencode($date) &&
                $request['date'] == $date &&
                $request->header('Authorization')[0] == 'Basic ' . base64_encode(self::SMART_ME_USERNAME . ':' . self::SMART_ME_PASSWORD);
        });
        Http::assertSentCount(4);
    }
}
