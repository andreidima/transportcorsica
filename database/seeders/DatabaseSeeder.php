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
        // \App\Models\User::factory(10)->create();
        // \App\Models\Rezervare::factory(20)->create();
        // \App\Models\Pasager::factory(5)->create();
        // \App\Models\Rezervare::factory(25)->create()->each(function($rezervare) {
        //     $rezervare->pasageri_relation()->attach(\App\Models\Pasager::factory(rand(1, 5))->create());
        // });
        \App\Models\ClientNeserios::factory(10)->create();
    }
}
