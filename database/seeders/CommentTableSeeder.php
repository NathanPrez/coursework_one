<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c = new Comment;
        $c->body = "I hope you get full marks";
        $c->post_id = 2;
        $c->user_id = 1;
        $c->save();

        $comments = Comment::factory()->count(10)->create();
    }
}
