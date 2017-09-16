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

        span.g{
            color:green;font-size: 40px;
        }
        span.r{
            color:red;font-size: 40px;
        }

        p {
            font-size: 25px;
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
    <p>当前使用中的macmini数量是：<span class="g">{$info['macminiUsedNum']}台</span>,空闲的数量是：<span class="g">{$info['macminiNotUseNum']}台</span></p>
    <p>当前使用中的imac数量是：<span class="g">{$info['imacUsedNum']}台</span>,空闲的数量是：<span class="g">{$info['imacNotUseNum']}台</span></p>
    <p>当前欠费的<span class="r" >imac：{$info['imacExpiredNum']}台,macmini:{$info['macminiExpiredNum']}台</span></p>

    <?php


    $title[] = '主机编号';
    $title[] = '主机类型';
    $title[] = '状态';
    $title[] = '使用人';
    $title[] = '所在班级';
    $title[] = '租用到期日期';



    foreach($info['rentList'] as $value ){

        if(!empty($value['computerId'])){

            $content[] = $value['cid'];
            $content[] = '';

            if($value['lendDate'] > $today){

                $content[] = '<span style="color: green;font-weight: 200" ><b>使用中</b></span>';

            }else{
                $content[] = '<span style="color: red;font-weight: 200" ><b>欠费中</b></span>';
            }

            $content[] = $value['susername'];
            $content[] = $value['class'];
            $content[] = $value['lendDate'];

        }
        else{

            $content[] = $value['cid'];
            $content[] = '';
            $content[] = "-------------空闲------------------ colspan='5' ";


        }

        $contentArray[] = $content;
        $content = array();

    }

listTable($title,$contentArray);


    ?>


    </center>
</body></html>