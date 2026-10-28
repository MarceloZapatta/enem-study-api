<?php

namespace App\Http\Controllers;

use App\Enums\QuizType;
use App\Http\Requests\StoreScoreFormulaQuizRequest;
use App\Http\Resources\ScoreFormulaQuizResource;
use App\Services\ScoreFormulaQuizService;
use Illuminate\Http\JsonResponse;

class ScoreFormulaQuizController extends Controller
{
    public function __construct(
        private readonly ScoreFormulaQuizService $service,
    ) {}

    public function store(StoreScoreFormulaQuizRequest $request): JsonResponse
    {
        $score = $this->service->record(
            $request->validated('formula_id'),
            $request->enum('type', QuizType::class),
            $request->boolean('correct'),
        );

        return (new ScoreFormulaQuizResource($score))
            ->response()
            ->setStatusCode(201);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'data' => $this->service->statsByFormula(),
        ]);
    }
}
