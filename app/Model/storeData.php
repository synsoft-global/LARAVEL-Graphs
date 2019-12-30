<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class storeData extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option_name','option_value'
    ];
}
