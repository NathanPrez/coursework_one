<?php

namespace Database\Seeders;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UserProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $up = new UserProfile;
        $up->username = "Berrics";
        $up->bio = "Best skatepage there is";
        $up->user_id = 7;
        $up->save();

        $up2 = new UserProfile;
        $up2->username = "Nyjah";
        $up2->bio = "I can ollie a good 2cm";
        $up2->user_id = 2;
        $up2->save();

        $up2 = new UserProfile;
        $up2->username = "Tony_Hawk";
        $up2->bio = "Im a god";
        $up2->user_id = 3;
        $up2->save();

        $up2 = new UserProfile;
        $up2->username = "Skate_GOAT";
        $up2->bio = "A true goat of the sport";
        $up2->user_id = 4;
        $up2->save();
    }
}
