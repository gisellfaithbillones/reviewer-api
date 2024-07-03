<?php

namespace App\Models;

use App\Constants\DatabaseTableConstant;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property ...
 *
 * Model relationships
 * @property ...
 */
class Choice extends BaseModel
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = DatabaseTableConstant::CHOICES;

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

}
