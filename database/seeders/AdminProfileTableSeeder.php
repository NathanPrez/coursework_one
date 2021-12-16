<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $up = new AdminProfile;
        $up->user_id = 1;
        $up->save();
    }
}
