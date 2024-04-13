<?php

namespace Tests\Integration;

use App\Services\GetElprisenSpotPrices;
use Tests\TestCase;

class GetElprisenSpotPricesTest extends TestCase
{
    protected GetElprisenSpotPrices $service;

    protected function setUp(): void
    {
        $this->service = new GetElprisenSpotPrices();
        parent::setUp();
    }

    public function testGetDataWithDefaultParams() : void
    {
        $result = $this->service->getData();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function testGetDataWithSpecificDates() : void
    {
        $startDate = '2023-01-01';
        $endDate = '2023-01-03';

        $result = $this->service->getData($startDate, $endDate, 'DK1');

        $this->assertIsArray($result);
        $this->assertCount(48, $result);
    }
}
