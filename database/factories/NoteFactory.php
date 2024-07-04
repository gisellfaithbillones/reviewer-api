<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\Reviewer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Note>
 */
class NoteFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reviewer_id' => Reviewer::factory()->create()->id,
            'title' => fake()->sentence(),
            'content' => fake()->paragraph()
        ];
    }

}
