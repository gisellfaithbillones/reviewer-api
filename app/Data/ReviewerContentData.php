<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;

class ReviewerContentData extends BaseData
{

    public function __construct(
        public int $reviewerId,
        #[DataCollectionOf(ReviewerContentItemData::class)]
        public array $items,
        ...$args
    )
    {
        parent::__construct(...$args);
    }

}
