<?php

namespace App\Data;

class NoteFilterData extends BaseData
{

    public function __construct(
        public ?int $reviewerId = null,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
