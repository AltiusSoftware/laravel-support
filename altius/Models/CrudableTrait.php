<?php

namespace Altius\Models;


use Altius\Services\Fields\HasFieldsTrait;


trait CrudableTrait {
    use HasFieldsTrait;
    use SearchableTrait;
    use LanguageTrait;
    use RoutableTrait;

    public function scopeSecure($q){}

    public function scopeAutoSort($q) {
        $q->orderBy('id');

    }

}