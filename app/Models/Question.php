<?php

namespace App\Models;

use App\Constants\DatabaseTableConstant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $reviewerId
 * @property string $content
 * @property array|null $attachments
 * @property string|null $hint
 * @property string|null $answer_explanation
 *
 * Model relationships
 * @property Choice[]|Collection $choices
 * @property Answer[]|Collection $answers
 * @property Reviewer|null $reviewer
 */
class Question extends BaseModel
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = DatabaseTableConstant::QUESTIONS;

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
    protected $casts = [
        'attachments' => 'json'
    ];

    /**
     * The choices of this question.
     *
     * @return HasMany
     */
    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }

    /**
     * The answers of this question.
     *
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * The reviewer where this question belongs.
     *
     * @return BelongsTo
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Reviewer::class);
    }

}
