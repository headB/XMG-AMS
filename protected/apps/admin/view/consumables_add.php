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

                $("#actualTotal").focus(function(){
                var total = $("[name='addTotal']").val();
                $("#actualTotal").val(total);
                });

                $("#totalPrice").focus(function(){
                    var total = $("[name='addTotal']").val();
                    var price = $("[name='price']").val();
                    var totalPrice = total*price;
                    $("#totalPrice").val(totalPrice);
                });

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


$title[] = "入库时间";
$title[] = "非/易耗品名称";
$title[] = "存放地点 colspan='2'";
$disabled = (!empty($req['assetName']))?"disabled='disabled'":'';
$content[] = commonTableAddContent('input','date','addTime',$req['addTime'],'','height:25px;');
$content[] = commonTableAddContent('input','text','assetName',$req['assetName'],'',""," $disabled ");

$content[] = optionTableAddContent('location',$contentArray['location'],'',"   onchange=\"getArea(this.value,'subLocation','pla')\" ",$req['location']);
$content[] = optionTableAddContent('subLocation',$contentArray['subLocation'],''," id=\"subLocation\"",$req['subLocation']);

$content1[] = "采购人";
$content1[] = "入库人";
$content1[] = "小类";
$content1[] = "供应商";

$content2[] = optionTableAddContent('buyer',$contentArray['buyer'],'','',$req['buyer']);
$content2[] = optionTableAddContent('handler',$contentArray['handler'],'','',$req['handler']);
$content2[] = optionTableAddContent('subType',$contentArray['subType'],'','',$req['subType']);
$content2[] = commonTableAddContent('input','text','providers',$req['providers'],'');


$content3[] = "入库数量";
$content3[] = "库存实际数量";
$content3[] = "计量单位";
$content3[] = "单价/元";

$content4[] = commonTableAddContent('input','number','addTotal',$req['addTotal'],'','','');
$content4[] = commonTableAddContent('input','number','actualTotal',$req['actualTotal'],'',''," id='actualTotal' ");
$content4[] = optionTableAddContent('measure',$contentArray['measure'],'','',$req['measure']);
$content4[] = commonTableAddContent('input','number','price',$req['price'],'');

$content5[] = '总价/元';
$content5[] = "规格";
$content5[] = "备注 colspan='2'";


$content6[] = commonTableAddContent('input','number','totalPrice',$req['totalPrice'],'',''," id='totalPrice' ");
$content6[] = commonTableAddContent('input','text','specification',$req['specification'],'',"","colspan='2'");
$content6[] = commonTableAddContent('input','text','remark',$req['remark'],'',"","colspan='2'");


$contentArray1[] = $content;
$contentArray1[] = $content1;
$contentArray1[] = $content2;
$contentArray1[] = $content3;
$contentArray1[] = $content4;
$contentArray1[] = $content5;
$contentArray1[] = $content6;

$id = in($_GET['id']);
$returnUrl = in($_GET['returnUrl']);

echo "<form action='' method='post' >";
echo "<input type=\"hidden\" name='id' value=\"$id\">";
echo "<input type=\"hidden\" name='returnUrl' value=\"$returnUrl\">";
listTableNoSN($title,$contentArray1);



?>

        <input type="submit" class="btn btn-success" value="<?php echo $submit; ?>">
        </form>
       </center></body></html>
