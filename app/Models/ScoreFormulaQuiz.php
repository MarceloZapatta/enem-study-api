<?php

namespace App\Models;

use App\Enums\QuizType;
use Database\Factories\ScoreFormulaQuizFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreFormulaQuiz extends Model
{
    /** @use HasFactory<ScoreFormulaQuizFactory> */
    use HasFactory;

    protected $table = 'scores_formula_quiz';

    protected $fillable = [
        'formula_id',
        'type',
        'correct',
    ];

    protected function casts(): array
    {
        return [
            'type' => QuizType::class,
            'correct' => 'boolean',
        ];
    }
}
