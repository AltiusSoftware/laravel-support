<?php namespace Altius\Models;

trait LanguageTrait{

    use \Altius\Services\LanguageTrait;

    public function getSummaryAttribute() {
        return $this->name;

    }

    public function getShortAttribute() {
        return $this->name;

    }

    public function getSingularAttribute() {
        return $this->__('singular');
    }
    public function getPluralAttribute() {
        return $this->__('plural');
    }


    public function getLanguagePrefixes() {
        return [    
                sprintf('models.%s',$this->getTable()),
                'models.base',
            ];

    }



}
