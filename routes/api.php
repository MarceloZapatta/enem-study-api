<?php

use App\Http\Controllers\ScoreFormulaQuizController;
use Illuminate\Support\Facades\Route;

Route::post('/scores-formula-quiz', [ScoreFormulaQuizController::class, 'store']);
Route::get('/scores-formula-quiz/stats', [ScoreFormulaQuizController::class, 'stats']);
