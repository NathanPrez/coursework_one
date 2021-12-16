<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserProfile;
use App\Models\Post;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->text,
            'commentable_id' => UserProfile::all()->random()->id,
            'commentable_type' => "App\Models\UserProfile",
            'post_id' => Post::all()->random()->id,
        ];
    }
}
