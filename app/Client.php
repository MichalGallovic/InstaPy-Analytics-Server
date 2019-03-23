<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @var array */
    protected $fillable = [
        'name', 'api_token'
    ];
}
