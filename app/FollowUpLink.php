<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowUpLink extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'followup-links';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'url', 'status',
    ];


}
