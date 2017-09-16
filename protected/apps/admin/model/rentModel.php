<?php
class rentModel extends baseModel{

    protected $table = 'rentlist';


   public function rent_store(){

       $sql = "select a.computerId as cid,b.* from yx_computerid a left join (select * from yx_rentlist where returnRecord is null) b on a.computerid=b.computerid";
       return $this->model->query($sql);

   }

    public function rent_used_num(){

        return $this->count(" where returnRecord is null");

    }





}