<?php

namespace Altius\Models;
use Illuminate\Database\Eloquent\Model;

use App\Model\User;

class UserRole extends Model {

    public function securable()
    {
        return $this->morphTo();
    }
    
    public function user() {

        return $this->belongsTo(User::class);
    }

}