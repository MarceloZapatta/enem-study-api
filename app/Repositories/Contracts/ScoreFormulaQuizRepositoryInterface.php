<?php

namespace App\Repositories\Contracts;

use App\Models\ScoreFormulaQuiz;
use Illuminate\Support\Collection;

interface ScoreFormulaQuizRepositoryInterface
{
    public function create(array $data): ScoreFormulaQuiz;

    /**
     * @return Collection<int, object{formula_id: string, total: int, correct: int}>
     */
    public function statsByFormula(): Collection;
}
