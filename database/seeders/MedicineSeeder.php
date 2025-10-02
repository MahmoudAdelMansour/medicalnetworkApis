<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run()
    {
        // call the factory
        \App\Models\Medicine::factory(10)->create();
    }
}
