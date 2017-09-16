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

        span.current {

           padding: 5px;
            padding-left: 8px;
            padding-right: 8px;
            

        }
        a.pages {
            background-color: #f5f5f5;
            padding: 5px;
            padding-left: 8px;
            padding-right: 8px;
            border:1px solid #ddd;
        }

        a.nextPage {
            background-color: #f5f5f5;
            padding: 5px;
            padding-left: 8px;
            padding-right: 8px;
            border:1px solid #ddd;
        }

        a.lastPage {
            background-color: #f5f5f5;
            padding: 5px;
            padding-left: 8px;
            padding-right: 8px;
            border:1px solid #ddd;
        }
        a.firstPage {
            background-color: #f5f5f5;
            padding: 5px;
            padding-left: 8px;
            padding-right: 8px;
            border:1px solid #ddd;
        }
        a.prePage {
            background-color: #f5f5f5;
            padding: 5px;
            padding-left: 8px;
            padding-right: 8px;
            border:1px solid #ddd;
        }


    </style>

    <script type="text/javascript">
        $(document).ready(function(){


            $("#reset").click(function(){
                $("input").val('');
                $("select").val('');
                $("#r").val('admin/asset/index');
            });


        });




        function clearSelect(){
            $("#subLocation").text('');
        }


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

        function xxtt(){



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



    $title[] = '部门';
    $title[] = '使用人';
    $title[] = '校区';
    $title[] = '区域';
    $title[] = '具体区域';
    $title[] = '是否在用';
    $title[] = '资产编号';



    $title1[] = '名称';
    $title1[] = '资产种类';
    $title1[] = '具体细类';
    $title1[] = '起始时间';
    $title1[] = '结束时间';
    $title1[] = '操作';
    $title1[] = '操作';


    $content[] = optionTableAddContent('department',$contentArray['department'],''," onchange=\"getArea(this.value,'user','dpId')\" ",$req['department']);
    $content[] = optionTableAddContent('user',$contentArray['user'],'',"id=\"user\" ",$req['user']);

    $content[] = optionTableAddContent('campus',$contentArray['campus'],''," id=\"campus\" onchange=\"getArea(this.value,'location','campus');clearSelect()\"  ",$req['campus']);
    $content[] = optionTableAddContent('location',$contentArray['location'],''," id=\"location\" onchange=\"getArea(this.value,'subLocation','pla')\" ",$req['location']);
    $content[] = optionTableAddContent('subLocation',$contentArray['subLocation'],''," id='subLocation' ",$req['subLocation']);
    $content[] = optionTableAddContent('usestate',$contentArray['usestate'],'','',$req['usestate']);
    $content[] = commonTableAddContent('input','text','aid',$req['aid'],'请输入英文编号');

    $content1[] = commonTableAddContent('input','text','assetName',$req['assetName'],'--你自己写啦！--');

    $content1[] = optionTableAddContent('type',$contentArray['assetType'],''," onchange=\"getArea(this.value,'subType','stp1')\" ",$req['assetType']);
    $content1[] = optionTableAddContent('subType',$contentArray['subType'],''," id=\"subType\" ",$req['subType']);
    $content1[] = commonTableAddContent('input','date','startTime',$req['startTime'],'');
    $content1[] = commonTableAddContent('input','date','endTime',$req['endTime'],'');
    $content1[]= "<button id='reset' class=\"btn btn-danger\" >重置搜索条件</button>";
    $content1[]= "";

    $contentArray1[] = $content;
    $contentArray1[] = $title1;
    $contentArray1[] = $content1;

    $urlAction = url('asset/index');
    echo "<form action='$urlAction' method='get' onkeypress=\"if(event.keyCode==13||event.which==13){return false;}\"  >";

    listTableNoSN($title,$contentArray1);
    $daochuweb = $_SERVER['REQUEST_URI']."&daochu=yes";

?>
    <input type="hidden" id="r" name="r" value="<?php echo $req['returnUrl']; ?>" >
    <input type='submit'  class='btn btn-success' value='点击查询' >

    </form>
<br>
     <button class="btn btn-warning" onclick="window.location.href='<?php echo $daochuweb; ?>'" >点击导出当前结果</button>
<br>
<?php
if(isset($searchInfo) and is_array($searchInfo)){

    echo "<br>";
    print_r($page);

    $title = '';
    $title[] = '名称';
    $title[] = '编号';
    $title[] = '类型';
    $title[] = '备注';
    $title[] = '使用人';
    $title[] = '所在部门';
    $title[] = '办公地点';
    $title[] = '入库时间';
    $title[] = '价格';
    $title[] = '操作';
    $title[] = '操作';


    $content='';
    $contentArray='';

    $i=0;

$returnUrl = base64_encode($_SERVER['QUERY_STRING']);

    foreach($searchInfo as $content1){

        $urlEdit = url('asset/edit')."&id=".$content1['id']."&returnUrl=".$returnUrl;

        $content[]=$content1['assetname'];
        $content[]=$content1['aid'];
        $content[]=$content1['typename'];
        $content[]=$content1['remark'];
        $content[]=$content1['user'];
        $content[]=$content1['department'];
        $content[]=$content1['locationName'];
        $content[]=$content1['buyDate'];
        $content[]=$content1['prcie'];
        $content[]="<button class='btn btn-primary' onclick='window.location.href=\"$urlEdit\"'>查看/编辑</button>";
        $content[]='删除';




        $contentArray[] = $content;
        $content='';
        $i++;

    }


    echo "<p style='font-size: 20px'>本次搜索出-> ".$countNum." <-条结果</p>";
    listTable($title,$contentArray);
    echo "<br>";
    print_r($page);


}
else{
    echo "<p>没有搜索结果，请选择输入具体的关键字来筛选数据</p>";
}


?>


</center>
</body>
</html>

