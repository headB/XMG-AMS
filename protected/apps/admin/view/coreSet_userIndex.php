<?php if(!defined('APP_NAME')) exit;?>
<!DOCTYPE html>
<html>
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

        a:link {
            color:#FFFFFF;
            text-decoration:none;
        }

        a:visited {
            color:#FFFFFF;
            text-decoration:none;
        }

        a:hover {
            color:#FFFFFF;
            text-decoration:none;
        }

        a:active {
            color:#FFFFFF;
            text-decoration:none;
        }


    </style>

    <script type="text/javascript">
        $(document).ready(function() {
        };

        function getArea(id,p,query){
            //初始化ajax

            var xhr = new XMLHttpRequest();


            var url = "index.php?r=admin/index/ajaxReturn&query="+query+"&id="+id+"&r1="+Math.random();
            var sel=document.getElementById(p);
            //var assetTable = document.getElementById('assetDetail');
            //assetTable.innerHTML='<tr><td>hello word</td></tr>';
            //打开请求
            xhr.open("get",url,true);
            //发送数据
            xhr.send(null);

            if(query=='stp'){
                /*var length1 = $('#assetDetail > tr').length;
                 alert(length1);*/
                $('#assetDetail').html('');
                /*$('#assetDetail').hide();*/
            }
            //等待响应
            xhr.onreadystatechange = function (){

                if(xhr.readyState == 4){
                    var arr1=xhr.responseText.split(";");

                    //清空下拉菜单
                    sel.length=0;
                    arr1.length = arr1.length-1;
                    for(var i=0;i<arr1.length;i++){
                        var arr2=arr1[i].split(":");
                        if(i==0 && query=='stp'){
                            getAssetDetail(arr2[0],'assetDetail','id');
                        }
                        //产生一个option对象
                        //alert(arr2[0]);
                        var opt=new Option(arr2[1],arr2[0]);
                        //添加到当前列表当中
                        sel.add(opt,null);
                    }
                    $('#assetDetail').show();


                }


            };
            //响应的结果直接放到对应的下拉菜单中
        }
        //加载所有的省份


    </script>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<p style="font-size: 20px" >当前操作【{$map['module']['name']}】->【{$map['action']['name']}】</p>
<center>
    <hr>


    <?php

    $title[] = '姓名';
    $title[] = '所属部门';
    $title[] = '公司邮箱';
    $title[] = '联系电话';

    $content[] = commonTableAddContent('input','text','name',$req['name'],'--请输入名字--');
    $content[] = optionTableAddContent('department',$contentArray['department'],'','',$req['department']);
    $content[] = commonTableAddContent('input','text','email',$req['email'],'例如：mayun@520it.com');
    $content[] = commonTableAddContent('input','text','mobilephone',$req['mobilephone'],'--请输入电话号码--');


    $contentArray1[] = $content;

    $action=$req['action'];
    echo "<form action='$action' method='post' >";
    listTableNoSN($title,$contentArray1);

    ?>

    <input type='hidden' name='id' value='<?php echo  $req['id'];?>'>
    <input type='hidden' name='returnUrl' value='<?php echo  $req['returnUrl'];?>'>
    <input type="submit" class="btn btn-success" value="<?php echo $submit;?>" >
    </form>
    <br><br>



    <?php

    $title='';
    $content='';
    $contentArray1='';

    $title[]='名字';
    $title[]='部门';
    $title[]='操作';


    echo "<form action='$searchReturnUrl' method='get' >";
    $content[] = commonTableAddContent('input','text','searchName',$req['searchName'],'');
    $content[] = optionTableAddContent('searchDepartment',$contentArray['department'],'','',$req['searchDepartment']);
    $content[] = "<input type='submit' class='btn btn-danger' value='点击筛选' >";

    $contentArray1[]=$content;
    if(isset($req['me']) and $req['me']=='ok'){

        listTableNoSN($title,$contentArray1);
    }

    $searchUrl = 'admin/coreSet/userIndex';
    ?>
    <input type="hidden" name="r" value="<?php echo $searchUrl;  ?>" >
    </form>
    <?php

    if(isset($searchInfo) and !empty($searchInfo)){

        $title='';
        $title[] ='姓名';
        $title[] ='部门';
        $title[] ='电话号码';
        $title[] ='公司邮箱';
        $title[] ='操作';
        $title[] ='操作';

        $returnUrl = $req['returnUrl'];

        $contentArray1='';
        $req = '';

        foreach($searchInfo as $req){

            $urlEdit = url('coreSet/userEdit')."&id=".$req['id']."&returnUrl=".$returnUrl;
            $urlDelete = url('coreSet/userDelete')."&id=".$req['id']."&returnUrl=".$returnUrl;

            $content='';
            $content[] = $req['name'];
            $content[] = $req['departmentName'];
            $content[] = $req['mobilephone'];
            $content[] = $req['email'];
            $content[] = "<button class='btn btn-primary'  onclick='window.location.href=\"$urlEdit\"' >编辑/查看</button>";
            $content[] = "<button class='btn btn-warning'   onclick='return confirm(\"确认要删除？\")'><a  href='$urlDelete' >删除</a></button>";

            $contentArray1[] = $content;
            $content='';

        }


        listTable($title,$contentArray1);

    }


    ?>

    </center></body></html>
