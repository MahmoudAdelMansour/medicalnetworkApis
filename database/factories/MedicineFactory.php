<?php

namespace Database\Factories;

use App\Models\Medicine;
use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MedicineFactory extends Factory
{
    protected $model = Medicine::class;

    public function definition()
    {
//

        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(),
            'brand_names' => $this->faker->word(),
            'active_ingredient' => $this->faker->word(),
            'strength' => $this->faker->randomNumber(),
            'strength_unit' => $this->faker->randomElement(['mg', 'g', 'mL']),
            'manufacturer' => $this->faker->randomElement(['AstraZeneca', 'Pfizer', 'Moderna']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'pharmacy_id' => Pharmacy::factory(),
        ];
    }
}
