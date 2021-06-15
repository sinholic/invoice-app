<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Client::factory(10)->create();
        \App\Models\Item::factory(10)->create();
        \App\Models\Item::factory(10)->food()->create();
    }
}
