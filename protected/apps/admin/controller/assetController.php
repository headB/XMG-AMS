<?php
class assetController extends commonController{

    public function __construct()
    {
        parent::__construct();
        $this->map = $this->getmap();
        $this->__set('map',$this->map);

    }

    public function index(){



        $req['returnUrl'] = $t = in($_GET['returnUrl']);
        if(empty($t)){$req['returnUrl'] = "admin/asset/index";}

        $startTime = date("Y-m-d",time()-(60*60*24*30*6));
        $today = date("Y-m-d",time());

        //下面这些都是默认值，默认值分两种，一种是文本，一个是默认的选项。
        $req['startTime'] = $this->istget('startTime');
        $req['endTime'] = $this->istget('endTime');
        $whereLike['assetname'] = $req['assetName'] =$this->istget('assetName');
        $whereLike['aid'] = $req['aid'] =$this->istget('aid');
        $where['usestate'] = $req['usestate'] = $this->istget('usestate');

        $where['a.department'] = $req['department'] = $this->istget('department');
        $where['a.user'] = $req['user'] = $this->istget('user');
        $req['location'] = $this->istget('location');
        $req['subLocation'] = $this->istget('subLocation');

        $req['assetType'] = $this->istget('type');
        $req['subType'] = $this->istget('subType');

        $req['startTime'] =!empty($req['startTime'])?$req['startTime']:$startTime;
        $req['endTime'] =!empty($req['endTime'])?$req['endTime']:$today;

        $req['campus'] = $this->istget('campus');

        if(!empty($req['campus'])){
            $where['a.campus'] = $req['campus'];
        }


        $whereIn['location'] = (!empty($req['subLocation']))?" and  a.location='".$req['subLocation']."' ":" and ( a.location='".$req['location']."' or e.tid='".$req['location']."')";
        if(empty($req['location'])){unset($whereIn['location']);}


        $whereIn['type'] = (!empty($req['subType']))?" and  a.type='".$req['subType']."' ":" and ( a.type='".$req['assetType']."' or d.tid='".$req['assetType']."')";
        if(empty($req['assetType'])){unset($whereIn['type']);}


        $sql = 'where ';

        if(empty($req['startTime'])){$req['startTime'] = date('Y-m-d',time()-(60*60*24*30*2));}
        if(empty($req['endTime'])){$req['endTime'] = date('Y-m-d',time());}

        if(!empty($req['startTime']) and !empty($req['endTime'])){
            $sql .= "  `buyDate` between '".$req['startTime']."' AND '".$req['endTime']."' ";
        }



        $sql1 = model('admin')->conditionLike($whereLike);
        if(!empty($sql1)){$sql.=" and $sql1 ";}

        $sql2 = model('admin')->conditionToSqlWhere($where);
        $sql .= $whereIn['type'];
        $sql .= $whereIn['location'];
        if(!empty($sql2)){$sql.=" and $sql2 ";}

        //下面这些是模板需要赋值的变量

        $contentArray = '';

        $this->assign('req',$req);

        $contentArray['department'] = optionValues(model('department')->select(),'dpname','--请选择--');
        $contentArray['campus'] = optionValues(model('campus')->select(),'name','--请选择--');
        /*$contentArray['location'] = optionValues(model('location')->select("tid='0'"),'locationName','--请选择--');*/
        $contentArray['assetType'] = optionValues(model('assetType')->select("tid='1'"),'typename','--请选择--');
        $contentArray['usestate'] = optionValues(model('assetType')->select("tid='23'"),'typename','--请选择--');

        if(!empty($req['user']) or !empty($req['department'])){ $contentArray['user'] = optionValues(model('user')->select("department = ".$req['department']),'name','--请选择--'); }

        if(!empty($req['subLocation']) or !empty($req['location'])){ $contentArray['subLocation'] = optionValues(model('location')->select("tid = ".$req['location']),'locationName','--请选择--'); }

        if(!empty($req['subType']) or !empty($req['assetType'])){ $contentArray['subType'] = optionValues(model('assetType')->select("tid = ".$req['assetType']),'typename','--请选择--');}

        if(!empty($req['location']) or !empty($req['campus'])){ $contentArray['location'] = optionValues(model('location')->select("cid = ".$req['campus']." and tid ='0'"),'locationName','--请选择--');}

        $this->assign('contentArray',$contentArray);


        $limitPage = 40;
        $limit = $this->pageLimit('',$limitPage);

        $limit = " limit $limit ";

        $searchInfo = model('assets')->assetsQuery($sql,$limit);


        $countNum = model('assets')->assetsQuery($sql,'','yes');

        $daochu = in($_GET['daochu']);
        if($daochu=='yes'){
            $searchInfo = model('assets')->assetsQuery($sql);

            $excel = $this->onlyForExcel($searchInfo);
            $time = date('Y-m-d_His');
            $this->exportExcel("xmgAsset_".$time,$excel,10);
            exit;
        }

        $this->page = $this->pageShow($countNum);
        $this->countNum = $countNum;

        $this->assign('searchInfo',$searchInfo);


        $this->display();


    }

    public function edit(){

        if($this->ispost()){


            $returnUrl = base64_decode(in($_POST['returnUrl']));
            $url = $_SERVER['SCRIPT_NAME']."?".$returnUrl;

            $in['id'] = in($_POST['id']);
            if(empty($in)){
                $this->error("未知错误！！",$url);
            }


            $where['type']  =  in($_POST['assetType']);
            $t =  in($_POST['subType']);

            if(!empty($t)){$where['type'] = $t ;}

            $where['location']  =  in($_POST['location']);
            $t =  in($_POST['subLocation']);

            if(!empty($t)){$where['location'] = $t ;}


            $where['campus'] = in($_POST['campus']);
            $where['assetname'] = in($_POST['aname']);
            $where['version'] = in($_POST['modern']);
            $where['buyDate'] = in($_POST['buyDate']);
            $where['manufacturer'] = in($_POST['manufacturer']);
            $where['price'] = in($_POST['avalue']);
            $where['usestate'] = in($_POST['usestate']);
            $where['department'] = in($_POST['department']);
            $where['user'] = in($_POST['user']);
            $where['remark'] = in($_POST['remark']);
            $where['total'] = in($_POST['total']);
            $where['measure'] = in($_POST['measure']);






            foreach($where as $key=>$value){

                if(empty($value)){unset($where[$key]);}

            }

            $info = model('assets')->update($in,$where);

            if($info){
                    $this->success("修改成功！！",$url);
            }else{
                $this->error("修改失败！！或者数据没有被改变",$url);
            }


            exit;

        }

        $id = in($_GET['id']);
        if(empty($id)){$this->error("请选择一个固定资产记录再进行修改操作",url('asset/index'));}

        $whereId = " where a.id='$id'";
        $idValues = model('assets')->assetsQueryDetail($whereId);

        $req = $idValues[0];



        $contentArray['department'] = optionValues(model('department')->select(),'dpname','--请选择--');
        $contentArray['location'] = optionValues(model('location')->select("tid='0'"),'locationName','--请选择--');
        $contentArray['campus'] = optionValues(model('campus')->select(),'name','--请选择--');
        $contentArray['assetType'] = optionValues(model('assetType')->select("tid='1'"),'typename','--请选择--');
        $contentArray['usestate'] = optionValues(model('assetType')->select("tid='23'"),'typename','--请选择--');
        $contentArray['measure'] = optionValues(model('assetType')->select("tid='14'"),'typename','--请选择--');

        if(!empty($req['locationId'])){
            $t = $req['locationId'];
            if($res = $this->getParentInfo('location',$req['locationId']," and tid!='0' ")){

                $req['subLocation'] = $req['locationId'];
                $req['locationId'] = $t = $res;
                $contentArray['subLocation'] = optionValues(model('location')->select("tid='$t'"),'locationName','--请选择--');

            }else{
                $contentArray['subLocation'] = optionValues(model('location')->select("tid='$t'"),'locationName','--请选择--');
            }

        }

        if(!empty($req['typeId'])){
            $t = $req['typeId'];
            if($res = $this->getParentInfo('assetType',$req['typeId']," and (tid!='1' and tid!='0') ")){

                $req['subType'] = $req['typeId'];
                $req['typeId'] = $t = $res;
                $contentArray['subType'] = optionValues(model('assetType')->select("tid='$t'"),'typename','--请选择--');

            }else{
                $contentArray['subType'] = optionValues(model('assetType')->select("tid='$t'"),'typename','--请选择--');
            }

        }

        unset($t1);
        unset($t2);
        $t1 = $req['dpId'];
        $t2 = $req['userId'];


        if(!empty($t1) and !empty($t2)){

            $contentArray['user'] = optionValues(model('user')->select(" department='$t' "),'name','--请选择--');

        }

        $this->assign('contentArray',$contentArray);
        $this->assign('req',$req);
        $this->assign('action',url('asset/edit'));
        $this->assign('submit',"点击提交修改");

        $this->display();

    }

    public function add(){

        if($this->ispost()){

            $url = url('asset/add');

            $where['aid'] = in($_POST['aid']);
            $where['campus'] = in($_POST['campus']);
            $where['assetname'] = in($_POST['aname']);
            $where['version'] = in($_POST['modern']);
            $where['buyDate'] = in($_POST['buyDate']);
            $where['price'] = in($_POST['avalue']);
            $where['usestate'] = in($_POST['usestate']);
            $where['department'] = in($_POST['department']);
            $where['user'] = in($_POST['user']);
            $where['remark'] = in($_POST['remark']);
            $where['manufacturer'] = in($_POST['manufacturer']);
            $where['total'] = in($_POST['total']);
            $where['measure'] = in($_POST['measure']);


            $where['type']  =  in($_POST['assetType']);
            $t =  in($_POST['subType']);

            if(!empty($t)){$where['type'] = $t ;}

            $where['location']  =  in($_POST['location']);
            $t =  in($_POST['subLocation']);

            if(!empty($t)){$where['location'] = $t ;}

            $info = model('assets')->insert($where);

            if($info){
                $this->success("数据添加成功！！",$url);
            }else{

                $this->error("数据添加成功！！",$url);
            }

        }

        $contentArray['department'] = optionValues(model('department')->select(),'dpname','--请选择--');
        /*$contentArray['location'] = optionValues(model('location')->select("tid='0'"),'locationName','--请选择--');*/
        $contentArray['assetType'] = optionValues(model('assetType')->select("tid='1'"),'typename','--请选择--');
        $contentArray['usestate'] = optionValues(model('assetType')->select("tid='23'"),'typename','--请选择--');
        $contentArray['campus'] = optionValues(model('campus')->select(),'name','--请选择--');
        $contentArray['measure'] = optionValues(model('assetType')->select("tid='14'"),'typename','--请选择--');

        unset($t1);
        unset($t2);
        $t1=$req['location'];
        $t2=$req['campus'];
        if(!empty($t1) or !empty($t2)){ $contentArray['location'] = optionValues(model('location')->select("cid = ".$req['campus']." and tid ='0'"),'locationName','--请选择--');}

        $this->assign('contentArray',$contentArray);
        $this->assign('submit',"点击添加");
        $this->display('asset_edit');

    }

    public function exportExcel($savename='',$contentArray,$fieldNumber){

        $date = date("Y-m-j");
        $savename = !empty($savename)?$savename:$date."asset";


        $file_type = "vnd.ms-excel";
        $file_ending = "xls";

        header("Content-Type: application/$file_type;charset=utf8");
        header("Content-Disposition: attachment; filename=".$savename.".$file_ending");
        //header("Pragma: no-cache");

        $now_date = date("Y-m-j H:i:s");
        echo  "你导出的当前数据是截止于$now_date\n\n";

        $list = $contentArray['contentArray'];

        $sep = "\t";



        foreach($contentArray['title'] as $value){
            echo $value."\t";
        }

        print("\n");




        foreach ($list as $v)

        {
            $schema_insert = "";
            for($j=0; $j< $fieldNumber;$j++) {

                if(!isset($v[$j]))
                    $schema_insert .= "NULL".$sep;
                else if ($v[$j] != "")
                    $schema_insert .= "$v[$j]".$sep;
                else
                    $schema_insert .= "".$sep;
            }

            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
            $i++;


        }

        return (true);

    }

    public function onlyForExcel($searchInfo){
        if(isset($searchInfo) and is_array($searchInfo)){


            $title[] = '序号';
            $title[] = '名称';
            $title[] = '编号';
            $title[] = '类型';
            $title[] = '备注';
            $title[] = '使用人';
            $title[] = '所在部门';
            $title[] = '办公地点';
            $title[] = '入库时间';
            $title[] = '价格';


            $content='';
            $contentArray='';

            $i=1;

            foreach($searchInfo as $content1){

                $content[]=$i;
                $content[]=$content1['assetname'];
                $content[]=$content1['aid'];
                $content[]=$content1['typename'];
                $content[]=$content1['remark'];
                $content[]=$content1['user'];
                $content[]=$content1['department'];
                $content[]=$content1['locationName'];
                $content[]=$content1['buyDate'];
                $content[]=$content1['prcie'];

                $contentArray[] = $content;
                $content='';
                $i++;

            }

            $excelContent['title'] = $title;
            $excelContent['contentArray'] = $contentArray;

            return $excelContent;
        }
    }



}