<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileProgress extends Model
{
    /** @var array */
    protected $fillable = [
        "followers", "following", "total_posts", "logged_at"
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
