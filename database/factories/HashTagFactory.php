<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\HashTag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HashTag>
 */
class HashTagFactory extends Factory
{
    protected $model = HashTag::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {


        // Generate a unique hash tag name
        $hashTag = $this->faker->unique()->word;

        // Ensure that the hash tag does not already exist
        while (Hashtag::where('name', $hashTag)->exists()) {
            $hashTag = $this->faker->unique()->word;
        }

        return [
            'name' => $hashTag,
            // Add other attributes as needed
        ];
 

    }
}