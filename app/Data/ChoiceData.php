<?php

namespace App\Data;

class ChoiceData extends BaseData
{

    public function __construct(
        public int $questionId,
        public string $content,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
