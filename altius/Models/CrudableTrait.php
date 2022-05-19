<?php

namespace Altius\Models;


use Altius\Services\Fields\HasFieldsTrait;


trait CrudableTrait {
    use HasFieldsTrait;
    use SearchableTrait;
    use LanguageTrait;
    use RoutableTrait;


}