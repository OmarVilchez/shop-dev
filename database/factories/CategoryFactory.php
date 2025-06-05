<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'name' => $this->faker->word,
           'title' => $this->faker->sentence,
           'description' => $this->faker->paragraph,
           'slug' => $this->faker->unique()->slug,
           'meta_title' => $this->faker->sentence,
           'meta_description' => $this->faker->paragraph,
           'keywords' => $this->faker->words(3, true),
           'position' => $this->faker->numberBetween(1, 100),
        ];
    }
}
