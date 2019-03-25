<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /** @var array */
    protected $fillable = [
        'name'
    ];

    public function profileActivities()
    {
        return $this->hasMany(ProfileActivity::class);
    }

    public function profileProgresses()
    {
        return $this->hasMany(ProfileProgress::class);
    }
}
