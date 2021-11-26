<?php

namespace Database\Seeders;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p1 = new Post;
        $p1->type = "Chat";
        $p1->body = "how to ollie better?";
        $p1->postable_id = 1;
        $p1->postable_type = "App\Models\UserProfile";
        $p1->save();

        $p2 = new Post;
        $p2->type = "Spots";
        $p2->body = "Checkout this great bench";
        $p2->postable_id = 2;
        $p2->postable_type = "App\Models\UserProfile";
        $p2->save();

        //$posts = Post::factory()->count(5)->create();
    }
}
