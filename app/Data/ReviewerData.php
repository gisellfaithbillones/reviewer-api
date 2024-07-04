<?php

namespace App\Data;

class ReviewerData extends BaseData
{

    public function __construct(
        public int $userId,
        public string $name,
        public string $visibility,
        public ?string $description = null,
        public ?string $coverImage = null,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
