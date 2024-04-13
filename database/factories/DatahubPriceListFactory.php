<?php

namespace Database\Factories;

use App\Models\DatahubPriceList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DatahubPriceList>
 */
class DatahubPriceListFactory extends Factory
{
    protected $model = DatahubPriceList::class;

    public function definition(): array
    {
        return [
            'ChargeOwner' => $this->faker->word(),
            'GLN_number' => $this->faker->word(),
            'ChargeType' => $this->faker->word(),
            'ChargeTypeCode' => $this->faker->word(),
            'Note' => $this->faker->word(),
            'Description' => $this->faker->text(),
            'ValidFrom' => Carbon::now(),
            'ValidTo' => Carbon::now(),
            'VATClass' => $this->faker->word(),
            'Price1' => $this->faker->randomFloat(),
            'Price2' => $this->faker->randomFloat(),
            'Price3' => $this->faker->randomFloat(),
            'Price4' => $this->faker->randomFloat(),
            'Price5' => $this->faker->randomFloat(),
            'Price6' => $this->faker->randomFloat(),
            'Price7' => $this->faker->randomFloat(),
            'Price8' => $this->faker->randomFloat(),
            'Price9' => $this->faker->randomFloat(),
            'Price10' => $this->faker->randomFloat(),
            'Price11' => $this->faker->randomFloat(),
            'Price12' => $this->faker->randomFloat(),
            'Price13' => $this->faker->randomFloat(),
            'Price14' => $this->faker->randomFloat(),
            'Price15' => $this->faker->randomFloat(),
            'Price16' => $this->faker->randomFloat(),
            'Price17' => $this->faker->randomFloat(),
            'Price18' => $this->faker->randomFloat(),
            'Price19' => $this->faker->randomFloat(),
            'Price20' => $this->faker->randomFloat(),
            'Price21' => $this->faker->randomFloat(),
            'Price22' => $this->faker->randomFloat(),
            'Price23' => $this->faker->randomFloat(),
            'Price24' => $this->faker->randomFloat(),
            'TransparentInvoicing' => $this->faker->randomNumber(),
            'TaxIndicator' => $this->faker->randomNumber(),
            'ResolutionDuration' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'deleted_at' => Carbon::now(),
            'GLN_Number' => $this->faker->word(),
        ];
    }
}
