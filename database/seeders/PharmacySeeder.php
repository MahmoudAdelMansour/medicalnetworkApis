<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PharmacySeeder extends Seeder
{
    public function run()
    {
        // call the factory
        \App\Models\Pharmacy::factory(10)->create();
    }
}
