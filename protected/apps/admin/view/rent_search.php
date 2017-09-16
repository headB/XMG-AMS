<?php if(!defined('APP_NAME')) exit;?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-stand|ie-comp">
    <meta http-equiv ="X-UA-Compatible" content = "IE=edge,chrome=1"/>
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
    <style type="text/css">

        .table th, .table td {
            text-align: center;

        }

        p {
            font-size: 30px;
            font-family: "Microsoft YaHei", "lucida grande", verdana, lucida, STSong, sans-serif;
            font-weight: 100;
        }


    </style>
    <meta charset="UTF-8">
    <script type="text/javascript">
        $(document).ready(function(){
            $("button").click(function(){
                $("input").val('');
                $("select").val('');
            });
        });
    </script>
    <title>Document</title>
</head>
<body>

<p style="font-size: 20px" >当前操作【{$map['module']['name']}】->【{$map['action']['name']}】</p>
<center>
    <hr>

<p>支持模糊搜索，例如：搜索"铁达尼号"，你可以只输入"铁达"即可</p><p>然后某个字不确定的话，可以这样输入 "铁达_号"</p>
    <p style="font-size: 15px;">注意：《全部》搜索仅支持名字，电脑ID，显示器ID，身份证，详细搜索请选择具体的搜索类型</p>
    <?php



    $rentType[] = array('label'=>'全部','id'=>'1');
    $rentType[] = array('label'=>'新增租赁','id'=>'2');
    $rentType[] = array('label'=>'历史记录','id'=>'3');
    $rentType[] = array('label'=>'在租','id'=>'4');
    $rentType[] = array('label'=>'欠费','id'=>'5');

    $rentTypeInfo = optionValues($rentType,'label');


    echo "<br>";

    $url = url('rent/index');
    $title[] = '姓名';
    $title[] = '电脑编号';
    $title[] = '显示器编号';
    $title[] = '身份证号码';
    $title[] = '查询种类';

    $content[] = commonTableAddContent('input','text','name',$req['name'],'请输入名字');
    $content[] = commonTableAddContent('input','text','computerId',$req['computerId'],'例如：XMG-ZY-00120011');
    $content[] = commonTableAddContent('input','text','monitor',$req['monitor'],'例如：XMG-ZY-00110011');
    $content[] = commonTableAddContent('input','text','idf',$req['idf'],'请输入身份证');
    $content[] = optionTableAddContent('requestType',$rentTypeInfo,'','',$req['requestType']);


    $title1[] = '租出时间段起始';
    $title1[] = '租出时间段结束';
    $title1[] = '退租时间段起始';
    $title1[] = '退租时间段结束';
    $title1[] = 'Nothing';

    $content1[] = commonTableAddContent('input','date','rentStartTime',$req['rentStartTime'],'');
    $content1[] = commonTableAddContent('input','date','rentEndTime',$req['rentEndTime'],'');
    $content1[] = commonTableAddContent('input','date','lendStartTime',$req['lendStartTime'],'');
    $content1[] = commonTableAddContent('input','date','lendEndTime',$req['lendEndTime'],'');
    $content1[] = 'Nothing';

    $contentArray[] = $content;
    $contentArray[] = $title1;
    $contentArray[] = $content1;

    echo "<form method='post' action='$url'>";

    listTableNoSN($title,$contentArray);



    ?>

    <input type="submit" class="btn btn-success" value="点击查询" >
    <button class="btn btn-info"   >重置搜索条件</button>
    </form>

<br>

    <?php

    if(isset($req['expired']) and !empty($req['expired'])){

        $title = '';
        $content = '';
        $contentArray ='';

        $today = date('Y-m-d',time());

        $title[] = '具体操作';
        $title[] = '姓名';
        $title[] = '电脑编号';
        $title[] = '班级';
        $title[] = '租出时间';
        $title[] = '到期时间';
        $title[] = '退租时间';
        $title[] = '状态';

        $rerentUrl = url('rent/rerent');
        $rentshow  = url('rent/rentshow');
        $rentedit = url('rent/rentedit');
        $rentcancel = url('rent/rentcancel');


        $reqt['name'] = $req['name'];
        $reqt['computerId'] = $req['computerId'];
        $reqt['monitor'] = $req['monitor'];
        $reqt['idf'] = $req['idf'];
        $reqt['requestType'] = $req['requestType'];
        $reqt['rentStartTime'] = $req['rentStartTime'];
        $reqt['rentEndTime'] = $req['rentEndTime'];
        $reqt['lendStartTime'] = $req['lendStartTime'];
        $reqt['lendEndTime'] = $req['lendEndTime'];
        $reqt['requestType'] = $req['requestType'];


        $returnUrl = json_encode($reqt);

        $returnUrl1 = base64_encode($returnUrl);



        $backUrl = "&returnUrl=".$returnUrl1;


        foreach($req['expired'] as $value){

            $content[] = "
<input type='button' class='btn btn-success' onclick='window.location=\"".$rerentUrl."&id=".$value['id'].$backUrl."\"' value='续租' >
<input type='button' class='btn btn-danger' onclick='window.location=\"".$rentcancel."&id=".$value['id'].$backUrl."\"'  value='退租' >
<input type='button' onclick='window.location=\"$rentshow&id=".$value['id']."&returnUrl="."$returnUrl1"."\"'  class='btn btn-info' value='查看' >
<input type='button' onclick='window.location=\"$rentedit&id=".$value['id']."&returnUrl="."$returnUrl1"."\"'  class='btn btn-warning' value='修改' >

";

            $content[] = $value['susername'];
            $content[] = $value['computerId'];
            $content[] = $value['class'];
            $content[] = $value['rentDate'];
            $content[] = $value['lendDate'];
            $content[] = $value['returnRecord'];

            if($value['lendDate']<=$today){
                $content[] = "<span style='color: red'><b>欠费中</b></span>";
            }else{
                $content[] = "<span style='color: green'><b>在租中</b></span>";
            }
            $contentArray[] = $content;
            $content = '';
        }

        echo "<p>即将或者已经到期的电脑租赁名单</p>";
        listTable($title,$contentArray);

    }

    ?>


<?php

if(isset($req['history']) and  !empty($req['history'])){

    $title = '';
    $content = '';
    $contentArray ='';

    $today = date('Y-m-d',time());

    $title[] = '操作';
    $title[] = '姓名';
    $title[] = '班级';
    $title[] = '电脑编号';
    $title[] = '租出时间';
    $title[] = '到期时间';
    $title[] = '退租时间';
    $title[] = '状态';


    $rerentUrl = url('rent/rerent');

    $rentshow  = url('rent/rentshow');


    $reqt['name'] = $req['name'];
    $reqt['computerId'] = $req['computerId'];
    $reqt['monitor'] = $req['monitor'];
    $reqt['idf'] = $req['idf'];
    $reqt['requestType'] = $req['requestType'];
    $reqt['rentStartTime'] = $req['rentStartTime'];
    $reqt['rentEndTime'] = $req['rentEndTime'];
    $reqt['lendStartTime'] = $req['lendStartTime'];
    $reqt['lendEndTime'] = $req['lendEndTime'];
    $reqt['requestType'] = $req['requestType'];


    $returnUrl = json_encode($reqt);

    $returnUrl1 = base64_encode($returnUrl);


    $i1 = 0;
    foreach($req['history'] as $value){


        $content[] = "<input type='button' onclick='window.location=\"$rentshow&id=".$value['id']."&returnUrl="."$returnUrl1"."\"' class='btn btn-info' value='查看' >";
        $content[] = $value['susername'];
        $content[] = $value['class'];
        $content[] = $value['computerId'];
        $content[] = $value['rentDate'];
        $content[] = $value['lendDate'];
        $content[] = $value['returnRecord'];

        if(!empty($value['returnRecord'])){

            $content[] = "<span style='color: blue'><b>已退机</b></span>";
            $contentArray[] = $content;
            $content = '';
            $i++;
        }else{

            if($value['lendDate']<=$today){
                $content[] = "<span style='color: red'><b>欠费中</b></span>";
            }else{
                $content[] = "<span style='color: green'><b>在租中</b></span>";
            }
            $contentArray[] = $content;
            $content = '';
            $i++;

        }

    }

    echo "<p>下面这个是历史记录，共-$i-条记录</p>";
    listTable($title,$contentArray);

}


if(isset($req['renting']) and  !empty($req['renting'])){

    $title = '';
    $content = '';
    $contentArray ='';

    $today = date('Y-m-d',time());

    $title[] = '具体的操作';
    $title[] = '姓名';
    $title[] = '电脑编号';
    $title[] = '班级';
    $title[] = '租出时间';
    $title[] = '到期时间';
    $title[] = '退租时间';
    $title[] = '状态';

    $rerentUrl = url('rent/rerent');
    $rentshow  = url('rent/rentshow');
    $rentedit = url('rent/rentedit');
    $rentcancel = url('rent/rentcancel');


        $reqt['name'] = $req['name'];
        $reqt['computerId'] = $req['computerId'];
        $reqt['monitor'] = $req['monitor'];
        $reqt['idf'] = $req['idf'];
        $reqt['requestType'] = $req['requestType'];
        $reqt['rentStartTime'] = $req['rentStartTime'];
        $reqt['rentEndTime'] = $req['rentEndTime'];
        $reqt['lendStartTime'] = $req['lendStartTime'];
        $reqt['lendEndTime'] = $req['lendEndTime'];
        $reqt['requestType'] = $req['requestType'];


    $returnUrl = json_encode($reqt);

    $returnUrl1 = base64_encode($returnUrl);

    $backUrl = "&returnUrl=".$returnUrl1;
    $i = 0;
    foreach($req['renting'] as $value){

        $content[] = "
<input type='button' class='btn btn-success' onclick='window.location=\"".$rerentUrl."&id=".$value['id'].$backUrl."\"' value='续租' >
<input type='button' class='btn btn-danger' onclick='window.location=\"".$rentcancel."&id=".$value['id'].$backUrl."\"'  value='退租' >
<input type='button' onclick='window.location=\"$rentshow&id=".$value['id']."&returnUrl="."$returnUrl1"."\"'  class='btn btn-info' value='查看' >
<input type='button' onclick='window.location=\"$rentedit&id=".$value['id']."&returnUrl="."$returnUrl1"."\"'  class='btn btn-warning' value='修改' >

";

        $content[] = $value['susername'];
        $content[] = $value['computerId'];
        $content[] = $value['class'];
        $content[] = $value['rentDate'];
        $content[] = $value['lendDate'];
        $content[] = $value['returnRecord'];

        if(!empty($value['returnRecord'])){

            $content[] = "<span style='color: blue'><b>已退机</b></span>";
            $contentArray[] = $content;
            $content = '';
            $i++;
        }else{

            if($value['lendDate']<=$today){
                $content[] = "<span style='color: red'><b>欠费中</b></span>";
            }else{
                $content[] = "<span style='color: green'><b>在租中</b></span>";
            }
            $contentArray[] = $content;
            $content = '';
            $i++;

        }

    }

    echo "<p>下面这个是在租记录，共-$i-条记录</p>";
    listTable($title,$contentArray);

}



if(isset($req['expired1']) and  !empty($req['expired1'])){

    $title = '';
    $content = '';
    $contentArray ='';

    $today = date('Y-m-d',time());


    $title[] = '姓名';
    $title[] = '班级';
    $title[] = '电脑编号';
    $title[] = '租出时间';
    $title[] = '到期时间';
    $title[] = '退租时间';
    $title[] = '状态';


    $i = 0;
    foreach($req['expired1'] as $value){


        $content[] = $value['susername'];
        $content[] = $value['class'];
        $content[] = $value['computerId'];
        $content[] = $value['rentDate'];
        $content[] = $value['lendDate'];
        $content[] = $value['returnRecord'];

        if(!empty($value['returnRecord'])){

            $content[] = "<span style='color: blue'><b>已退机</b></span>";
            $contentArray[] = $content;
            $content = '';
            $i++;
        }else{

            if($value['lendDate']<=$today){
                $content[] = "<span style='color: red'><b>欠费中</b></span>";
            }else{
                $content[] = "<span style='color: green'><b>在租中</b></span>";
            }
            $contentArray[] = $content;
            $content = '';
            $i++;

        }

    }

    echo "<p>下面这个是欠费记录，共-$i-条记录</p>";
    listTable($title,$contentArray);

}

if(isset($req['rentnewadd']) and  !empty($req['rentnewadd'])){

    $title = '';
    $content = '';
    $contentArray ='';

    $today = date('Y-m-d',time());


    $title[] = '姓名';
    $title[] = '班级';
    $title[] = '电脑编号';
    $title[] = '租出时间';
    $title[] = '到期时间';




    $i = 0;
    foreach($req['rentnewadd'] as $value){


        $content[] = $value['susername'];
        $content[] = $value['class'];
        $content[] = $value['computerId'];
        $content[] = $value['rentDate'];
        $content[] = $value['lendDate'];

        $contentArray[] = $content;
        $content='';
        $i++;

    }

    echo "<p>下面这个是新增记录，共-$i-条记录</p>";
    listTable($title,$contentArray);

}

if(isset($req['rerentlist']) and  !empty($req['rerentlist'])){

    $title = '';
    $content = '';
    $contentArray ='';

    $today = date('Y-m-d',time());


    $title[] = '姓名';
    $title[] = '班级';
    $title[] = '电脑编号';
    $title[] = '租出时间';
    $title[] = '到期时间';




    $i = 0;
    foreach($req['rerentlist'] as $value){




        $content[] = $value['susername'];
        $content[] = $value['class'];
        $content[] = $value['computerId'];
        $content[] = $value['rentDate'];
        $content[] = $value['lendDate'];

        $contentArray[] = $content;
        $content='';
        $i++;

    }

    echo "<p>下面这个是续租记录，共-$i-条记录</p>";
    listTable($title,$contentArray);

}





?>

</center>
</body>
</html>