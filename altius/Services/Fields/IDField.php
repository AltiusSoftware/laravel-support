<?php

namespace Altius\Services\Fields;

class IDField extends Field {

        // required/
        // readonly etc.

        public function getLabel(){
                return 'ID';
        }
        public function __construct($name,$type,$fields){


            parent::__construct($name,$type,$fields);
            // $this->readOnly();

        }

}