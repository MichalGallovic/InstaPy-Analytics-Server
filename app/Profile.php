<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function profileActivity()
    {
        return $this->hasMany(ProfileActivity::class);
    }
}
