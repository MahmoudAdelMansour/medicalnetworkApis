<?php

namespace Database\Factories;

use App\Models\Prescription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PrescriptionFactory extends Factory
{
    protected $model = Prescription::class;

    public function definition()
    {
        return [
            'file' => 'https://watanimg.elwatannews.com/image_archive/original_lower_quality/6331030221708601045.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
