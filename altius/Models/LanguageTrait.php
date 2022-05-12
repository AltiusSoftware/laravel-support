<?php namespace Altius\Models;

trait LanguageTrait{

    use \Altius\Services\LanguageTrait;

    public function getLanguagePrefixes() {
        return [    
                sprintf('models.%s',$this->getTable()),
                'models.base',
            ];

    }

    public function __($key,$replace=[], $local = null){
        $keys=$this->getLanguageKeys();

        foreach($keys as $k) {
            $v = $k . '.'.$key;
            if(\Lang::has($v))
                return __($v,$replace,$local);
        }
        return sprintf('[%s].%s',implode(',',$keys),$key);
    }

}
