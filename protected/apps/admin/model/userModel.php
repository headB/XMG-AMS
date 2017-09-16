<?php
class userModel extends baseModel{

    protected $table = 'user';

    public function queryUser($whereArray='',$likeSql=''){

    $sql = "select a.*,b.dpname as departmentName from yx_user a left join yx_department b on a.department=b.id ";

        
        $sql .= " where name like '%$likeSql%'";

        if(!empty($whereArray)){$sql.= ' and ';}
        $sql .= $this->conditionToSql($whereArray);



        $res = $this->model->query($sql);


        return $res;

    }

    public function domain_to_ip($url)
    {
        $Furl ='';
        $res = $this->model->query("select * from domain_name where domain='$url'");
        $Furl = $res[0]['ip_address'];
        return $Furl;
    }

}