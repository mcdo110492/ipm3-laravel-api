<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            'username'      =>  'admin',
            'password'      =>  Hash::make('admin'),
            'profileName'   =>  'Admin',
            'role'          =>  1,
            'projectId'     =>  0,
            'created_at'    =>  $now,
            'updated_at'    =>  $now
        ]);
    }
}
