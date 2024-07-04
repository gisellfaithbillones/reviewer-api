<?php

namespace App\Data;

class ReviewerFilterData extends BaseData
{

    public function __construct(
        public ?int $userId = null,
        public ?string $name = null,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
