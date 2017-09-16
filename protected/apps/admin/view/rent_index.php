<?php if(!defined('APP_NAME')) exit;?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-stand|ie-comp">
    <meta http-equiv ="X-UA-Compatible" content = "IE=edge,chrome=1"/>
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
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
    <title>Document</title>
</head>
<body>
<p style="font-size: 20px" >当前操作【{$map['module']['name']}】->【{$map['action']['name']}】</p>
<center>
<hr>

<?php


$computerTypeInfo = optionValues($computerType,'typeName');




$submit = isset($submit)?$submit:"点击确认提交";

$rtInfo = isset($rtInfo)?$rtInfo:$rentValues;

    $rtInfo['startTime'] = !empty($rtInfo['startTime'])?$rtInfo['startTime']:date("Y-m-d",time());
    $rtInfo['endTime'] = !empty($rtInfo['endTime'])?$rtInfo['endTime']:date("Y-m-d",time()+(60*24*30*60));

$style['idf'] = !empty($rtInfo['idf'])?"disabled='disabled'":'';
$style['computerId'] = !empty($rtInfo['computerId'])?"disabled='disabled'":'';
$style['monitor'] = !empty($rtInfo['monitor'])?"disabled='disabled'":'';

$computerId = !empty($rtInfo['computerId'])?$rtInfo['computerId'] :"XMG-ZY-01200";
$monitor = !empty($rtInfo['monitor'])?$rtInfo['monitor']:"XMG-ZY-01100";




echo "<form action='$url' method='post' onsubmit=\"return confirm('$tips')\" >";
$title[] = '姓名';
$title[] = '身份证';
$title[] = '电话';
$title[] = '班级';
$title[] = '邮箱';

$id = in($_GET['id']);
$returnUrl = in($_GET['returnUrl']);
echo "<input type='hidden' name='id' value='$id' >";
echo "<input type='hidden' name='returnUrl' value='$returnUrl' >";

$content[] = commonTableAddContent('input','text','username',$rtInfo['username'],'请输入名字');
$content[] = commonTableAddContent('input','text','idf',$rtInfo['idf'],'身份证号码','',"pattern=\"^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|x|X)$\"
title=\"身份证格式错误！！请更正！！\"".$style['idf'].'"');
$content[] = commonTableAddContent('input','text','phone',$rtInfo['phone'],'输入数字');
$content[] = commonTableAddContent('input','text','class',$rtInfo['class'],'输入班级');
$content[] = commonTableAddContent('input','text','email',$rtInfo['email'],'输入邮箱');

echo "<p >学生信息</p>";
$contentArray[] = $content;
listTableNoSN($title,$contentArray);

unset($title);
unset($content);
unset($contentArray);

$title[] = '租赁开始时间';
$title[] = '租赁结束时间';



$content[] = commonTableAddContent('input','date','startTime',$rtInfo['startTime'],'');
$content[] = commonTableAddContent('input','date','endTime',$rtInfo['endTime'],'');


echo "<p >租赁信息</p>";
$contentArray[] = $content;
listTableNoSN($title,$contentArray);

unset($title);
unset($content);
unset($contentArray);




$title[] = '电脑主机编号';
$title[] = '显示器编号';
$title[] = '鼠标编号';
$title[] = '键盘编号';

$title1[] = 'CPU型号';
$title1[] = '内存';
$title1[] = '硬盘容量';
$title1[] = '广告位';

$title2[] = '备注/特别说明/特殊情况 colspan=\'4\' ';
$content2[]  = commonTableAddContent('input','text','remark',$rtInfo['remark'],'','width:800px'," colspan='4' ");



$content[] = commonTableAddContent('input','text','computerId',$computerId,'','',$style['idf']);
$content[] = commonTableAddContent('input','text','monitor',$monitor,'','',$style['monitor']);
$content[] = commonTableAddContent('input','text','mouse',$rtInfo['mouse'],'输入鼠标编号');
$content[] = commonTableAddContent('input','text','keyboard',$rtInfo['keyboard'],'输入键盘编号');

$content1[] = commonTableAddContent('input','text','cpu',$rtInfo['cpu'],'待定,暂时不需要输入');
$content1[] = commonTableAddContent('input','text','memory',$rtInfo['memory'],'待定,暂时不需要输入');
$content1[] = commonTableAddContent('input','text','hdtotal',$rtInfo['hdtotal'],'待定,暂时不需要输入');
$content1[] = "Nothing";


$contentArray[] = $content;
$contentArray[] = $title1;
$contentArray[] = $content1;
$contentArray[] = $title2;
$contentArray[] = $content2;

echo "<p >设备信息</p>";

listTableNoSN($title,$contentArray);

unset($title);
unset($content);
unset($contentArray);


?>
<br>
<input type="submit" style="font-size: 25px" class="btn btn-success" value="{$submit}" >
</form>

</center>
</body>
</html>

