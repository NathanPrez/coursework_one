<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

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
        $p1->title = "Great Youtube Channel";
        $p1->type = "Fun";
        $p1->subforum = "Gaming";
        $p1->body = "Sub to the amazing Pill Bug Interactive";
        $p1->user_id = 1;
        $p1->save();

        $p2 = new Post;
        $p2->title = "Coursework";
        $p2->type = "Question";
        $p2->subforum = "Coding";
        $p2->body = "Will this coursework get me full marks?";
        $p2->user_id = 2;
        $p2->save();
    }
}
