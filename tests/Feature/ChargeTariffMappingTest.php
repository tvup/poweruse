<?php

namespace Tests\Feature;

use App\Enums\SourceEnum;
use App\Models\ChargeTariffMapping;
use App\Models\DatahubPriceList;
use App\Services\GetDatahubPriceLists;
use App\Services\GetMeteringData;
use App\Services\GetPreliminaryInvoice;
use App\Services\Interfaces\GetSpotPricesInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Tests\TestCase;

class ChargeTariffMappingTest extends TestCase
{
    use RefreshDatabase;

    private array $charges;

    private mixed $spotPrices;

    private mixed $testConsumptions;

    /** @var Collection<int, DatahubPriceList> */
    private Collection $testCharges;

    protected function setUp(): void
    {
        parent::setUp();

        $this->charges = $this->loadTestData(test_fixture_path('typical_charges.json'));
        $this->spotPrices = $this->loadTestData(test_fixture_path('spot_prices.json'));
        $this->testConsumptions = $this->loadTestData(test_fixture_path('consumption_data.json'));

        $array = [];
        foreach ($this->loadTestData(test_fixture_path('charges.json')) as $object) {
            $datahubPriceList = new DatahubPriceList();
            $datahubPriceList->fill($object);
            array_push($array, $datahubPriceList);
        }
        $this->testCharges = collect($array);
    }

    public function test_stage1_auto_creates_verified_mappings(): void
    {
        $this->assertDatabaseCount('charge_tariff_mappings', 0);

        $this->runBillCalculation();

        $this->assertDatabaseCount('charge_tariff_mappings', 5);

        $this->assertDatabaseHas('charge_tariff_mappings', [
            'charge_name' => 'Transmissions nettarif',
            'charge_owner_gln' => '5790000432752',
            'datahub_note' => 'Transmissions nettarif',
            'datahub_gln' => '5790000432752',
        ]);

        $this->assertDatabaseHas('charge_tariff_mappings', [
            'charge_name' => 'Nettarif C time',
            'charge_owner_gln' => '5790000705689',
            'datahub_note' => 'Nettarif C time',
            'datahub_gln' => '5790000705689',
        ]);
    }

    public function test_existing_mapping_is_used_for_lookup(): void
    {
        ChargeTariffMapping::create([
            'charge_name' => 'Transmissions nettarif',
            'charge_owner_gln' => '5790000432752',
            'datahub_note' => 'Transmissions nettarif',
            'datahub_gln' => '5790000432752',
            'datahub_charge_type' => 'D03',
            'datahub_description' => 'Netafgiften, for både forbrugere og producenter, dækker omkostninger til drift og vedligehold af det overordnede elnet (132/150 og 400 kv nettet) og drift og vedligehold af udlandsforbindelserne.',
            'verified' => true,
        ]);

        $result = $this->runBillCalculation();

        $this->assertArrayHasKey('Transmissions nettarif', $result);
        $this->assertEquals(1.65, $result['Transmissions nettarif']);

        // Still 5 mappings total (1 pre-existing + 4 auto-created)
        $this->assertDatabaseCount('charge_tariff_mappings', 5);
    }

    public function test_mapping_unique_constraint_prevents_duplicates(): void
    {
        ChargeTariffMapping::create([
            'charge_name' => 'Elafgift',
            'charge_owner_gln' => '5790000432752',
            'datahub_note' => 'Elafgift',
            'datahub_gln' => '5790000432752',
            'verified' => false,
        ]);

        $this->runBillCalculation();

        // updateOrCreate should not duplicate — still 5 total
        $this->assertDatabaseCount('charge_tariff_mappings', 5);
    }

    private function runBillCalculation(): array
    {
        $this->mock(GetMeteringData::class, function (MockInterface $mock) {
            $mock->shouldReceive('getData')->once()->andReturn($this->testConsumptions);
            $mock->shouldReceive('getCharges')->once()->andReturn($this->charges);
        });

        $this->mock(GetSpotPricesInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getData')->once()->andReturn($this->spotPrices);
        });

        $this->mock(GetDatahubPriceLists::class, function (MockInterface $mock) {
            $mock->shouldReceive('getQueryForFetchingSpecificTariffFromDB')->andReturnUsing(
                function (string $name, string $gln, string $description, string $toDate, string $fromDate) {
                    return DatahubPriceList::whereNote($name)
                        ->whereGlnNumber($gln)
                        ->whereDescription($description)
                        ->whereRaw('NOT (ValidFrom > \'' . $fromDate . '\' OR (IF(ValidTo is null,\'2030-01-01\',ValidTo) < \'' . $fromDate . '\' ))');
                }
            );

            $mock->shouldReceive('getQueryForFetchingTariffByGlnAndNameLike')->andReturnUsing(
                function (string $name, string $gln, string $toDate, string $fromDate) {
                    return DatahubPriceList::where('Note', 'LIKE', $name . '%')
                        ->whereGlnNumber($gln)
                        ->whereRaw('NOT (ValidFrom > \'' . $fromDate . '\' OR (IF(ValidTo is null,\'2030-01-01\',ValidTo) < \'' . $fromDate . '\' ))');
                }
            );

            $mock->shouldReceive('getFromQuery')->andReturnUsing(
                function ($query) {
                    $wheres = $query->getQuery()->wheres;
                    $note = null;
                    $isLike = false;
                    foreach ($wheres as $where) {
                        if (($where['column'] ?? '') === 'Note') {
                            $note = $where['value'];
                            $isLike = ($where['operator'] ?? '=') === 'LIKE';
                            break;
                        }
                    }
                    if ($note && $isLike) {
                        $prefix = rtrim($note, '%');

                        return $this->testCharges->filter(fn ($item) => str_starts_with($item->Note, $prefix));
                    }
                    if ($note) {
                        return $this->testCharges->filter(fn ($item) => $item->Note === $note);
                    }

                    return collect();
                }
            );
        });

        $preLiminaryInvoice = app(GetPreliminaryInvoice::class);

        return $preLiminaryInvoice->getBill(
            '2025-10-01',
            '2025-10-01',
            'DK2',
            null,
            SourceEnum::POWERUSE,
            'someFakeRefreshToken'
        );
    }
}
