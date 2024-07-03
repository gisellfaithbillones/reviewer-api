<?php

namespace App\Models;

use App\Constants\DatabaseTableConstant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $content
 *
 * Model relationships
 * @property Choice[]|Collection $choices
 * @property Answer|null $answer
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
    protected $casts = [];

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
     * The answer of this question.
     *
     * @return HasOne
     */
    public function answer(): HasOne
    {
        return $this->hasOne(Answer::class);
    }

}
