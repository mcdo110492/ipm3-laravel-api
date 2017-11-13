<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $now = Carbon::now();

        DB::table('positions')->insert([
            'positionId'    =>  1,
            'positionCode'  =>  'DR',
            'positionName'  =>  'Driver',
            'created_at'    =>  $now,
            'updated_at'    =>  $now
        ]);

        DB::table('positions')->insert([
            'positionId'    =>  2,
            'positionCode'  =>  'PLR',
            'positionName'  =>  'Paleros',
            'created_at'    =>  $now,
            'updated_at'    =>  $now
        ]);

        DB::table('positions')->insert([
            'positionId'    =>  3,
            'positionCode'  =>  'STR',
            'positionName'  =>  'Strikers',
            'created_at'    =>  $now,
            'updated_at'    =>  $now
        ]);


    }
}
