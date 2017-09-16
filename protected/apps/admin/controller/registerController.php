<?php class registerController extends commonController{

    public function __construct()
    {
        parent::__construct();
        // print_r(Auth::getModule());//遍历所有模型和方法初始method表中数据
    }


    public function WiFiRegister(){

    if($this->ispost()){
    session_starts();


        $timeNow = date("Y-m-d H:i:s",time());

        $wifi['loginName'] = in($_POST['username']);
        $wifi['password'] = in($_POST['password']);
        $where['email'] = $wifi['email'] = in($_POST['email']);
        $user['registerCode'] = in($_POST['registerCode']);
        $user['codeImage'] = in($_POST['value']);


        $wifi['date'] = date("Y-m-d H:i:s",time());
        $wifi['time'] = "43200000";
        $wifi['octets'] = '0';
        $wifi['state'] = '1';
        $wifi['speed'] = '1';
        $wifi['maclimit'] = '0';
        $wifi['maclimitcount'] = '2';
        $wifi['autologin'] = '1';


        $regexName = "#^[_A-Za-z0-9\x{4e00}-\x{9fa5}]{2,20}$#u";
        $regexPass = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,25}/";

        $repeat = model('user')->find($where);

        if(!empty($repeat['WiFiName'])){
            $this->error('系统检查到你所属的邮箱已经注册了WiFi账号,请你直接登录，如果是忘记密码请点击"忘记密码"按钮按流程处理','http://xmg520.cn');
        }

        if(empty($repeat)){
            $this->error('系统没有找到你的邮箱信息，请用企业QQ与网络管理员取得联系！！','http://xmg520.cn');
        }

        $wifi['name'] = $repeat['name'];

        preg_match($regexName, $wifi['loginName'], $name);
        if (empty($name)) {
            $this->error("两个字符以上,只能有中文,字母,数字,下划线",'http://xmg520.cn');
        }

        preg_match($regexPass, $wifi['password'], $passwd);
        if (empty($passwd)) {
            $this->error("必须至5到25个字符长，并且至少包含一个数字，一个大写字母和一个小写字母",'http://xmg520.cn');
        }

        $user['codeImage'] = strtolower($user['codeImage']);

        if(md5($user['codeImage'])!=$_SESSION['verification']){$this->error("验证码错误！",'http://xmg520.cn');}

        $registerCodeArray = model('user')->find($where);
        $registerCode = $registerCodeArray['WiFiRegCode'];

        if(md5($user['registerCode'])!=$registerCode){$this->error("注册码不正确，或者试试重新获取啦！",'http://xmg520.cn');}

        if($registerCodeArray['WiFiCodeExpired'] < $timeNow ){$this->error("过期米线啦，请重新获取注册码啦！",'http://xmg520.cn');}


        $userUpdate['WiFiName'] = $wifi['loginName'];
        $where['email'] = $email = $wifi['email'];


        $sql_check = cryptStr("select * from portal_account where email='$email'");

        $sss = model('user')->insertEcho($wifi,'portal_account');

        $sql_operate = cryptStr(model('user')->insertEcho($wifi,'portal_account'));
        unset($wifi['loginName']);

        $sql_alter = cryptStr(model('user')->updateEcho($wifi,'portal_account',$where));

        $sql =  "insert into service_operate(`sql_operate`,`sql_check`,`sql_alter`,`db`) values('$sql_operate','$sql_check','$sql_alter','openportalserver')";




        $res = model('user')->model->query($sql);
        if($res){
            $res1= model('user')->update($where,$userUpdate);
            if($res1){
                $this->success("注册信息成功提交，请稍等大约1分钟，系统将会在1分钟之内同步所有小码哥教学点的WIFI信息",'http://xmg520.cn');
            }
            else{
                $this->error("信息注册失败！,未知原因，请联系网管！",'http://xmg520.cn');
            }
        }
        else{
            $this->error("信息注册失败！,未知原因，请联系网管！",'http://xmg520.cn');
        }


    }



        $req['title'] = '小码哥-wifi账号注册--自助注册';
        $req['submit'] = '点击完成注册';
        $req['sendMessage'] = "<input id=\"btnSendCode\" type=\"button\" value=\"发送注册码到邮箱\" onclick=\"sendMessage()\" />";


        $this->assign('req',$req);
        $this->display();

    }

    public function WiFiReset(){


        if($this->ispost()){

            $timeNow = date("Y-m-d H:i:s",time());


            $wifi['password'] = in($_POST['password']);
            $where['email'] = $wifi['email'] = in($_POST['email']);
            $user['registerCode'] = in($_POST['registerCode']);
            $user['codeImage'] = in($_POST['value']);


            $wifi['date'] = date("Y-m-d H:i:s",time());
            $wifi['time'] = "43200000";
            $wifi['octets'] = '0';
            $wifi['state'] = '1';
            $wifi['speed'] = '1';
            $wifi['maclimit'] = '0';
            $wifi['maclimitcount'] = '2';
            $wifi['autologin'] = '1';

            $regexName = "#^[_A-Za-z0-9\x{4e00}-\x{9fa5}]{2,20}$#u";
            $regexPass = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,25}/";

            $repeat = model('user')->find($where);

            if(empty($repeat)){
                $this->error('系统没有找到你的邮箱信息，请用企业QQ与网络管理员取得联系！！','http://xmg520.cn');
            }

            $wifi['name'] = $repeat['name'];

            preg_match($regexPass, $wifi['password'], $passwd);
            if (empty($passwd)) {
                $this->error("必须至5到25个字符长，并且至少包含一个数字，一个大写字母和一个小写字母",'http://xmg520.cn');
            }

            $user['codeImage'] = strtolower($user['codeImage']);

            if(md5($user['codeImage'])!=$_SESSION['verification']){$this->error("验证码错误！",'http://xmg520.cn');}

            $registerCodeArray = model('user')->find($where);
            $registerCode = $registerCodeArray['WiFiRegCode'];

            if(md5($user['registerCode'])!=$registerCode){$this->error("注册码不正确，或者试试重新获取啦！",'http://xmg520.cn');}

            if($registerCodeArray['WiFiCodeExpired'] < $timeNow ){$this->error("过期米线啦，请重新获取注册码啦！",'http://xmg520.cn');}



            $where['email'] = $email = $wifi['email'];


            $sql_check = cryptStr("select * from portal_account where email='$email'");

            $sss = model('user')->insertEcho($wifi,'portal_account');

            $sql_operate = cryptStr(model('user')->insertEcho($wifi,'portal_account'));
            unset($wifi['loginName']);

            $sql_alter = cryptStr(model('user')->updateEcho($wifi,'portal_account',$where));

            $sql =  "insert into service_operate(`sql_operate`,`sql_check`,`sql_alter`,`db`) values('$sql_operate','$sql_check','$sql_alter','openportalserver')";


            $res = model('user')->model->query($sql);
            if($res){

                    $this->success("注册信息成功提交，请稍等大约1分钟，系统将会在1分钟之内同步所有小码哥教学点的WIFI信息",'http://xmg520.cn');

            }
            else{
                $this->error("信息注册失败！,未知原因，请联系网管！",'http://xmg520.cn');
            }

        }

        $id = in($_GET['id']);

        if(empty($id)){

            $req['title'] = "wifi-账号密码重置-";
            $this->assign('req',$req);
            $this->display('');
        }
        else{

            $req['title'] = "wifi-账号密码重置-";

            $whereId['id'] = $id;

            if(!empty($whereId['id'])){

                $userResetInfo = model('user')->find($whereId);
            }else{
                $userResetInfo = array();
            }

            $req['username'] = $userResetInfo['WiFiName'];
            $req['email'] = $userResetInfo['email'];
            $req['registerCode'] = in($_GET['registerCode']);
            $req['id'] = $id;

            $req['title'] = '小码哥-wifi账号注册--密码重置';
            $req['submit'] = '点击重置wifi密码';

            $this->assign('req',$req);
            $this->display('register_WiFiRegister');

        }


    }


    public function adminRegister(){

        if($this->ispost()){

            $timeNow = date("Y-m-d H:i:s",time());

            $admin['username'] = in($_POST['username']);
            $admin['password'] = $this->newpwd(in($_POST['password']));
            $where['email'] = $admin['email'] = in($_POST['email']);
            $admin['registCode'] = in($_POST['registerCode']);
            $admin['codeImage'] = in($_POST['value']);
            $admin['groupid'] = '6';

            $userInfo = model('user')->find($where);

            if(empty($userInfo)){$this->error('错误！！，没有关于你的信息！请联系网管！','http://xmg520.cn');}

            $adminDepartment = array('18','21','23','29');

            if($userInfo){$checkAuth = in_array($userInfo['department'],$adminDepartment);
                if(!$checkAuth){$this->error('sorry,你所在的部门没有权限注册行政管理系统成员','http://xmg520.cn');}}

            //这里检查该邮箱用户是否已经在系统注册过账号，如果是的话，提示忘记密码可以重置

            $repeat = model('admin')->find($where);
            if(!empty($repeat['username']))
            {
                $this->error("你已经注册过账号了，如果忘记账号密码的话，点击\"重置\"可以更改你的密码","http://xmg520.cn");
            }

            $admin['realname'] = $userInfo['name'];
            $admin['user'] = $userInfo['id'];
            $regexName = "#^[_A-Za-z0-9\x{4e00}-\x{9fa5}]{2,20}$#u";
            $regexPass = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,25}/";

            preg_match($regexName, $admin['username'], $name);
            if (empty($name)) {
                $this->error("两个字符以上,只能有中文,字母,数字,下划线",'http://xmg520.cn');
            }

            preg_match($regexPass, $_POST['password'], $passwd);
            if (empty($passwd)) {
                $this->error("必须至5到25个字符长，并且至少包含一个数字，一个大写字母和一个小写字母",'http://xmg520.cn');
            }

            $admin['codeImage'] = strtolower( $admin['codeImage']);

            if(md5($admin['codeImage'])!=$_SESSION['verification']){$this->error("验证码错误！",'http://xmg520.cn');}

            unset($admin['codeImage']);

            $registerCodeArray = model('user')->find($where);
            $registerCode = $registerCodeArray['registCode'];

            if(md5($admin['registCode'])!=$registerCode){$this->error("注册码不正确，或者试试重新获取啦！",'http://xmg520.cn');}
            unset($admin['registCode']);

            if($registerCodeArray['registExpired'] < $timeNow ){$this->error("过期米线啦，请重新获取注册码啦！",'http://xmg520.cn');}



            $where['email'] = $email = $admin['email'];

            $res1 = model('admin')->insert($admin);

            if($res1){
                $this->success("行政系统管理员注册成功,请登录",'http://xmg520.cn');
            }
            else{
                $this->error("信息注册失败！,未知原因，请联系网管！",'http://xmg520.cn');
            }


        }



        $req['title'] = '小码哥-行政管理账号注册';
        $req['sendMessage'] = "<input id=\"btnSendCode\" type=\"button\" value=\"发送注册码到邮箱\" onclick=\"sendMessage()\" />";
        $req['submit'] = '点击创建账号';



        $this->assign('req',$req);
        $this->display();


    }

    public function adminReset(){

        if($this->ispost()){

            $timeNow = date("Y-m-d H:i:s",time());


            $admin['password'] = $this->newpwd(in($_POST['password']));
            $where['email'] = $admin['email'] = in($_POST['email']);
            $admin['registCode'] = in($_POST['registerCode']);
            $admin['codeImage'] = in($_POST['value']);
            $admin['groupid'] = '6';

            $isexist = model('admin')->find($where);
            if(empty($isexist)){$this->error("没有找到你账户的信息，或者是因为你没有注册过！请联系网管！","http://xmg520.cn");}

            $userInfo = model('user')->find($where);

            if(empty($userInfo)){$this->error('错误！！，没有关于你的信息！请联系网管！','http://xmg520.cn');}

            $adminDepartment = array('18','21','23','29');

            if($userInfo){$checkAuth = in_array($userInfo['department'],$adminDepartment);
                if(!$checkAuth){$this->error('sorry,你所在的部门没有权限注册行政管理系统成员','http://xmg520.cn');}}

            //这里检查该邮箱用户是否已经在系统注册过账号，如果是的话，提示忘记密码可以重置



            $admin['realname'] = $userInfo['name'];
            $admin['user'] = $userInfo['id'];
            $regexPass = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,25}/";



            preg_match($regexPass, $_POST['password'], $passwd);
            if (empty($passwd)) {
                $this->error("必须至5到25个字符长，并且至少包含一个数字，一个大写字母和一个小写字母",'http://xmg520.cn');
            }

            $admin['codeImage'] = strtolower( $admin['codeImage']);

            if(md5($admin['codeImage'])!=$_SESSION['verification']){$this->error("验证码错误！",'http://xmg520.cn');}

            unset($admin['codeImage']);

            $registerCodeArray = model('user')->find($where);
            $registerCode = $registerCodeArray['registCode'];

            if(md5($admin['registCode'])!=$registerCode){$this->error("注册码不正确，或者试试重新获取啦！",'http://xmg520.cn');}
            unset($admin['registCode']);

            if($registerCodeArray['registExpired'] < $timeNow ){$this->error("过期米线啦，请重新获取注册码啦！",'http://xmg520.cn');}



            $where['email'] = $email = $admin['email'];

            $res1 = model('admin')->update($where,$admin);

            if($res1){
                $this->success("行政系统管理员密码重置成功,请登录",'http://xmg520.cn');
            }
            else{
                $this->error("重置失败！,未知原因，请联系网管！",'http://xmg520.cn');
            }


        }

        $whereId['id'] = $id = in($_GET['id']);

        if(!empty($id)){


            if(!empty($whereId['id'])){

                $userResetInfo = model('admin')->find($whereId);

                if(empty($userResetInfo)){$this->error('没有该用户的信息！',"http://xmg520.cn");}

            }else{
                $userResetInfo = array();
            }

            $req['username'] = $userResetInfo['username'];
            $req['email'] = $userResetInfo['email'];
            $req['registerCode'] = in($_GET['registerCode']);
            $req['id'] = $id;

            $req['title'] = '小码哥行政系统--账号密码重置';
            $req['submit'] = '点击重置密码';

            $this->assign('req',$req);
            $this->display('register_adminRegister');


        }
        else{

            $req['title'] = '小码哥-行政管理账号重置';
            $req['sendMessage'] = "<input id=\"btnSendCode\" type=\"button\" value=\"发送注册码到邮箱\" onclick=\"sendMessage()\" />";
            $req['submit'] = '点击重置';

            $this->assign('req',$req);
            $this->display();

        }

    }

    public function estimateRegister(){

        if($this->ispost()){

            $timeNow = date("Y-m-d H:i:s",time());

            $admin['username'] = in($_POST['username']);
            $admin['password'] = md5(in($_POST['password']));
            $where['email'] = $admin['email'] = in($_POST['email']);
            $admin['registCode'] = in($_POST['registerCode']);
            $admin['codeImage'] = in($_POST['value']);


            $userInfo = model('user')->find($where);

            if(empty($userInfo)){$this->error('错误！！，没有关于你的信息！请联系网管！','http://xmg520.cn');}

            $admin['department'] = $userInfo['department'];
            $admin['realname'] = $userInfo['name'];

            $adminDepartment = array('18','21','23','29','20','27','32','30');



            if($userInfo){$checkAuth = in_array($userInfo['department'],$adminDepartment);
                if(!$checkAuth){$this->error('sorry,你所在的部门没有权限注册老师评价系统成员','http://xmg520.cn');}}

            //这里检查该邮箱用户是否已经在系统注册过账号，如果是的话，提示忘记密码可以重置


            /*$admin['realname'] = $userInfo['name'];*/

            $regexName = "#^[_A-Za-z0-9\x{4e00}-\x{9fa5}]{2,20}$#u";
            $regexPass = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,25}/";

            preg_match($regexName, $admin['username'], $name);
            if (empty($name)) {
                $this->error("两个字符以上,只能有中文,字母,数字,下划线",'http://xmg520.cn');
            }

            preg_match($regexPass, $_POST['password'], $passwd);
            if (empty($passwd)) {
                $this->error("必须至5到25个字符长，并且至少包含一个数字，一个大写字母和一个小写字母",'http://xmg520.cn');
            }

            $admin['codeImage'] = strtolower( $admin['codeImage']);

            if(md5($admin['codeImage'])!=$_SESSION['verification']){$this->error("验证码错误！",'http://xmg520.cn');}

            unset($admin['codeImage']);

            $registerCodeArray = model('user')->find($where);
            $registerCode = $registerCodeArray['registCode'];

            if(md5($admin['registCode'])!=$registerCode){$this->error("注册码不正确，或者试试重新获取啦！",'http://xmg520.cn');}
            unset($admin['registCode']);

            if($registerCodeArray['registExpired'] < $timeNow ){$this->error("过期米线啦，请重新获取注册码啦！",'http://xmg520.cn');}

            $esimate['estimateName'] = $admin['username'];


            $where['email'] = $email = $admin['email'];

            $update['estimateName'] = $admin['username'];

            $infot1 = model('user')->update($where,$update);

           /* $sqlExe['sql_check'] = cryptStr("select * from admin where `email`='$email'");
            $sqlExe['sql_operate'] = cryptStr(model('user')->insertEcho($admin,'admin'));
            $sqlExe['sql_alter'] =  cryptStr(model('user')->updateEcho($admin,'admin',$where));*/



            $exist = model('xmgCms', 'xingzheng')->find(" email=\"$email\"");

            if (empty($exist)) {
                $operateRes = model('xmgCms', 'xingzheng')->insert($admin);
            } else {
                $operateRes = model('xmgCms', 'xingzheng')->update("email=\"$email\"", $admin);
            }


            if ($operateRes >= 0) {
                $this->success("老师评价用户注册成功,北京、广州已实时同步,请登录", 'http://xmg520.cn');
            } else {
                $this->error("信息注册失败！,未知原因，请联系网管！", 'http://xmg520.cn');
            }
        }


          /*  if($infot1){

                $infot2 = model('sqlOperate')->insert($sqlExe);

                if($infot2){
                    $this->success("老师评价系统成员注册成功,请登录",'http://xmg520.cn');
                }else{
                    $this->error("信息注册失败！,未知原因，请联系网管！",'http://xmg520.cn');
                }

            }
            else{
                $this->error("信息注册失败！,总服务器登记实名制时出问题，请联系网管！",'http://xmg520.cn');
            }*/



        $req['title'] = '小码哥-老师评价系统账号注册';
        $req['sendMessage'] = "<input id=\"btnSendCode\" type=\"button\" value=\"发送注册码到邮箱\" onclick=\"sendMessage()\" />";
        $req['submit'] = '点击创建账号';

        $this->assign('req',$req);
        $this->display();

    }

    public function estimateReset(){

        if($this->ispost()) {

            $timeNow = date("Y-m-d H:i:s", time());


            $admin['password'] = md5(in($_POST['password']));
            $where['email'] = $admin['email'] = in($_POST['email']);
            $admin['registCode'] = in($_POST['registerCode']);
            $admin['codeImage'] = in($_POST['value']);


            $userInfo = model('user')->find($where);


            if (empty($userInfo)) {
                $this->error('错误！！，没有关于你的信息！请联系网管！', 'http://xmg520.cn');
            }

            $admin['department'] = $userInfo['department'];
            $admin['realname'] = $userInfo['name'];
            $admin['username'] = $userInfo['estimateName'];

            $adminDepartment = array('18', '21', '23', '29', '20', '27', '32', '30');

            if ($userInfo) {
                $checkAuth = in_array($userInfo['department'], $adminDepartment);
                if (!$checkAuth) {
                    $this->error('sorry,你所在的部门没有权限注册老师评价系统成员', 'http://xmg520.cn');
                }
            }

            //这里检查该邮箱用户是否已经在系统注册过账号，如果是的话，提示忘记密码可以重置


            /*$admin['realname'] = $userInfo['name'];*/

            $regexName = "#^[_A-Za-z0-9\x{4e00}-\x{9fa5}]{2,20}$#u";
            $regexPass = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,25}/";

            preg_match($regexName, $admin['username'], $name);
            if (empty($name)) {
                $this->error("两个字符以上,只能有中文,字母,数字,下划线", 'http://xmg520.cn');
            }

            preg_match($regexPass, $_POST['password'], $passwd);
            if (empty($passwd)) {
                $this->error("必须至5到25个字符长，并且至少包含一个数字，一个大写字母和一个小写字母", 'http://xmg520.cn');
            }

            $admin['codeImage'] = strtolower($admin['codeImage']);

            if (md5($admin['codeImage']) != $_SESSION['verification']) {
                $this->error("验证码错误！", 'http://xmg520.cn');
            }

            unset($admin['codeImage']);

            $registerCodeArray = model('user')->find($where);
            $registerCode = $registerCodeArray['registCode'];

            if (md5($admin['registCode']) != $registerCode) {
                $this->error("注册码不正确，或者试试重新获取啦！", 'http://xmg520.cn');
            }
            unset($admin['registCode']);

            if ($registerCodeArray['registExpired'] < $timeNow) {
                $this->error("过期米线啦，请重新获取注册码啦！", 'http://xmg520.cn');
            }

            $esimate['estimateName'] = $admin['username'];


            $where['email'] = $email = $admin['email'];

            $update['estimateName'] = $admin['username'];

            $infot1 = model('user')->update($where, $update);

            $estimateName = model('user')->find($where);

            if ($admin['username'] == $estimateName['estimateName']) {

                unset($infot1);
                $infot1 = true;

            }


            $exist = model('xmgCms', 'xingzheng')->find(" email=\"$email\"");

            if (empty($exist)) {
                $operateRes = model('xmgCms', 'xingzheng')->insert($admin);
            } else {
                $operateRes = model('xmgCms', 'xingzheng')->update("email=\"$email\"", $admin);
            }

            //

            //$infot2 = model('sqlOperate')->insert($sqlExe);

            if ($operateRes >= 0) {
                $this->success("老师评价用户注册成功,北京、广州已实时同步,请登录", 'http://xmg520.cn');
            } else {
                $this->error("信息注册失败！,未知原因，请联系网管！", 'http://xmg520.cn');
            }
        }

           /* }
            else{
                $this->error("信息注册失败！,总服务器登记实名制时出问题，请联系网管！",'http://xmg520.cn');
            }*/




      //  }

        $id = $whereId['id'] = in($_GET['id']);

        if(empty($id)){

            $req['title'] = '小码哥-老师评价系统账号重置';

            $this->assign('req',$req);
            $this->display();

        }


        else{

            $userResetInfo = model('user')->find($whereId);

            if(!$userResetInfo){
                $userResetInfo = array();
            }

        $req['username'] = $userResetInfo['estimateName'];
        $req['email'] = $userResetInfo['email'];
        $req['registerCode'] = in($_GET['registerCode']);
        $req['id'] = $id;

            $req['title'] = '小码哥-老师评价系统账号重置';
            $req['submit'] = '点击重置密码';
            $this->assign('req',$req);
            $this->display('register_estimateRegister');
        }


    }

    public function ajaxReturn(){

        $query = in($_GET['query']);
        $field = in($_GET['value']);

        session_starts();
        

        switch($query){

            case "imageCode":
                $field = strtolower(in($_GET['value']));
                if(md5($field)!=$_SESSION['verification']){
                    /*echo "true";*/
                    echo json_encode( array('valid'=>false));
                    exit;
                }
                else{
                    echo json_encode( array('valid'=>true));
                }

                break;

            case "name":
            $field = in($_GET['username']);
                if(!empty($field)){

                    $info = model('user')->find(" WiFiName ='$field' ");

                    if($info){echo json_encode( array('valid'=>false));exit;}
                    else{echo json_encode( array('valid'=>true));}}
                break;

            case 'adminname':
                $field = in($_GET['username']);
                if(!empty($field)){

                    $info = model('admin')->find(" username ='$field' ");

                    if($info){echo json_encode( array('valid'=>false));exit;}
                    else{echo json_encode( array('valid'=>true));}}
                break;

            case 'estimatename':
                $field = in($_GET['username']);
                if(!empty($field)){

                    $info = model('user')->find(" `estimateName` ='$field' ");

                    if($info){echo json_encode( array('valid'=>false));exit;}
                    else{echo json_encode( array('valid'=>true));}}
                break;

            default:

        }

    }

    //2016-12-01
    //下面这个是生成验证码的！！
    public function image(){

        session_starts();
        function random($len) {
            $srcstr = "1a2s3d4f5g6hj8k9qwertyupzxcvbnmyuioy";
            mt_srand();
            $strs = "";
            for ($i = 0; $i < $len; $i++) {
                $strs .= $srcstr[mt_rand(0, 30)];
            }
            return $strs;
        }

//随机生成的字符串
        $str = random(4);

//验证码图片的宽度
        $width  = 50;

//验证码图片的高度
        $height = 25;

//声明需要创建的图层的图片格式
        @ header("Content-Type:image/png");

//创建一个图层
        $im = imagecreate($width, $height);

//背景色
        $back = imagecolorallocate($im, 0xFF, 0xFF, 0xFF);

//模糊点颜色
        $pix  = imagecolorallocate($im, 187, 230, 247);

//字体色
        $font = imagecolorallocate($im, 41, 163, 238);

//绘模糊作用的点
        mt_srand();
        for ($i = 0; $i < 1000; $i++) {
            imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $pix);
        }

//输出字符
        imagestring($im, 5, 7, 5, $str, $font);

//输出矩形
        imagerectangle($im, 0, 0, $width -1, $height -1, $font);

//输出图片
        imagepng($im);

        imagedestroy($im);

        $str = md5($str);

//选择 cookie
//SetCookie("verification", $str, time() + 7200, "/");

//选择 Session
        session('verification',$str);


    }


//2016-12-02
    public function send_code(){

        session_starts();


        $where['email'] = $email = in($_POST['email']);
        $operate = in($_POST['operate']);


        if(!empty($email)){

        }else{
            echo "邮箱地址参数错误！！";exit;

        }

        $emailRegex = "#^[\w!$%&'*+/=?^_`{|}~-]+(?:\.[\w!$%&'*+/=?^_`{|}~-]+)*@520it.com$#";
        preg_match($emailRegex,$email,$result);
        if(empty($result))
        {
            echo "邮箱格式错误";exit;
            /*throw_error_and_return("邮箱格式错误！");*/
        }


        $userInfo = model('user')->find($where);
        if(empty($userInfo)){$this->error("没有该用户信息，请联系网管！");exit;}

        //检查该用户是否已经注册了，如果没有就提示去首页点注册新用户！！


        //这里是检查所有用户今天已经发送了多少次邮箱验证，检测是否超过，如果已经超出的话，就停止操作。！
        $this->check_daily_send_mail_time($email);

        $WiFiCode = $this->MakeStr(6);

        switch($operate){

            case 'adminRegister':
                $data['registCode'] = $WiFiCodeMd5 = md5($WiFiCode);
                $data['registExpired'] = $insertTime = date("Y-m-d H:i:s",time()+60*10);
                $info = model('user')->update($where,$data);

                $isreset = in($_POST['resetPasswd']);


                $postData['usname']  = $userInfo['name'];
                $postData['WiFiCode'] = $registerCode = $WiFiCode;
                $postData['emailAddress'] = $email = $userInfo['email'];
                $postData['maskCode']  = 'asd123!@#zcdaCCdDDDLp';
                $postData['content'] = "这是注册行政管理系统的注册码:".$WiFiCode;

                if(!empty($isreset)){
                    $userInfo1 = model('admin')->find($where);

                    $url = "http://xmg520.cn".url('register/adminReset')."&id=";
                    $url.= $userInfo1['id']."&registerCode=".$postData['WiFiCode'];

                $postData['content'] = "这个是重置密码的内容:→→→→→→→ <a href=\"$url\" target=\"_blank\" >点我！我是链接！</a><br>";

                }

                break;

            case 'estimateRegister':
                $data['registCode'] = $WiFiCodeMd5 = md5($WiFiCode);
                $data['registExpired'] = $insertTime = date("Y-m-d H:i:s",time()+60*10);
                $info = model('user')->update($where,$data);

                $isreset = in($_POST['resetPasswd']);


                $postData['usname']  = $userInfo['name'];
                $postData['WiFiCode'] = $registerCode = $WiFiCode;
                $postData['emailAddress'] = $email = $userInfo['email'];
                $postData['maskCode']  = 'asd123!@#zcdaCCdDDDLp';
                $postData['content'] = "这是注册老师评价系统的注册码:".$WiFiCode;

                if(!empty($isreset)){
                    $userInfo1 = model('user')->find($where);

                    if(empty($userInfo1['estimateName'])){$this->error("错误！没有找到你的注册过的信息,请重新注册新用户",'http://xmg520.cn');}

                    $url = "http://xmg520.cn".url('register/estimateReset')."&id=";
                    $url.= $userInfo1['id']."&registerCode=".$postData['WiFiCode'];

                    $postData['content'] = "这个是老师评价系统的重置密码的内容:→→→→→→→ <a href=\"$url\" target=\"_blank\" >点我！我是链接！</a><br>";

                }

                break;

            default:

                $data['WiFiRegCode'] =$WiFiCodeMd5 = md5($WiFiCode);
                $data['WiFiCodeExpired'] = $insertTime = date("Y-m-d H:i:s",time()+60*10);

                //好，现在去更新对应账户的注册码
                $info = model('user')->update($where,$data);

                $url = "http://xmg520.cn".url('register/WiFiReset')."&id=";

                $postData['usname']  = $userInfo['name'];
                $username['WiFiName'] = $userInfo['WiFiName'];
                $postData['WiFiCode'] = $registerCode = $WiFiCode;
                $postData['emailAddress'] = $email = $userInfo['email'];
                $postData['maskCode']  = 'asd123!@#zcdaCCdDDDLp';
                if(isset($_POST['forgot']) and !empty($_POST['forgot'])){

                    $userInfoEmail = model('user')->find($username);

                    $url.= $userInfoEmail['id']."&registerCode=".$postData['WiFiCode'];

                    $postData['content'] = <<<html1
这个是重置密码的内容:→→→→→→→ <a href="$url" target="_blank" >点我！我是链接！</a><br>
html1;


                }else{
                    $postData['content'] = "这个是WiFi注册用的注册码:$WiFiCode";
                }

        }

        //每次发送成功之后，都登记一下。！！
        $this->send_code_time_reg($email);


        #$Furl = model('user')->domain_to_ip('f.xmg520.cn');

        $message =  $this->syn_curl("da.xmg520.cn:82/form/getPost.php",$postData);
        preg_match_all("#estimateReset|adminReset|WiFiReset#",$_SERVER['HTTP_REFERER'],$restVar);
        if(isset($_POST['forgot']) and !empty($_POST['forgot']) ){


           //echo $_SERVER['HTTP_REFERER'];

            $this->success($message,"http://xmg520.cn");
        }
        else{
            //echo $_SERVER['HTTP_REFERER'];
            /*$this->success($message);*/
            echo $message;
        }

    }

    //2016-12-02 这个产生随机数的函数
    public function MakeStr($length)
    {
        $possible = "0123456789"."abcdefghijkmnopqrstuvwxyz";
        $str = "";
        while(strlen($str) < $length)
            $str .= substr($possible, (rand() % strlen($possible)), 1);
        return($str);
    }

    //2016-12-02
    public function send_code_time_reg($email){

        $where['email'] = $email;

        $userInfo = model('user')->find($where);
        $num = $userInfo['pingjiaSetTime'];
        $data['pingjiaSetTime'] = $num = (int)$num + 1;
        model('user')->update($where,$data);

    }

//2016-12-02
    public function check_daily_send_mail_time($email){
        $today = date("Y-m-d",time());
        $where['email'] = $email;
        $sendCodeDate = model('user')->find($where);
        if(empty($sendCodeDate)){ $this->error("error,emailInfo,contact network manager"); /*echo"error,emailInfo,contact network manager"*/;exit;}
        if($today!=$sendCodeDate['setTimeNow']){

            $data['pingjiaSetTime'] = '0';
            $data['setTimeNow'] = $today;
            model('user')->update($where,$data);
        }

        $sendCodeDate = model('user')->find($where);
        if(empty($sendCodeDate)){echo"error,emailInfo,contact network manager";exit;}
        if($sendCodeDate['pingjiaSetTime']>5){$this->error("你今天发送邮件的次数已经受限");/*echo "你今天发送邮件的次数已经受限，请联系网管！！";*/exit;}

    }

    public function syn_curl($url,$post_data)
    {
        $ch=curl_init();
        $post_data['key_syn']= 'ttyderfre4e345wer345wer34ee';
        curl_setopt($ch, CURLOPT_URL, "http://$url");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }



}




?>