<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /** @var array */
    protected $fillable = [
        'name'
    ];

    public function profileActivity()
    {
        return $this->hasMany(ProfileActivity::class);
    }
}
