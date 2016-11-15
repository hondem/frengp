<?php

namespace App\Model;

class BaseModel extends \Nette\Object{
    public $database;
    public function __construct(\Nette\Database\Context $database){
        $this->database = $database;
    }
    
    public function getArrayFromActiveRow($activeRow){
        $array = array();
        foreach($activeRow as $row){
            $array[] = $row->toArray();
        }
        return $array;
    }
}
