<?php

namespace App\Data;

class AnswerFilterData extends BaseData
{

    public function __construct(
        public ?int $questionId = null,
        public ?string $content = null,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
