<?php
class coresetController extends commonController{

    public  $map = null;

    public function __construct()
    {
        parent::__construct();
        $this->map = $this->getmap();
        $this->__set('map',$this->map);

    }

    public function userIndex(){

        $req['searchName'] = in($_GET['searchName']);
        $condition['department'] =  $req['searchDepartment'] = in($_GET['searchDepartment']);

        $req['me'] = 'ok';

        $req['returnUrl'] = $t = in($_GET['returnUrl']);
        if(empty($t)){$req['returnUrl'] = "admin/coreSet/userIndex";}

        $contentArray['department'] = optionValues(model('department')->select(),'dpname','--请选择--');

        $condition = unsetEmptyValues($condition);

        $searchInfo = model('user')->queryUser($condition,$req['searchName']);

        $req['action'] = url('coreSet/userAdd');

        $this->assign('req',$req);
        $this->assign('searchInfo',$searchInfo);
        $this->assign('submit',"点击添加用户");
        $this->assign('contentArray',$contentArray);
        $this->display();

    }

    public function userAdd(){


        $url = url('coreSet/userIndex')."&".in($_POST['returnUrl']);

        if($this->ispost()){

            $data['name'] = in($_POST['name']);
            $data['mobilephone'] = in($_POST['mobilephone']);
            $data['email'] = in($_POST['email']);
            $data['department'] = in($_POST['department']);

            $data = unsetEmptyValues($data);

            $where['email'] = $data['email'];
            $repeat = model('user')->find($where);

            $info = model('user')->insert($data);


            if($repeat){$this->error('错误，重复的email地址！',$url);}

            if($info){
                $this->success('添加成功！！',$url);
            }else{
                $this->error('添加失败！！',$url);
            }

        }

    }

    public function userEdit(){

        if($this->ispost()){

            $url = url('coreSet/userIndex')."&".in($_POST['returnUrl']);

            $in['id'] = $id = in($_POST['id']);
            if(empty($id)){$this->error('请选择一个用户进行操作！！',url('coreSet/userIndex'));}

            $data['name'] = in($_POST['name']);
            $data['department'] = in($_POST['department']);
            $data['mobilephone'] = in($_POST['mobilephone']);

            foreach($data as $key=>$value){
                if(empty($value)){unset($data[$key]);}
            }

            $info = model('user')->update($in,$data);

            if($info){
                $this->success('修改成功！！',$url);
            }else{
                $this->error('修改失败！！或者需要更改的数据没有变化',$url);
            }


        }

        $req['returnUrl'] = in($_GET['returnUrl']);

        $in['id'] = $id = in($_GET['id']);
        if(empty($id)){$this->error('请选择一个用户进行操作！！',url('coreSet/userIndex'));}

        $req = model('user')->find($in);
        $contentArray['department'] = optionValues(model('department')->select(),'dpname','--请选择--');


        $this->assign('req',$req);
        $this->assign('submit','点击修改');
        $this->assign('contentArray',$contentArray);
        $this->display('coreSet_userIndex');

    }

    public function userDelete(){

        $req['returnUrl'] = $t = in($_GET['returnUrl']);
        if(empty($t)){$req['returnUrl'] = "admin/coreSet/userIndex";}

        $where['id'] = $id = in($_GET['id']);

        $url = url('coreSet/userIndex');

        if(empty($id)){$this->error('无法删除用户',$url);}

        $info = model('user')->delete($where);

        if($info){
            $this->success('删除完成！！',$url);
        }else{
            $this->error('删除失败！',$url);
        }


    }

    public function departmentIndex(){

        $this->assign('submit',"点击添加部门");
        $this->assign('action',url('coreSet/departmentAdd'));

        $searchInfo = model('department')->select();


        $this->assign('searchInfo',$searchInfo);
        $this->display();

    }

    public function departmentAdd(){

        if($this->ispost()){


            $data['dpname'] = in($_POST['dpname']);
            $data['description'] = in($_POST['description']);

            $data = unsetEmptyValues($data);

            if(empty($data)){$this->error('添加失败',url('coreSet/departmentIndex'));}

            $info = model('department')->insert($data);

            if($info){
                $this->success('添加成功！',url('coreSet/departmentIndex'));
            }else{
                $this->error('添加失败',url('coreSet/departmentIndex'));
            }

        }

    }

    public function departmentEdit(){

        if($this->ispost()){

            $where['id'] = $id = in($_POST['id']);
            if(empty($id)){$this->error('错误！',url('coreSet/departmentIndex'));}

            $data['dpname'] = in($_POST['dpname']);
            $data['description'] = in($_POST['description']);

            $data = unsetEmptyValues($data);

            $info = model('department')->update($where,$data);

            if($info){
                $this->success('成功修改信息！',url('coreSet/departmentIndex'));
            }else{
                $this->error('修改信息失败！信息没有变化',url('coreSet/departmentIndex'));
            }

        }
        else{

            $where['id'] = $id = in($_GET['id']);
            if(!empty($id)){

                $this->assign('submit',"点击修改");
                $this->assign('action',url('coreSet/departmentEdit'));
            }


            $departmentInfo = model('department')->find($where);

            $req['dpname'] = $departmentInfo['dpname'];
            $req['description'] = $departmentInfo['description'];
            $req['id'] = $departmentInfo['id'];

            $this->assign('req',$req);

            $this->display('coreSet_departmentIndex');

        }

    }

    public function departmentDelete(){



        $where['id'] = $id = in($_GET['id']);

        $url = url('coreSet/departmentIndex');

        if(empty($id)){$this->error('无法删除',$url);}

        $info = model('department')->delete($where);

        if($info){
            $this->success('删除完成！！',$url);
        }else{
            $this->error('删除失败！',$url);
        }


    }

    public function locationIndex(){

        $info = model('location')->select("tid='0'");

        $i=1;
        foreach($info as $value){


            $searchInfo[$i] = $value;
            $id['tid'] = $value['id'];

            $i++;
            $subLocation = model('location')->select($id);
            if($subLocation){

                $i1=1;

                foreach($subLocation as $key1=>$value1 ){



                    if($i1==1){

                    }

                    $value1['class'] = $id['tid'];
                    $value1['subLocationName'] = $value1['locationName'];
                    unset($value1['locationName']);
                    $searchInfo[$i] = $value1;

                    $i++;
                    $i1++;
                }

            }


        }

        $contentArray['location'] = optionValues(model('location')->select("tid='0'"),'locationName','-不选默认主类-');

        $this->assign('submit','点击添加');
        $this->assign('action',url('coreset/locationAdd'));

        $this->assign('searchInfo',$searchInfo);
        $this->assign('contentArray',$contentArray);

    $this->display();

    }

    public function locationAdd(){

        if($this->ispost()){

            $data['locationName'] = in($_POST['location']);
            $data['tid'] = in($_POST['locationTid']);
            $data['description'] = in($_POST['description']);

            $data = unsetEmptyValues($data);

            if(empty($data['tid'])){$data['tid']='0';}

            $info = model('location')->insert($data);

            if($info){
                $this->success('添加成功！',url('coreSet/locationIndex'));
            }else{
                $this->error('添加失败',url('coreSet/locationIndex'));
            }

        }

    }

    public function locationEdit(){

        $url = url('coreset/locationIndex');
        if($this->ispost()){

            $id = in($_POST['id']);

            if(empty($id)){$this->error('错误！！',$url);}


            $data['locationName'] = in($_POST['location']);
            $data['tid'] = in($_POST['locationTid']);
            $data['description'] = in($_POST['description']);
            $where['id'] = in($_POST['id']);

            unsetEmptyValues($data);

            $info = model('location')->update($where,$data);

            if($info){
                $this->success('修改成功！',$url);
            }else{
                $this->error('修改失败',$url);
            }


        }

        $where['id'] = $id = in($_GET['id']);

        $req = model('location')->find($where);

        $contentArray['location'] = optionValues(model('location')->select("tid='0'"),'locationName','--主类--');

        $this->assign('submit','点击修改');
        $this->assign('req',$req);
        $this->assign('contentArray',$contentArray);
        $this->display('coreset_locationIndex');

    }

    public function measureIndex(){

        $this->assign('submit',"点击添加");
        $this->assign('action',url('coreSet/measureAdd'));

        $searchInfo = model('assetType')->select("tid='14'");


        $this->assign('searchInfo',$searchInfo);
        $this->display();

    }

    public function measureAdd(){

        if($this->ispost()){


            $data['typename'] = in($_POST['typename']);
            $data['description'] = in($_POST['description']);

            $data = unsetEmptyValues($data);

            if(empty($data)){$this->error('添加失败',url('coreSet/measureIndex'));}

            $data['tid'] = '14';

            $info = model('assetType')->insert($data);

            if($info){
                $this->success('添加成功！',url('coreSet/measureIndex'));
            }else{
                $this->error('添加失败',url('coreSet/measureIndex'));
            }

        }

    }

    public function measureEdit(){

        if($this->ispost()){

            $where['id'] = $id = in($_POST['id']);
            if(empty($id)){$this->error('错误！',url('coreSet/measureIndex'));}

            $data['typename'] = in($_POST['typename']);
            $data['description'] = in($_POST['description']);


            $data = unsetEmptyValues($data);

            $info = model('assetType')->update($where,$data);

            if($info){
                $this->success('成功修改信息！',url('coreSet/measureIndex'));
            }else{
                $this->error('修改信息失败！信息没有变化',url('coreSet/measureIndex'));
            }

        }
        else{

            $where['id'] = $id = in($_GET['id']);
            if(!empty($id)){

                $this->assign('submit',"点击修改");
                $this->assign('action','');
            }


            $departmentInfo = model('assetType')->find($where);

            $req['typename'] = $departmentInfo['typename'];
            $req['description'] = $departmentInfo['description'];
            $req['id'] = $departmentInfo['id'];
            print_r($req);
            $this->assign('req',$req);

            $this->display('coreSet_measureIndex');

        }

    }

    public function measureDelete(){



        $where['id'] = $id = in($_GET['id']);

        $url = url('coreSet/measureIndex');

        if(empty($id)){$this->error('无法删除',$url);}

        $info = model('assetType')->delete($where);

        if($info){
            $this->success('删除完成！！',$url);
        }else{
            $this->error('删除失败！',$url);
        }


    }

    public function typeIndex(){

        $info = model('assetType')->select("tid='1'");

        $i=1;
        foreach($info as $value){


            $searchInfo[$i] = $value;
            $id['tid'] = $value['id'];

            $i++;
            $subLocation = model('assetType')->select($id);
            if($subLocation){

                $i1=1;

                foreach($subLocation as $key1=>$value1 ){



                    if($i1==1){

                    }

                    $value1['class'] = $id['tid'];
                    $value1['subType'] = $value1['typename'];
                    unset($value1['typename']);
                    $searchInfo[$i] = $value1;

                    $i++;
                    $i1++;
                }

            }


        }

        $contentArray['type'] = optionValues(model('assetType')->select("tid='1'"),'typename','-不选默认主类-');

        $this->assign('submit','点击添加');
        $this->assign('action',url('coreset/typeAdd'));

        $this->assign('searchInfo',$searchInfo);
        $this->assign('contentArray',$contentArray);

        $this->display();

    }

    public function typeAdd(){

        if($this->ispost()){

            $data['typename'] = in($_POST['typename']);
            $data['tid'] = in($_POST['typeTid']);
            $data['description'] = in($_POST['description']);

            $data = unsetEmptyValues($data);

            if(empty($data['tid'])){$data['tid']='1';}

            $info = model('assetType')->insert($data);

            if($info){
                $this->success('添加成功！',url('coreSet/typeIndex'));
            }else{
                $this->error('添加失败',url('coreSet/typeIndex'));
            }

        }

    }

    public function typeEdit(){

        $url = url('coreset/typeIndex');
        if($this->ispost()){

            $id = in($_POST['id']);

            if(empty($id)){$this->error('错误！！',$url);}


            $data['typename'] = in($_POST['typename']);
            $data['tid'] = in($_POST['typeTid']);
            $data['description'] = in($_POST['description']);
            $where['id'] = in($_POST['id']);

            unsetEmptyValues($data);

            if(empty($data['tid'])){$data['tid']='1';}
            $info = model('assetType')->update($where,$data);

            if($info){
                $this->success('修改成功！',$url);
            }else{
                $this->error('修改失败',$url);
            }


        }

        $where['id'] = $id = in($_GET['id']);

        $req = model('assetType')->find($where);

        $contentArray['type'] = optionValues(model('assetType')->select("tid='1'"),'typename','--主类--');

        $this->assign('submit','点击修改');
        $this->assign('req',$req);
        $this->assign('contentArray',$contentArray);
        $this->display('coreset_typeIndex');

    }

}