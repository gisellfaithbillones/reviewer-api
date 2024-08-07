<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Reviewer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
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
            'content' => 'What is ' . fake()->sentence() . '?',
            'attachments' => null,
            'hint' => null,
            'answer_explanation' => null
        ];
    }

}
