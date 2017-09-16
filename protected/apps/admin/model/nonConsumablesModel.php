<?php
class nonConsumablesModel extends baseModel{

    protected $table = 'nonconsumables';

    public function queryDetail($sqlString=''){

        $sql = "select a.specification,a.providers,a.remark,a.measure as measureId,a.subType as subTypeId,a.buyer,a.handler,a.location as locationId,a.id,a.addTime,a.assetName,a.addTotal,a.price,a.totalPrice,a.actualTotal,b.typename as subType,c.typename as measure,d.locationName as location from ((yx_nonconsumables a left join yx_asset_type b on a.subType=b.id ) left join yx_asset_type c on a.measure=c.id ) left join yx_location d on a.location=d.id ";


        $sql.= $sqlString;

        $info = $this->model->query($sql);

        return $info;

    }

}