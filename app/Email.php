<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crawled_emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url_id', 'email',
    ];


}
