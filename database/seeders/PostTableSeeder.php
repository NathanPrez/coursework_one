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
        $p1->type = "chat";
        $p1->body = "how to ollie better?";
        $p1->postable_id = 1;
        $p1->postable_type = "App\Models\UserProfile";
        $p1->save();

        $p2 = new Post;
        $p2->type = "meet";
        $p2->body = "Meet at 7";
        $p2->postable_id = 2;
        $p2->postable_type = "App\Models\UserProfile";
        $p2->save();

        $posts = Post::factory()->count(15)->create();
    }
}
