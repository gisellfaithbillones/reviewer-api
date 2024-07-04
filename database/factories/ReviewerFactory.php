<?php

namespace Database\Factories;

use App\Constants\ReviewerVisibilityConstant;
use App\Models\Reviewer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reviewer>
 */
class ReviewerFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'name' => fake()->text(),
            'visibility' => ReviewerVisibilityConstant::PRIVATE,
            'description' => fake()->paragraph(),
            'cover_image' => fake()->imageUrl()
        ];
    }

}
