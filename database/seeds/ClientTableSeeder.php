<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(EloquentPopulator\Populator $populator)
    {
        $faker = Faker::create();
        for($i = 0; $i < 400; $i++)
        {
            DB::table('clients')->insert([
                'name' => $faker->name,
                'creator_id' => 1,
                'notes' => $faker->paragraph,
            ]);
        }
    }
}
