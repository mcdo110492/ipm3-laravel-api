<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        
                DB::table('projects')->insert([
                    'projectCode'      =>  'BCD',
                    'projectName'      =>  'Bacolod City',
                    'created_at'       =>  $now,
                    'updated_at'       =>  $now
                ]);
    }
}
