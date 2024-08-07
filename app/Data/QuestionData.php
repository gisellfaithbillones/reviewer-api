<?php

namespace App\Data;

class QuestionData extends BaseData
{

    public function __construct(
        public int $reviewerId,
        public string $content,
        public ?array $attachments = null,
        public ?string $hint = null,
        public ?string $answerExplanation = null,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
