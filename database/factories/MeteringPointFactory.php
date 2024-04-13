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
            'type_of_mp' => $this->faker->word(),
            'settlement_method' => $this->faker->word(),
            'meter_number' => $this->faker->word(),
            'consumer_c_v_r' => $this->faker->numberBetween(0,9999999),
            'data_access_c_v_r' => $this->faker->numberBetween(0,9999999),
            'consumer_start_date' => Carbon::now(),
            'meter_reading_occurrence' => $this->faker->word(),
            'balance_supplier_name' => $this->faker->name(),
            'street_code' => $this->faker->streetName(),
            'street_name' => $this->faker->name(),
            'building_number' => $this->faker->word(),
            'floor_id' => $this->faker->randomLetter(),
            'room_id' => $this->faker->randomLetter(),
            'city_name' => $this->faker->name(),
            'city_sub_division_name' => $this->faker->name(),
            'municipality_code' => $this->faker->word(),
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
