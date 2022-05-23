<?php

namespace Altius\Models;

trait SearchableTrait {


    protected function getSearchFields() {
        return ['name'];

    }

    public function scopeAutoSearch($query,$text=null) {
        $text??= request()->get('q');
        if(strlen($text)) {

            $fields=$this->searchJoinTables($query);

            $query->where(function($q) use($text,$fields){
                foreach($fields as $f){
                    $q->orWhere(implode('.',$f),'~*','\m'.$text);
                }
            });
            
            return;
    
            !d($fields);

            !d($this->getSearchFields(),$text);
            exit;
        }


    }
    public function scopeFullTextSearch($query,$text){}
    public function scopeCharacterSearch($query,$text) {}

    public function scopeIncrementalSearch($query,$text)
    {
        
        $fields=$this->searchJoinTables($query);


        $query->where(function($q) use($text,$fields){
            foreach($fields as $f){
               
                $q->orWhere(implode('.',$f),'~*','\m'.$text);
            }
        });
    }
    private function searchJoinTables($query){

        $names = $this->getSearchFields();

        $joins = [];

        $fields=[];
        $query->select($this->getTable() . '.*');
        foreach($names as $n) {
            $ns = explode('.',$n);
            $field = array_pop($ns);
            $relation = array_pop($ns);
            $table = $this->getTable();
                
            if(!is_null($relation) && !in_array($relation,$joins)) {
                    // must be belongs to.
                $rel = $this->$relation();
                
                $table=$rel->getRelated()->getTable();
                $query->join($table,$rel->getQualifiedOwnerKeyName(),'=',$rel->getQualifiedForeignKeyName());

            }
            $fields[] = [ $table,$field];
        }
        return $fields;
    }
}

