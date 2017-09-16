<?php
class ajaxModel extends baseModel{

     protected $table = 'admin';

    public function queryTable($tableName){

        return $this->query(" select * from $tableName limit 1 ");


    }

}