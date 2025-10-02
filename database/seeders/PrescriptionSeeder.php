<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    public function run()
    {
        // call the factory
        \App\Models\Prescription::factory(10)->create();
    }
}
