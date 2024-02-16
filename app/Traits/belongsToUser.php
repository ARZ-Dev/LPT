<?php

namespace App\Traits;

use App\Models\User;

trait belongsToUser {

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
