<?php

namespace App\Repositories;

use App\Models\ScoreFormulaQuiz;
use App\Repositories\Contracts\ScoreFormulaQuizRepositoryInterface;
use Illuminate\Support\Collection;

class ScoreFormulaQuizRepository implements ScoreFormulaQuizRepositoryInterface
{
    public function create(array $data): ScoreFormulaQuiz
    {
        return ScoreFormulaQuiz::create($data);
    }

    public function statsByFormula(): Collection
    {
        return ScoreFormulaQuiz::query()
            ->select('formula_id')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN correct THEN 1 ELSE 0 END) as correct')
            ->groupBy('formula_id')
            ->orderBy('formula_id')
            ->toBase()
            ->get();
    }
}
