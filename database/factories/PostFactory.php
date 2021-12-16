<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserProfile;

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
            'type' => $this->faker->randomElement(['meet','chat']), 
            'body' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            'postable_id' => UserProfile::all()->random()->id,
            'postable_type' => 'App\Models\UserProfile',
        ];
    }
}
