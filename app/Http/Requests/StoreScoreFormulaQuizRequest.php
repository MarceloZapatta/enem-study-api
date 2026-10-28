<?php

namespace App\Http\Requests;

use App\Enums\QuizType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScoreFormulaQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'formula_id' => ['required', 'uuid'],
            'type' => ['required', Rule::enum(QuizType::class)],
            'correct' => ['required', 'boolean'],
        ];
    }
}
