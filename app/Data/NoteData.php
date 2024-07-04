<?php

namespace App\Data;

class NoteData extends BaseData
{

    public function __construct(
        public int $reviewerId,
        public ?string $title,
        public string $content,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
