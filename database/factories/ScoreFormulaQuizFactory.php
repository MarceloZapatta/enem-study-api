<?php

namespace Database\Factories;

use App\Enums\QuizType;
use App\Models\ScoreFormulaQuiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScoreFormulaQuiz>
 */
class ScoreFormulaQuizFactory extends Factory
{
    public function definition(): array
    {
        return [
            'formula_id' => fake()->uuid(),
            'type' => fake()->randomElement(QuizType::cases()),
            'correct' => fake()->boolean(),
        ];
    }
}
