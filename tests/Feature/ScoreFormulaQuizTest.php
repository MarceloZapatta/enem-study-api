<?php

namespace Tests\Feature;

use App\Models\ScoreFormulaQuiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ScoreFormulaQuizTest extends TestCase
{
    use RefreshDatabase;

    public function test_records_a_score(): void
    {
        $formulaId = (string) Str::uuid();

        $this->postJson('/api/scores-formula-quiz', [
            'formula_id' => $formulaId,
            'type' => 'lacunas',
            'correct' => true,
        ])
            ->assertCreated()
            ->assertJsonPath('data.formula_id', $formulaId)
            ->assertJsonPath('data.type', 'lacunas')
            ->assertJsonPath('data.correct', true);

        $this->assertDatabaseHas('scores_formula_quiz', [
            'formula_id' => $formulaId,
            'type' => 'lacunas',
            'correct' => true,
        ]);
    }

    public function test_rejects_invalid_type(): void
    {
        $this->postJson('/api/scores-formula-quiz', [
            'formula_id' => (string) Str::uuid(),
            'type' => 'outro',
            'correct' => true,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('type');
    }

    public function test_requires_type(): void
    {
        $this->postJson('/api/scores-formula-quiz', [
            'formula_id' => (string) Str::uuid(),
            'correct' => true,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('type');
    }

    public function test_rejects_invalid_formula_id(): void
    {
        $this->postJson('/api/scores-formula-quiz', [
            'formula_id' => 'not-a-uuid',
            'correct' => false,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('formula_id');
    }

    public function test_requires_correct(): void
    {
        $this->postJson('/api/scores-formula-quiz', [
            'formula_id' => (string) Str::uuid(),
            'type' => 'montar',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('correct');
    }

    public function test_returns_stats_per_formula(): void
    {
        $a = '11111111-1111-4111-8111-111111111111';
        $b = '22222222-2222-4222-8222-222222222222';

        ScoreFormulaQuiz::factory()->count(3)->create(['formula_id' => $a, 'correct' => true]);
        ScoreFormulaQuiz::factory()->create(['formula_id' => $a, 'correct' => false]);
        ScoreFormulaQuiz::factory()->count(2)->create(['formula_id' => $b, 'correct' => false]);

        $this->getJson('/api/scores-formula-quiz/stats')
            ->assertOk()
            ->assertExactJson(['data' => [
                ['formula_id' => $a, 'total' => 4, 'correct' => 3, 'incorrect' => 1, 'accuracy' => 75],
                ['formula_id' => $b, 'total' => 2, 'correct' => 0, 'incorrect' => 2, 'accuracy' => 0],
            ]]);
    }

    public function test_stats_empty(): void
    {
        $this->getJson('/api/scores-formula-quiz/stats')
            ->assertOk()
            ->assertExactJson(['data' => []]);
    }
}
