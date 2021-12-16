<?php

namespace Database\Seeders;
use App\Models\Comment;
use Illuminate\Database\Seeder;

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
        $c->commentable_id = 1;
        $c->commentable_type = "App\Models\UserProfile";
        $c->save();

        $comments = Comment::factory()->count(10)->create();
    }
}
