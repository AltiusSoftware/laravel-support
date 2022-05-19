<?php namespace Altius\Services;

trait LanguageTrait {

    public function getLanguagePrefixes() {
        !d('Set Language prefixes in Class');
        return [];
    }

    public function __($key,$replace=[], $local = null){
        $prefixes=$this->getLanguagePrefixes();
        

        foreach($prefixes as $p) {
            $v = $p . '.'.$key;
            if(\Lang::has($v))
                return __($v,$replace,$local);
        }
        return sprintf('[%s].%s',implode(',',$prefixes),$key);
    }

}

	