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


    </style>

    <script type="text/javascript">
        $(document).ready(function(){



            $("#reset").click(function(){
                $("input").val('');
                $("select").val('');
                $("#r").val('admin/consumables/issueIndex');
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

    $title[] = '库存区域';
    $title[] = '具体区域';
    $title[] = '小类种类';
    $title[] = "领用部门";
    $title[] = "领用人";


    $title1[] = '名称';
    $title1[] = '起始时间';
    $title1[] = '截止时间';
    $title1[] = "具体操作 colspan='2'";

    $content[] = optionTableAddContent('location',$contentArray['location'],''," onchange=\"getArea(this.value,'subLocation','pla')\"",$req['location']);
    $content[] = optionTableAddContent('subLocation',$contentArray['subLocation'],''," id='subLocation' ",$req['subLocation']);
    $content[] = optionTableAddContent('subType',$contentArray['subType'],'','',$req['subType']);
    $content[] = optionTableAddContent('department',$contentArray['department'],''," onchange=\"getArea(this.value,'user','dpId')\"",$req['department']);
    $content[] = optionTableAddContent('user',$contentArray['user'],''," id='user' ",$req['user']);


    $content1[] = commonTableAddContent('input','text','assetName',$req['assetName'],'自己想象！');
    $content1[] = commonTableAddContent('input','date','startTime',$req['startTime'],'');
    $content1[] = commonTableAddContent('input','date','endTime',$req['endTime'],'');
    $content1[] = commonTableAddContent('input','submit','','点击搜索','','',"class='btn btn-success'  ");
    $content1[] = "<button  id='reset' class=\"btn btn-danger\" >重置搜索条件</button>";



    $contentArray1[] = $content;
    $contentArray1[] = $title1;
    $contentArray1[] = $content1;

    echo "<form action='' method='get' onkeypress=\"if(event.keyCode==13||event.which==13){return false;}\"  >";

    listTableNoSN($title,$contentArray1);


    ?>
    <input type="hidden" id="r" name="r" value="<?php echo $req['returnUrl']; ?>" >
    </form>

    <?php

    if(isset($searchInfo) and is_array($searchInfo)){

        $title='';

        $title[] = '名称';
        $title[] = '类型';
        $title[] = '出库时间';
        $title[] = '单价';
        $title[] = '出库数量';
        $title[] = '出库区域';
        $title[] = '计量单位';
        $title[] = '金额';
        $title[] = '领用人';
        $title[] = '备注';

        $content='';
        $contentArray='';
        foreach($searchInfo as $value){

            $content[] = $value['assetName'];
            $content[] = $value['typename'];
            $content[] = $value['issueTime'];
            $content[] = $value['price'];
            $content[] = $value['total'];
            $content[] = $value['locationName'];
            $content[] = $value['measure'];
            $content[] = $value['totalPrice'];
            $content[] = $value['user'];
            $content[] = $value['remark'];

            $contentArray[] = $content;
            $content = '';

        }

        listTable($title,$contentArray);

    }
    else{
        echo "<h3>没有搜索结果,请根据搜索框输入搜索条件</h3>";
    }

    ?>

</center></body></html>