<?php
class nonconsumablesController extends commonController{

    public  $map = null;

    public function __construct()
    {
        parent::__construct();
        $this->map = $this->getmap();
        $this->__set('map',$this->map);

    }

    public function index(){

    $req['returnUrl'] = $t = in($_GET['returnUrl']);
    if(empty($t)){$req['returnUrl'] = "admin/nonConsumables/index";}

    $req['startTime'] = $this->istget('startTime');
    $req['endTime'] = $this->istget('endTime');
    $where['department'] = $req['department'] = $this->istget('department');
    $where['user'] = $req['user'] = $this->istget('user');
    $where['subType'] = $req['subType'] = $this->istget('subType');
    $whereLike['assetName'] = $req['assetName'] = $this->istget('assetName');
    $req['location'] = $this->istget('location');
    $req['subLocation'] = $this->istget('subLocation');



    if(empty($req['startTime'])){$req['startTime'] = date('Y-m-d',time()-(60*60*24*30*2));}
    if(empty($req['endTime'])){$req['endTime'] = date('Y-m-d',time());}

    $contentArray['department'] = optionValues(model('department')->select(),'dpname','--请选择--');
    $contentArray['location'] = optionValues(model('location')->select("tid='0'"),'locationName','--请选择--');
    $contentArray['subType'] = optionValues(model('assetType')->select("tid='28'"),'typename','--请选择--');

    if(!empty($req['location'])){
        $t = $req['location'];
        if($res = $this->getParentInfo('location',$req['location']," and tid!='0' ")){

            $req['subLocation'] = $req['location'];
            $req['location'] = $t = $res;
            $contentArray['subLocation'] = optionValues(model('location')->select("tid='$t'"),'locationName','--请选择--');

        }else{
            $contentArray['subLocation'] = optionValues(model('location')->select("tid='$t'"),'locationName','--请选择--');
        }

    }


    if(!empty($req['user']) or !empty($req['department'])){ $contentArray['user'] = optionValues(model('user')->select("department = ".$req['department']),'name','--请选择--'); }


    $whereIn['location'] = (!empty($req['subLocation']))?" and  a.location='".$req['subLocation']."' ":" and ( a.location='".$req['location']."' or d.tid='".$req['location']."')";
    if(empty($req['location'])){unset($whereIn['location']);}




    if(empty($req['startTime'])){$req['startTime'] = date('Y-m-d',time()-(60*60*24*30*2));}
    if(empty($req['endTime'])){$req['endTime'] = date('Y-m-d',time());}

    $sql = " where ";

    if(!empty($req['startTime']) and !empty($req['endTime'])){
        $sql .= "  `addTime` between '".$req['startTime']."' AND '".$req['endTime']."' ";
    }

    $sql1 = model('admin')->conditionLike($whereLike);
    if(!empty($sql1)){$sql.=" and $sql1 ";}

    $sql2 = model('admin')->conditionToSqlWhere($where);
    $sql .= $whereIn['subLocation'];
    $sql .= $whereIn['location'];
    if(!empty($sql2)){$sql.=" and $sql2 ";}



    $searchInfo = model('nonConsumables')->queryDetail($sql);


    $this->assign('searchInfo',$searchInfo);
    $this->assign('contentArray',$contentArray);
    $this->assign('req',$req);

    $this->display('consumables_index');

}

    public function issueIndex(){


        $req['returnUrl'] = $t = in($_GET['returnUrl']);
        if(empty($t)){$req['returnUrl'] = "admin/nonConsumables/issueIndex";}

        $req['startTime'] = $this->istget('startTime');
        $req['endTime'] = $this->istget('endTime');
        $where['department'] = $req['department'] = $this->istget('department');
        $where['user'] = $req['user'] = $this->istget('user');
        $where['subType'] = $req['subType'] = $this->istget('subType');
        $whereLike['assetName'] = $req['assetName'] = $this->istget('assetName');
        $req['location'] = $this->istget('location');
        $req['subLocation'] = $this->istget('subLocation');



        if(empty($req['startTime'])){$req['startTime'] = date('Y-m-d',time()-(60*60*24*30*2));}
        if(empty($req['endTime'])){$req['endTime'] = date('Y-m-d',time());}

        $contentArray['department'] = optionValues(model('department')->select(),'dpname','--请选择--');
        $contentArray['location'] = optionValues(model('location')->select("tid='0'"),'locationName','--请选择--');
        $contentArray['subType'] = optionValues(model('assetType')->select("tid='28'"),'typename','--请选择--');

        if(!empty($req['location'])){
            $t = $req['location'];
            if($res = $this->getParentInfo('location',$req['location']," and tid!='0' ")){

                $req['subLocation'] = $req['location'];
                $req['location'] = $t = $res;
                $contentArray['subLocation'] = optionValues(model('location')->select("tid='$t'"),'locationName','--请选择--');

            }else{
                $contentArray['subLocation'] = optionValues(model('location')->select("tid='$t'"),'locationName','--请选择--');
            }

        }


        if(!empty($req['user']) or !empty($req['department'])){ $contentArray['user'] = optionValues(model('user')->select("department = ".$req['department']),'name','--请选择--'); }


        $whereIn['location'] = (!empty($req['subLocation']))?" and  a.location='".$req['subLocation']."' ":" and ( a.location='".$req['location']."' or d.tid='".$req['location']."')";
        if(empty($req['location'])){unset($whereIn['location']);}




        if(empty($req['startTime'])){$req['startTime'] = date('Y-m-d',time()-(60*60*24*30*2));}
        if(empty($req['endTime'])){$req['endTime'] = date('Y-m-d',time());}

        $sql = " where ";

        if(!empty($req['startTime']) and !empty($req['endTime'])){
            $sql .= "  `issueTime` between '".$req['startTime']."' AND '".$req['endTime']."' ";
        }

        $sql1 = model('admin')->conditionLike($whereLike);
        if(!empty($sql1)){$sql.=" and $sql1 ";}

        $sql2 = model('admin')->conditionToSqlWhere($where);
        $sql .= $whereIn['subLocation'];
        $sql .= $whereIn['location'];
        if(!empty($sql2)){$sql.=" and $sql2 ";}



        $searchInfo = model('nonConsumablesIssue')->queryDetail($sql);


        $this->assign('searchInfo',$searchInfo);
        $this->assign('contentArray',$contentArray);
        $this->assign('req',$req);

        $this->display('consumables_issueIndex');

    }


    public function add(){

        if($this->ispost()){


             $data['addTime'] = in($_POST['addTime']);
             $data['providers'] = in($_POST['providers']);
             $data['buyer'] = in($_POST['buyer']);
             $data['location'] = in($_POST['location']);
             $data['handler'] = in($_POST['handler']);
             $data['subType'] = in($_POST['subType']);
             $data['assetName'] = in($_POST['assetName']);
             $data['specification'] = in($_POST['specification']);
             $data['price'] = in($_POST['price']);
             $data['addTotal'] = in($_POST['addTotal']);
             $data['actualTotal'] = in($_POST['actualTotal']);
             $data['measure'] = in($_POST['measure']);
             $data['totalPrice'] = in($_POST['totalPrice']);
             $data['remark'] = in($_POST['remark']);


            $t =  in($_POST['subLocation']);
            if(!empty($t)){$data['location'] = $t ;}

            $info = model('nonConsumables')->insert($data);

            if($info){
                $this->success("数据添加成功！",url('nonConsumables/add'));
            }else{
                $this->error("数据添加失败！",url('nonConsumables/add'));
            }


        }

        $req['action'] = 'add';

        $contentArray['buyer'] = optionValues(model('user')->select(" department='18' "),'name','--请选择--');
        $contentArray['handler'] = optionValues(model('user')->select(" department='18' "),'name','--请选择--');
        $contentArray['location'] = optionValues(model('location')->select("tid='0'"),'locationName','--请选择--');
        $contentArray['subType'] = optionValues(model('assetType')->select("tid='28'"),'typename','--请选择--');
        $contentArray['measure'] = optionValues(model('assetType')->select("tid='14'"),'typename','--请选择--');

        if(!empty($req['location'])){
            $t = $req['location'];
            if($res = $this->getParentInfo('location',$req['location']," and tid!='0' ")){

                $req['subLocation'] = $req['location'];
                $req['location'] = $t = $res;
                $contentArray['subLocation'] = optionValues(model('location')->select("tid='$t'"),'locationName','--请选择--');

            }else{
                $contentArray['subLocation'] = optionValues(model('location')->select("tid='$t'"),'locationName','--请选择--');
            }

        }

        $req['returnUrl'] = url('nonConsumables/add');

        $req['addTime'] = !empty($req['addTime'])?$req['addTime']:date('Y-m-d',time());

        $this->assign('req',$req);
        $this->assign('contentArray',$contentArray);
        $this->assign('submit','点击添加');
        $this->display('consumables_add');

    }

    public function edit(){


        $returnUrl = base64_decode(in($_POST['returnUrl']));
        $url = $_SERVER['SCRIPT_NAME']."?".$returnUrl;

    if($this->ispost()){


        $id = $in['id'] = in($_POST['id']);
        if(empty($id)){
            $this->error("未知错误！！",$url);
        }

    $data['providers'] = in($_POST['providers']);
    $data['buyer'] = in($_POST['buyer']);
    $data['location'] = in($_POST['location']);
    $data['handler'] = in($_POST['handler']);
    $data['subType'] = in($_POST['subType']);
    $t = in($_POST['subLocation']);
    $data['specification'] = in($_POST['specification']);
    $data['price'] = in($_POST['price']);
    $data['addTotal'] = in($_POST['addTotal']);
    $data['actualTotal'] = in($_POST['actualTotal']);
    $data['measure'] = in($_POST['measure']);
    $data['totalPrice'] = in($_POST['totalPrice']);
    $data['remark'] = in($_POST['remark']);

        $data['location'] = (!empty($t))?$t:$data['location'];

        foreach($data as $key=>$value){

            if(empty($value)){unset($data[$key]);}

        }


        $info = model('nonConsumables')->update($in,$data);

        if($info){
            $this->success("修改成功！！",$url);
        }else{
            $this->error("修改失败！！或者数据没有被改变",$url);
        }






        exit;
    }

        $id = in($_GET['id']);

        $searchInfo = model('nonConsumables')->queryDetail(" where  a.id='$id'");
        $req = $searchInfo[0];





        $contentArray['buyer'] = optionValues(model('user')->select(" department='18' "),'name','--请选择--');
        $contentArray['handler'] = optionValues(model('user')->select(" department='18' "),'name','--请选择--');
        $contentArray['department'] = optionValues(model('department')->select(),'dpname','--请选择--');
        $contentArray['location'] = optionValues(model('location')->select("tid='0'"),'locationName','--请选择--');
        $contentArray['subType'] = optionValues(model('assetType')->select("tid='28'"),'typename','--请选择--');
        $contentArray['measure'] = optionValues(model('assetType')->select("tid='14'"),'typename','--请选择--');


        if(!empty($req['locationId'])){
            $t = $req['locationId'];
            if($res = $this->getParentInfo('location',$req['locationId']," and tid!='0' ")){

                $req['subLocation'] = $req['locationId'];
                $req['location'] = $t = $res;
                $contentArray['subLocation'] = optionValues(model('location')->select("tid='$t'"),'locationName','--请选择--');

            }else{
                $contentArray['subLocation'] = optionValues(model('location')->select("tid='$t'"),'locationName','--请选择--');
                $req['location'] = $req['locationId'];
            }

        }

        $req['measure'] = $req['measureId'];
        $req['subType'] = $req['subTypeId'];

        $this->assign('submit','点击修改');
        $this->assign('contentArray',$contentArray);
        $this->assign('req',$req);
        $this->display('consumables_add');


    }

    public function issue(){


        $returnUrl = base64_decode(in($_GET['returnUrl']));
        if(empty($returnUrl)){$returnUrl = "r=admin/nonConsumables/index";}
        $url = $_SERVER['SCRIPT_NAME'] . "?" . $returnUrl;

        if($this->ispost()) {



            $in['id'] = in($_POST['id']);

            if (empty($in['id'])) {
                $this->error("未知错误！！", $url);
            }


            $in['id'] = $data['assetId'] = in($_POST['id']);
            $data['assetName'] = in($_POST['assetName']);
            $data['issueTime'] = in($_POST['issueTime']);
            $data['remark'] = in($_POST['remark']);
            $data['total'] = in($_POST['total']);
            $data['measure'] = in($_POST['measure']);
            $data['price'] = in($_POST['price']);

            $data1['department'] = model('department')->find(" id='".in($_POST['department'])."'");
            $data1['user'] = model('user')->find(" id='".in($_POST['user'])."'");
            $data1['handler'] = model('user')->find(" id='".in($_POST['user'])."'");

            $data['department'] = $data1['department']['dpname'];
            $data['user'] = $data1['user']['name'];
            $data['handler'] = $data1['handler']['name'];

            $actualNumber = model('nonConsumables')->find($in);

            if((int)$data['total'] > (int)$actualNumber['actualTotal']){echo "库存不足";}

           $sofarToal = (int)$actualNumber['actualTotal'] - (int)$data['total'];

            $update['actualTotal'] = $sofarToal;
            $update1['actualTotal'] = $actualNumber;

            $info = model('nonConsumables')->update($in,$update);

            if($info){

                $info1 =  model('nonConsumablesIssue')->insert($data);
                if($info1){
                    $this->success("领用登记成功！",$url);
                }else{
                    $infoR = model('nonConsumables')->update($in,$update1);
                    $this->error("领用失败，未知原因，请联系网管",$url);
                }

            }else{
                $this->error("领用失败，未知原因，请联系网管",$url);
            }


        }


            $in['id'] = $t =  in($_GET['id']);

            if (empty($in['id'])) {
                $this->error("请选择一个易耗品来操作！！", $url);
            }


        $infoArray = model('nonConsumables')->queryDetail(" where a.id='$t' ");
        $req = $infoArray[0];

        $contentArray['buyer'] = optionValues(model('user')->select(" department='18' "),'name','--请选择--');
        $contentArray['handler'] = optionValues(model('user')->select(" department='18' "),'name','--请选择--');
        $contentArray['department'] = optionValues(model('department')->select(),'dpname','--请选择--');
        $contentArray['location'] = optionValues(model('location')->select("tid='0'"),'locationName','--请选择--');
        $contentArray['subType'] = optionValues(model('assetType')->select("tid='28'"),'typename','--请选择--');
        $contentArray['measure'] = optionValues(model('assetType')->select("tid='14'"),'typename','--请选择--');

        $contentArray['issueTime'] = date('Y-m-d',time());

        $this->assign('contentArray',$contentArray);
        $this->assign('req',$req);

        $this->display('consumables_issue');

    }


}