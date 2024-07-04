<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;

class ReviewerContentItemData extends BaseData
{

    public function __construct(
        public QuestionData $question,
        #[DataCollectionOf(ChoiceData::class)]
        public array $choices,
        #[DataCollectionOf(AnswerData::class)]
        public array $answers,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
