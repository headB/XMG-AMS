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


        $(function ($) {
            //行颜色效果


            //排序
            $('.order').click(function(){
                if(!$(this).has('input').length){
                    var order=$(this).html();
                    $(this).html('<input type="text" size="3" class="orderinput" value="'+order+'">');
                    $(this).find('.orderinput').select();
                    orderchange($(this).find('.orderinput'));
                }
            });
            //删除
            $('.del').click(function(){
                if(confirm('删除将不可恢复~')){
                    var delobj=$(this).parent().parent();
                    var id=delobj.attr('id');
                    $.get("{url('sort/del')}", {id:id},
                        function(data){
                            if(data==1){
                                delobj.remove();
                            }else alert(data);
                        });
                }
            });
            //折叠

            var hode='<img width="20" height="20" src="__PUBLICAPP__/images/minus.gif">';
            var show='<img width="20" height="20" src="__PUBLICAPP__/images/plus.gif">';


            $.each($(".all_cont tr"), function(i,val){
                var id=$(this).attr('id');

                if(id){//初始化收缩图标

                    if($("."+id).length <= 0){
                        $(this).find(".fold").remove();
                    }else{
                        $(this).find(".fold").html(hode);
                    }
                }
                //if($(this).attr('class')){$(this).hide()}
            });



            $('.fold').click(function(){
                var delobj=$(this).parent().parent();
                var id=delobj.attr('id');
                if(hode==$(this).html()){
                    $('.'+id).hide();
                    $(this).html(show);
                }else {
                    $('.'+id).find(".fold").html(hode);
                    $('.'+id).show();
                    $(this).html(hode);
                }
            });
            //折叠
            $('#cl').click(function(){
                $.each($(".all_cont tr"), function(i,val){
                    var id=$(this).attr('id');
                    if(id){
                        var mark=$(this).find(".fold");
                        if($(this).attr('class')){$(this).hide();mark.html(hode);}
                        else {mark.html(show);}
                    }
                });
            });
            //展开
            $('#op').click(function(){
                $.each($(".all_cont tr"), function(i,val){
                    $(this).show();
                    var mark=$(this).find(".fold");
                    if(mark){mark.html(hode);}
                });
            });
            //处理执行选择

            $('#cl').click();

            $('#dotype').change(function(){
                var delaction= "{url('sort/del')}" ;
                var moveaction="{url('sort/sortsmove')}";
                var editaction="{url('sort/sortsedit')}";
                if('del'==$(this).val()){
                    $('#dos').attr('action',delaction);
                    $('#dos').attr('onSubmit',"return confirm('删除后不可以恢复~确定要执行吗？');");
                    $('#parentid').hide();
                }else if('move'==$(this).val()){
                    $('#dos').attr('action',moveaction);
                    $('#dos').attr('onSubmit',"return confirm('移动后不可以恢复~确定要执行吗？');");
                    $('#parentid').show();
                }else if('edit'==$(this).val()){
                    $('#dos').attr('action',editaction);
                    $('#dos').attr('onSubmit',"");
                    $('#parentid').hide();
                }
            });
        });





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


    </script>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<p style="font-size: 20px" >当前操作【{$map['module']['name']}】->【{$map['action']['name']}】</p>
<center>
    <hr>

    <?php

    $title='';
    $contentArray1='';
    $content='';

    $title[] = '资产类型名称';
    $title[] = '资产类型归属';
    $title[] = '资产类型描述';

    $content[] = commonTableAddContent('input','text','typename',$req['typename'],'--默认不选择归属就是主类');
    $content[] = optionTableAddContent('typeTid',$contentArray['type'],'','',$req['tid']);
    $content[] = commonTableAddContent('input','text','description',$req['description'],'---地点说明---');

    $contentArray1[] = $content;

    $id = $req['id'];
    echo "<form action='$action' method='post' >";
    echo "<input type='hidden' name='id' value='$id' >";
    listTableNoSN($title,$contentArray1);

    echo "<input type='submit' value='$submit' class='btn btn-success'  >";
    ?>
    </form><br>



    <?php

    if(isset($searchInfo) and is_array($searchInfo)){

        ?>
        <table class="all_cont table table-responsive table-striped table-hover table-bordered" style="width:auto" cellspacing="0" cellpadding="0" border="1"  >

        <tr>
            <td>序号</td>
            <td>资产总类型<span id="op" ><img width="15" height="15" src="__PUBLICAPP__/images/plus.gif"></span><span id="cl"><img  width="15" height="15"src="__PUBLICAPP__/images/minus.gif"></span></td>
            <td>具体类型的小类</td>
            <td>资产类型描述</td>
            <td>操作</td>
            <td>操作</td>
        </tr>



<?php
        $title='';
        $contentArray1='';
        $content='';



        $i=1;

        foreach($searchInfo as $value){

            $urlEdit = url('coreset/typeEdit')."&id=".$value['id'];

        $id = $value['id'];
        echo "<tr id=\"$id\" class=\"".$value['class']."\">
        ";

            echo "<td>$i</td>";

        echo "<td>".$value['typename']."<span class=\"fold\" ></span></td>
        ";
            echo "<td>".$value['subType']."</td>
            ";
            echo "<td>".$value['description']."</td>
            ";
            echo "<td>"."<button class='btn btn-primary' ><a href='$urlEdit'>编辑</a></button>"."</td>
            ";
            echo "<td>"."<button class='btn btn-danger' onclick='return confirm(\"??\")' ><a href=''>编辑</a></button>"."</td>
            ";


            $contentArray1[]= $content;
            $content='';

            echo "</tr>
";
            $i++;
        }



    }

    ?>

        <tbody>
        </tbody></table>

    </center></body></html>
