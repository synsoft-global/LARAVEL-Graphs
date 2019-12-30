<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class userCapability extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'capability'
    ];

}
