<?php

use Illuminate\Database\Seeder;

class StopPointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('StopPoints')->insert([
            ['external_id' => 50280388, 'name' => 'Остановка #1'],
            ['external_id' => 50280122, 'name' => 'Остановка #2'],
            ['external_id' => 50280332, 'name' => 'Остановка #3'],
            ['external_id' => 50280429, 'name' => 'Остановка #4'],
            ['external_id' => 50280490, 'name' => 'Остановка #5'],
            ['external_id' => 50280517, 'name' => 'Остановка #6'],
            ['external_id' => 50280347, 'name' => 'Остановка #7'],
            ['external_id' => 50280424, 'name' => 'Остановка #8'],
            ['external_id' => 50280457, 'name' => 'Остановка #9'],
            ['external_id' => 50280334, 'name' => 'Остановка #10'],
            ['external_id' => 50280334, 'name' => 'Остановка #11'],
            ['external_id' => 50280031, 'name' => 'Остановка #12'],
            ['external_id' => 50280388, 'name' => 'Остановка #13'],
        ]);
    }
}
