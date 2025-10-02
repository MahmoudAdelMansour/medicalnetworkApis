<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // call the factory
        \App\Models\User::factory(10)->create();
    }
}
