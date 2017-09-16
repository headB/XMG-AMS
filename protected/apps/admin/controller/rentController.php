<?php
class rentController extends commonController {

    public  $map = null;

    public function __construct()
    {
        parent::__construct();
        $this->map = $this->getmap();
        $this->__set('map',$this->map);
        $this->__set('rentValues',self::rentReturnTargetInfo($_POST));
    }

    public function index(){

        $today = date("Y-m-d",time());



        If(isset($_GET['returnUrl']) and !empty($_GET['returnUrl'])){

        $conditionByJson = json_decode(base64_decode($_GET['returnUrl']));

            $req['name'] = $conditionByJson->name;
            $req['computerId'] = $conditionByJson->computerId;
            $req['monitor'] = $conditionByJson->monitor;
            $req['idf'] = $conditionByJson->idf;
            $req['requestType'] = $conditionByJson->requestType;
            $req['rentStartTime'] = $conditionByJson->rentStartTime;
            $req['rentEndTime'] = $conditionByJson->rentEndTime;
            $req['lendStartTime'] = $conditionByJson->lendStartTime;
            $req['lendEndTime'] = $conditionByJson->lendEndTime;


            goto here;
        }



        $req['name'] = $this->istpost('name');
        $req['computerId'] = $this->istpost('computerId');
        $req['monitor'] = $this->istpost('monitor');
        $req['idf'] = $this->istpost('idf');
        $req['requestType'] = $this->istpost('requestType');
        $req['rentStartTime'] = $this->istpost('rentStartTime');
        $req['rentEndTime'] = $this->istpost('rentEndTime');
        $req['lendStartTime'] = $this->istpost('lendStartTime');
        $req['lendEndTime'] = $this->istpost('lendEndTime');

        here:


        if(!empty($req['rentStartTime'])){if(empty($req['rentEndTime'])){$req['rentEndTime']=$today;}}
        if(!empty($req['rentEndTime'])){if(empty($req['rentStartTime'])){$req['rentStartTime']='2015-06-01';}}

        if(!empty($req['lendStartTime'])){if(empty($req['lendEndTime'])){$req['lendEndTime']=$today;}}
        if(!empty($req['lendEndTime'])){if(empty($req['lendStartTime'])){$req['lendStartTime']='2015-06-01';}}

        $timeCondition = '';
        if(!empty($req['rentStartTime']) and !empty($req['rentEndTime'])){
        $timeCondition .= "  `rentDate` between '".$req['rentStartTime']."' AND '".$req['rentEndTime']."' ";
        }

        if(!empty($req['lendStartTime']) and !empty($req['lendEndTime'])){
            $timeCondition .= " `returnRecord` between '".$req['lendStartTime']."' AND '".$req['lendEndTime']."' ";
        }



        switch($req['requestType']){

                //全部显示的类型
            case 1:
                if((isset($_GET['returnUrl']) and !empty($_GET['returnUrl'])) or  $this->ispost()){

                    $req1['susername'] = $req['name'];
                    $req1['computerId'] = $req['computerId'];
                    $req1['monitorId'] = $req['monitor'];
                    $req1['idf'] = $req['idf'];

                    $t1 = $condition = model('admin')->conditionLike1($req1);

                    if(empty($timeCondition)){$condition = substr($condition,0,-4);}

                    $condition = $condition.$timeCondition;



                    $req['expired'] = self::rentExpired($condition);


                    if(md5($t1)!='d42698f846db8c231bc556b659b8040d'){
                        $req['history'] = self::rentHistory($condition);

                        $req['rerentlist'] = self::rerenting($condition);

                        $req['renting'] = self::rentrenting($condition);

                        $req['rentnewadd'] = self::rentnewadd($condition);

                    }


                }else{
                    $req['expired'] = self::rentExpired();
                }


                break;
            //新增租赁
            case 2:

                $timeCondition = '';

                $req1['susername'] = $req['name'];
                $req1['computerId'] = $req['computerId'];
                $req1['monitorId'] = $req['monitor'];
                $req1['idf'] = $this->$req['idf'];

                $condition = model('admin')->conditionLike($req1);

                if(empty($req['rentStartTime'])){$req['rentStartTime'] = date('Y-m-d',time()-(60*60*24*30));}
                if(empty($req['rentEndTime'])){$req['rentEndTime'] = date('Y-m-d',time());}

                if(!empty($req['rentStartTime']) and !empty($req['rentEndTime'])){
                    $timeCondition .= " `rentDate` between '".$req['rentStartTime']."' AND '".$req['rentEndTime']."' ";
                }

                $condition .= $timeCondition;

                $req['rerentlist'] = self::rerenting($condition);



                $req['rentnewadd'] = self::rentnewadd($condition);

                break;
            //历史记录
            case 3:
                $s = $req['requestType'];
                unset($req['requestType']);

                $req1['susername'] = $req['name'];
                $req1['computerId'] = $req['computerId'];
                $req1['monitorId'] = $req['monitor'];
                $req1['idf'] = $this->$req['idf'];




                $condition = model('admin')->conditionLike($req1);
                $condition.= $timeCondition;


                $req['requestType'] = $s;

                $req['history'] = self::rentHistory($condition);
                break;
            //在租
            case 4:

                $req1['susername'] = $req['name'];
                $req1['computerId'] = $req['computerId'];
                $req1['monitorId'] = $req['monitor'];
                $req1['idf'] = $this->$req['idf'];

                $t1 = $condition = model('admin')->conditionLike($req1);

            $req['renting'] = self::rentrenting($t1);
                break;
            //欠费
            case 5:
                $req['expired1'] = self::rentExpired1();
                break;


        }

        if(empty($req['requestType'])){ $req['expired'] = self::rentExpired();}


    $this->assign('req',$req);

    $this->display('rent_search');

}

    public function rentadd(){


        if($this->ispost()){

            self::rentDataInsert();

        }else{

            $url = url('rent/rentadd');

            $computerType = model('computerType')->select();

            $this->assign('computerType',$computerType);

            $this->assign('url',$url);
            $this->assign('submit',"点击添加租赁信息");
            $this->assign('tips',"确定添加?");


            $this->display('rent_index');

        }
    }

    public function rentedit(){


        if($this->ispost()){

            $req['name'] = $this->istpost('name');
            $req['computerId'] = $this->istpost('computerId');
            $req['monitor'] = $this->istpost('monitor');
            $req['idf'] = $this->istpost('idf');
            $req['requestType'] = $this->istpost('requestType');
            $req['rentStartTime'] = $this->istpost('rentStartTime');
            $req['rentEndTime'] = $this->istpost('rentEndTime');
            $req['lendStartTime'] = $this->istpost('lendStartTime');
            $req['lendEndTime'] = $this->istpost('lendEndTime');

            self::rentUpdate();

        }

        if(isset($_GET['id']) and !empty($_GET['id'])){
            $id = in($_GET['id']);
        }
        else{
            $this->error('请先选择一个学生来操作',url('rent/index'));
        }



        $rentInfo = model('rent')->find(" id='$id' ");
        $rtInfo = self::rentReturnTargetInfo($rentInfo);
        $this->assign('rtInfo',$rtInfo);
        $this->assign('submit','点击修改');
        $this->assign('tips',"确定修改?");


        $this->display('rent_index');

    }

    public function rerent(){

        $today = date('Y-m-d',time());
        $nextToday = date('Y-m-d',time()+(60*60*24*30));

        if($this->ispost()){

            $id = in($_POST['id']);
            $returnUrl = url('rent/index')."&returnUrl=".in($_POST['returnUrl']);
            if(empty($id)){$this->error('未知错误！！',$returnUrl);}


            $rentDetail =  model('rent')->find(" id='$id'");

            $rerentInfo['computerId'] = $rentDetail['computerId'];
            $rerentInfo['monitorId'] = $rentDetail['monitorId'];
            $rerentInfo['idf'] = $rentDetail['idf'];

            $update['susername'] = $rerentInfo['susername'] = $this->istpost('username');

            $update['phone'] = $rerentInfo['phone'] = $this->istpost('phone');
            $update['class'] = $rerentInfo['class'] = $this->istpost('class');
            $update['rereturnDate'] = $rerentInfo['rentDate'] = $this->istpost('startTime');
            $update['lendDate'] = $rerentInfo['lendDate'] = $this->istpost('endTime');
            $update['more'] = $rerentInfo['more'] = $this->istpost('remark');

            $rerentInsertInfo = model('rerent')->insert($rerentInfo);

            if($rerentInsertInfo){

            $updating = model('rent')->update(" id='$id' ",$update);
                if($updating){
                    $this->success("续租操作成功！！",$returnUrl);
                }
                else{
                    $this->error("未知错误！！",$returnUrl);
                }

            }else{
                $this->error("未知错误！！",$returnUrl);
            }

            //首先是插入一条续租的记录先，然后再去rentlist表里面更新日期。



        }

        if(isset($_GET['id']) and !empty($_GET['id'])){
            $id = in($_GET['id']);
        }
        else{
            $this->error('请先选择一个学生来操作',url('rent/index'));
        }
        $rentInfo = model('rent')->find(" id='$id' ");
        $rtInfo = self::rentReturnTargetInfo($rentInfo);

        unset($rtInfo['startTime']);
        unset($rtInfo['endTime']);

        $rtInfo['startTime'] = $today;
        $rtInfo['endTime'] = $nextToday;

        $this->assign('rtInfo',$rtInfo);
        $this->assign('submit','点击续租');
        $this->assign('tips',"确定续租?");


        $this->display('rent_index');

    }

    public function rentcancel(){

        $today = date("Y-m-d",time());

        if($this->ispost()){

            $id = in($_POST['id']);
            $returnUrl = in($_POST['returnUrl']);
            $update['returnRecord'] = $today;


            $rentInfo = model('rent')->update(" id='$id'",$update);
            if($rentInfo){
                $this->success("退租操作成功！");
            }
            else{
                $this->error("退租操作失败！");
            }
        }

        if(isset($_GET['id']) and !empty($_GET['id'])){
            $id = in($_GET['id']);
        }
        else{
            $this->error('请先选择一个学生来操作',url('rent/index'));
        }
        $rentInfo = model('rent')->find(" id='$id' ");
        $rtInfo = self::rentReturnTargetInfo($rentInfo);
        $this->assign('rtInfo',$rtInfo);
        $this->assign('submit','点击确认退租');
        $this->assign('tips',"确定退租?");


        $this->display('rent_index');

    }

    public function rentstore(){

        $today = date('Y-m-d',time());

        $rent = model('rent');
        //这里是根据总的电脑数量得出目前的使用情况
        $info['rentList'] = $rent->rent_store();

        //获取当前在租的电脑数量，可以得出空闲的电脑有多少台。
        $rentUsedNum = $rent->count(" returnRecord is null");

        //获取电脑总的类型
        $computerid = model('computerid');
        $info['rentCompNum'] = $computerid->count();

        //得出imac当前使用数量
        $info['imacTotal'] = $computerid->count(" type='2'");
        $info['imacUsedNum'] = $rent->count(" returnRecord is null and computerSort='2'");
        $info['imacNotUseNum'] = (int)$info['imacTotal'] - (int)$info['imacUsedNum'];

        //算出当前macmini租用中的数量
        $info['macminiTotal'] = $computerid->count(" type='1'");
        $info['macminiUsedNum'] = $rent->count(" returnRecord is null and computerSort='1'");
        $info['macminiNotUseNum'] = (int)$info['macminiTotal'] - (int)$info['macminiUsedNum'];

        $info['imacExpiredNum'] = $rent->count(" returnRecord is null and computerSort='2' and lendDate <= '$today' ");
        $info['macminiExpiredNum'] = $rent->count(" returnRecord is null and computerSort='1' and lendDate <= '$today' ");


        $this->assign('today',$today);
        $this->assign('info',$info);
        $this->display('rent_store');

    }

    private function rentDataInsert($getField=''){

        $field['idf'] = 'idf';
        $field['susername'] = 'username';
        $field['class'] = 'class';
        $field['rentDate'] = 'startTime';
        $field['lendDate'] = 'endTime';
        $field['computerId'] = 'computerId';
        $field['CpuSort'] = 'cpu';
        $field['memorySort'] = 'memory';
        $field['HDDTotal'] = 'hdtotal';
        $field['monitorId'] = 'monitor';
        $field['more'] = 'remark';
        $field['phone'] = 'phone';

        $field['mouse'] = 'mouse';
        $field['keyboard'] = 'keyboard';
        $field['email'] = 'email';

        if(isset($getField) and !empty($getField)){return $field;}

        foreach($field as $key=>$value){

        $data[$key] = in($_POST[$value]);

        }

        if(empty($data['idf'])){$this->error('身份证信息不能为空！',url('rent/rentadd'));}

        $computerId['computerId'] = $data['computerId'];
        $computerSort = model('computerid')->find($computerId);
        $data['computerSort'] = $computerSort['type'];

        $info = model('rent')->insert($data);
        if($info){$this->success("租赁数据成功插入！！",url('rent/rentadd'));}
        else{
            $this->error('插入数据失败！！',url('rent/rentadd'));
        }
    exit;
    }

    private function rentUpdate(){

        $field['susername'] = 'username';
        $field['class'] = 'class';
        $field['rentDate'] = 'startTime';
        $field['lendDate'] = 'endTime';

        $field['CpuSort'] = 'cpu';
        $field['memorySort'] = 'memory';
        $field['HDDTotal'] = 'hdtotal';

        $field['more'] = 'remark';
        $field['phone'] = 'phone';

        $field['mouse'] = 'mouse';
        $field['keyboard'] = 'keyboard';
        $field['email'] = 'email';



        $id = in($_POST['id']);
        $returnUrE = in($_POST['returnUrl']);
        $returnUrl = "&returnUrl=$returnUrE";
        $url =  url('rent/index').$returnUrl;

        if(empty($id)){$this->error('未知错误！！',$url);}

        foreach($field as $key=>$value){

            $data[$key] = in($_POST[$value]);

        }

        $info = model('rent')->update(" id='$id' ",$data);
        if($info){$this->success("租赁数据修改成功！！",url('rent/index').$returnUrl);}
        else{
            $this->error('修改数据失败！！数据应该没变动过！ ',url('rent/index').$returnUrl);
        }



    }

    //下面这个函数是将目标所有的字段转换成前端html需要的字段
    private function rentReturnTargetInfo($data){

        $data2 = '';
        $field = self::rentDataInsert($xx='yes');
        foreach($field as $key=>$value){

            $data2[$value] = $data[$key];

        }

        return $data2;

    }

    //电脑到期查询
    private function rentExpired($condition=''){

        $lendDate = date('Y-m-d',time()+(60*60*24*4));
        $condition = !empty($condition)?" and ".$condition:'';

        $rent = model('rent')->select(" lendDate <= '$lendDate' and returnRecord is null $condition ");

        return $rent;

    }

    private function rentExpired1(){

        $lendDate = date('Y-m-d',time());
        $rent = model('rent')->select(" lendDate <= '$lendDate' and returnRecord is null ");
        return $rent;

    }

    private function rentHistory($condition=''){

        $rent = model('rent')->select($condition,''," id DESC ");

        return $rent;

    }

    private function rentrenting($condition=''){

        $condition = !empty($condition)?" and ".$condition:'';
        $rent = model('rent')->select(" returnRecord is  null $condition ",''," id DESC ");
        return $rent;

    }

    private function rentnewadd($condition=''){

        $condition = !empty($condition)?" and ".$condition:'';
        $rent = model('rent')->select(" returnRecord is  null and rereturnDate is null  $condition ",''," id DESC ");
        return $rent;

    }

    private function rerenting($condition=''){

    $rent = model('rerent')->select($condition,''," id DESC ");
        return $rent;

    }

    public function rentshow(){

        $id = in($_GET['id']);

        $rtInfo1 = model('rent')->find(" id='$id'");

        $returnUrl = in($_GET['returnUrl']);

        if(empty($rtInfo1)){$this->error('没有得到结果，请选择一个可操作的对象');}

        $rtInfo = self::rentReturnTargetInfo($rtInfo1);


        $this->assign('submit',"点击返回搜索结果");

        $this->assign('rtInfo',$rtInfo);

        $this->display('rent_show');

    }





}