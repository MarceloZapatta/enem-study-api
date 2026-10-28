<?php

namespace App\Services;

use App\Enums\QuizType;
use App\Models\ScoreFormulaQuiz;
use App\Repositories\Contracts\ScoreFormulaQuizRepositoryInterface;
use Illuminate\Support\Collection;

class ScoreFormulaQuizService
{
    public function __construct(
        private readonly ScoreFormulaQuizRepositoryInterface $repository,
    ) {}

    public function record(string $formulaId, QuizType $type, bool $correct): ScoreFormulaQuiz
    {
        return $this->repository->create([
            'formula_id' => $formulaId,
            'type' => $type,
            'correct' => $correct,
        ]);
    }

    /**
     * @return Collection<int, array{formula_id: string, total: int, correct: int, incorrect: int, accuracy: float}>
     */
    public function statsByFormula(): Collection
    {
        return $this->repository->statsByFormula()->map(function (object $row): array {
            $total = (int) $row->total;
            $correct = (int) $row->correct;

            return [
                'formula_id' => $row->formula_id,
                'total' => $total,
                'correct' => $correct,
                'incorrect' => $total - $correct,
                'accuracy' => round($correct / $total * 100, 2),
            ];
        });
    }
}
