<?php

namespace App\Models;

use App\Constants\DatabaseTableConstant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $reviewerId
 * @property string $title
 * @property string $content
 *
 * Model relationships
 * @property Reviewer|null $reviewer
 */
class Note extends BaseModel
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = DatabaseTableConstant::NOTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The reviewer where this note belongs.
     *
     * @return BelongsTo
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Reviewer::class);
    }

}
