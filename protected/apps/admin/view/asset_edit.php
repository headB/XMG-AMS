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
            $("button").click(function(){
                $("input").val('');
                $("select").val('');
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



    </script>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<p style="font-size: 20px" >当前操作【{$map['module']['name']}】->【{$map['action']['name']}】</p>
<center>
    <hr>
<?php
    $title[]='设备编号';
    $title[]='设备名称';
    $title[]='设备型号';
    $title[]='单价/价值';

    $disabled = '';
    $content[] = commonTableAddContent("input","text","aid",$req['aid'],"必选项：例：XMG-ZY-XX","",$disabled);
    $content[] = commonTableAddContent("input","text","aname",$req['assetname'],"必选项:例：打印机");
    $content[] = commonTableAddContent('input','text','modern',$req['version'],'必选项');
    $content[] = commonTableAddContent('input','number','avalue',$req['price'],'必选项');

    $content1[] = "设备种类";
    $content1[] = "小类";
    $content1[] = "数量";
    $content1[] = "计量单位";


    $content2[] = optionTableAddContent('assetType',$contentArray['assetType'],''," onchange=\"getArea(this.value,'subType','stp1')\" ",$req['typeId']);
    $content2[] = optionTableAddContent('subType',$contentArray['subType'],''," id='subType' ",$req['subType']);
    $content2[] = commonTableAddContent('input','number','total',$req['total'],'请输入具体的数量');
    $content2[] = optionTableAddContent('measure',$contentArray['measure'],'','',$req['measure']);


    $content3[] = '购买设备日期';
    $content3[] = '校区';
    $content3[] = "存放区域";
    $content3[] = '存放地点';


   $content4[] = commonTableAddContent('input','date','buyDate',$req['buyDate'],'');
   $content4[] = optionTableAddContent('campus',$contentArray['campus'],''," id=\"campus\" onchange=\"getArea(this.value,'location','campus');clearSelect()\"  ",$req['campus']);
   $content4[] = optionTableAddContent('location',$contentArray['location'],''," id=\"location\" onchange=\"getArea(this.value,'subLocation','pla')\" ",$req['locationId']);
   $content4[] = optionTableAddContent('subLocation',$contentArray['subLocation'],''," id='subLocation'",$req['subLocation']);

    $content5[] = '部门';
    $content5[] = '保管人员';
    $content5[] = '生产厂家';
    $content5[] = "使用情况";

    $content6[] = optionTableAddContent('department',$contentArray['department'],''," onchange=\"getArea(this.value,'user','dpId')\" ",$req['dpId']);
    $content6[] = optionTableAddContent('user',$contentArray['user'],''," id='user' ",$req['userId']);
    $content6[] = commonTableAddContent('input','text','manufacturer',$req['manufacturer'],'');

    $content6[] = optionTableAddContent('usestate',$contentArray['usestate'],''," ",$req['usestate']);


    $content7[] = "详细配置信息 colspan='4'";
    $content8[] = commonTableAddContent('input','text','remark',$req['remark'],'必选项','width:500px;',"  colspan='4'");

    $contentLast[] = $content;
    $contentLast[] = $content1;
    $contentLast[] = $content2;
    $contentLast[] = $content3;
    $contentLast[] = $content4;
    $contentLast[] = $content5;
    $contentLast[] = $content6;
    $contentLast[] = $content7;
    $contentLast[] = $content8;

    $id = $req['id'];
    $returnUrl = in($_GET['returnUrl']);

echo "<form action='$action' method='post' >";
echo "<input type=\"hidden\" name='id' value=\"$id\">";
echo "<input type=\"hidden\" name='returnUrl' value=\"$returnUrl\">";
listTableNoSN($title,$contentLast);

    ?>
    <input type="submit" class="btn btn-success" value="<?php echo $submit; ?>">
    </form>


</center>
</body>
</html>

