<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crawl_links';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id', 'url', 'status',
    ];


}
