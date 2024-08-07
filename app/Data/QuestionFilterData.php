<?php

namespace App\Data;

class QuestionFilterData extends BaseData
{

    public function __construct(
        public ?int $reviewerId = null,
        public ?string $content = null,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
