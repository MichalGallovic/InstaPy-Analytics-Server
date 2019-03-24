<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use Authenticatable;

    /** @var array */
    protected $fillable = [
        'name', 'api_token'
    ];
}
