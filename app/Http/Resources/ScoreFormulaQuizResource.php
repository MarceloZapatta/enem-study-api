<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreFormulaQuizResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'formula_id' => $this->formula_id,
            'type' => $this->type,
            'correct' => $this->correct,
            'created_at' => $this->created_at,
        ];
    }
}
