<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileActivity extends Model
{
    /** @var array */
    protected $fillable = [
        "likes", "comments", "follows", "unfollows", "server_calls", "logged_at"
    ];
}
