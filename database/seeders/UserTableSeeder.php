<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new User;
        $u->name = "jeff";
        $u->email = "jeff@aol.com";
        $u->password = "unsafePassword";
        $u->save();

        $u2 = new User;
        $u2->name = "Bob";
        $u2->email = "bob@mail.com";
        $u2->password = "password1";
        $u2->save();

        $u2 = new User;
        $u2->name = "Jim";
        $u2->email = "jim@mail.com";
        $u2->password = "safePassword";
        $u2->save();

        $users = User::factory()->count(5)->create();
    }
}
