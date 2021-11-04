<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
            //Up to four words for a title
            'subforum' => $this->faker->word,
            //Random word to create the subforum
            'type' => $this->faker->randomElement(['Fun','Awareness','Question']), 
            'body' => $this->faker->sentence($nbWords = 10, $variableNbWords = true),
            //Up to ten words for a post
            'user_id' => User::all()->random()->id,
        ];
    }
}
