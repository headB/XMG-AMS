<?php
class consumablesIssueModel extends baseModel{

    protected $table = 'consumables_issue';

    public function queryDetail($sqlString=''){

        $sql = "select a.*,b.id as sid ,c.locationName,c.id as locationId,d.typename,d.id as typeId from ((yx_consumables_issue a left join yx_consumables b on a.assetId=b.id) left join yx_location c on b.location=c.id) left join yx_asset_type d on b.subType=d.id  ";

        $sql.= $sqlString;

        $info = $this->model->query($sql);

        return $info;

    }

}