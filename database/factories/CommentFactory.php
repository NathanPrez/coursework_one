<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
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
            //Using up to 10 words for the comment
            //'body' => $this->faker->sentence($nbWords = 10, $variableNbWords = true),
            'body' => $this->faker->text,
            'user_id' => User::all()->random()->id,
            'post_id' => Post::all()->random()->id,
        ];
    }
}
