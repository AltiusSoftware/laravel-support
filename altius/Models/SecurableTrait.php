<?php

namespace Altius\Models;

trait SecurableTrait {
    public function roles() {
        return $this->morphMany('Altius\Models\UserRole', 'securable');
    }
    
}