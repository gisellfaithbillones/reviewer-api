<?php

namespace App\Data;

class QuestionData extends BaseData
{

    public function __construct(
        public string $content,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
