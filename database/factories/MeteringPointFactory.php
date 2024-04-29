<?php

namespace Database\Factories;

use App\Models\MeteringPoint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MeteringPoint>
 */
class MeteringPointFactory extends Factory
{
    protected $model = MeteringPoint::class;

    public function definition(): array
    {
        return [
            'metering_point_id' => $this->faker->word(),
            'type_of_mp' => $this->faker->randomLetter(),
            'settlement_method' => $this->faker->randomLetter(),
            'meter_number' => $this->faker->word(),
            'consumer_c_v_r' => $this->faker->numberBetween(0,9999999),
            'data_access_c_v_r' => $this->faker->numberBetween(0,9999999),
            'consumer_start_date' => Carbon::now('Europe/Copenhagen')->startOfDay(),
            'meter_reading_occurrence' => $this->faker->text(5),
            'balance_supplier_name' => $this->faker->name(),
            'street_code' => $this->faker->numberBetween(0,9),
            'street_name' => $this->faker->streetName(),
            'building_number' => $this->faker->numberBetween(0,19),
            'floor_id' => $this->faker->randomLetter(),
            'room_id' => $this->faker->randomLetter(),
            'city_name' => $this->faker->city(),
            'city_sub_division_name' => $this->faker->name(),
            'municipality_code' => $this->faker->numberBetween(0,119),
            'location_description' => $this->faker->words(4, true),
            'first_consumer_party_name' => $this->faker->firstName(),
            'second_consumer_party_name' => $this->faker->name(),
            'hasRelation' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'parent_id' => $this->faker->word(),

            'user_id' => User::factory(),
        ];
    }
}
