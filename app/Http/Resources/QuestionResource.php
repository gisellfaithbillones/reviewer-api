<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'reviewerId' => $this->reviewer_id,
            'reviewer' => new ReviewerResource($this->whenLoaded('reviewer')),
            'content' => $this->content,
            'choices' => ChoiceResource::collection($this->whenLoaded('choices')),
            'answer' => new AnswerResource($this->whenLoaded('answer'))
        ];
    }

}
