<?php
class assetsModel extends baseModel{

    protected $table = 'assets';

    public function assetsQuery($sqls,$limit='',$count=''){

        $sql = "
        select a.assetname,a.department as departmentId,a.id,a.campus,a.aid,a.remark,a.buyDate,a.price,a.usestate,b.name as user,b.id as userId ,c.dpname as department ,c.id as dpId,d.typename,d.id as typeId,e.locationName,e.id as locationId from (((yx_assets a left join yx_user b on a.user=b.id ) left join yx_department c on a.department=c.id ) left join yx_asset_type d on a.type=d.id ) left join yx_location e on a.location=e.id

        ";

        $sql.=" $sqls";
        $sql.=" order by id DESC";
        $sql.=" $limit ";


            $result = $this->model->query($sql);
        if(!empty($count)){
            return count($result);
        }else{
            return $result;
        }




    }



    public function assetsQueryDetail($sqls){

        $sql = "
        select a.total,a.campus,a.measure,a.version,a.manufacturer,a.assetname,a.id,a.aid,a.remark,a.buyDate,a.price,a.usestate,b.name as user,b.id as userId ,c.dpname as department ,c.id as dpId,d.typename,d.id as typeId,e.locationName,e.id as locationId from (((yx_assets a left join yx_user b on a.user=b.id ) left join yx_department c on a.department=c.id ) left join yx_asset_type d on a.type=d.id ) left join yx_location e on a.location=e.id

        ";

        $sql.=" $sqls";
        $sql.=" order by id DESC";

        $result = $this->model->query($sql);

        return $result;
    }



}