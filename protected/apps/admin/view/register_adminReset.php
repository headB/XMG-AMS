<?php if(!defined('APP_NAME')) exit;?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-stand|ie-comp">
    <meta http-equiv ="X-UA-Compatible" content = "IE=edge,chrome=1"/>
    <title><?php echo $req['title']; ?></title>

    <link rel="stylesheet" href="__PUBLICAPP__/vendor/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="__PUBLICAPP__/dist/css/bootstrapValidator.css"/>

    <script type="text/javascript" src="__PUBLICAPP__/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLICAPP__/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="__PUBLICAPP__/dist/js/bootstrapValidator.js"></script>

    <script type="text/javascript">



        var InterValObj; //timer变量，控制时间
        var count = 10; //间隔函数，1秒执行
        var curCount;//当前剩余秒数


        function sendMessage() {

            var x=document.getElementById("email");

            curCount = count;
//设置button效果，开始计时
            $("#btnSendCode").attr("disabled", "true");
            $("#btnSendCode").val("注册码已经发送,如无法接收请在" + curCount + "秒内重新发送");
            InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
            //向后台发送处理数据
            $.ajax({
                type: "POST", //用POST方式传输
                dataType: "text", //数据格式:JSON
                url: '<?php echo url('register/send_code'); ?>', //目标地址
                data: {'email': x.value,"operate":'adminRegister','resetPasswd':'yes'},
                error: function (XMLHttpRequest, textStatus, errorThrown) { alert(errorthrown); },
                success: function(data){ alert(data)}
            });

        }

        //timer处理函数
        function SetRemainTime() {
            if (curCount == 0) {
                window.clearInterval(InterValObj);//停止计时器
                $("#btnSendCode").removeAttr("disabled");//启用按钮
                $("#btnSendCode").val("重新发送注册码到邮箱");
            }
            else {
                curCount--;
                $("#btnSendCode").val("" + curCount + "秒内后点击可以重新发送注册码到邮箱");
            }
        }

        function changing(){
            document.getElementById('checkpic').src="<?php echo url('register/image');?>&ic="+Math.random();
        }


    </script>

</head>
<body>
<div class="container">
    <div class="row">
        <!-- form: -->
        <section>
            <div class="col-lg-8 col-lg-offset-2">
                <div class="page-header">
                    <h2><?php echo $req['title']; ?>   <span><a href="http://xmg520.cn">点击回到首页</a></span></h2>
                    <h5 style="color: #1a8fc9">各位同事注意了！！！请尽量使用谷歌浏览器！！以免出现不兼容</h5>
                </div>

                <form id="defaultForm" method="post" class="form-horizontal" action="<?php echo url('register/send_code') ?>"
                      data-bv-message="This value is not valid"
                      data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">

                    <div class="form-group">
                        <label class="col-lg-3 control-label">你的公司邮件</label>
                        <div class="col-lg-5">
                            <input type="hidden" name="r" value="admin/register/send_code" >
                            <input type="hidden" name="operate" value="adminRegister" >
                            <input type="hidden" name="resetPasswd" value="yes" >
                            <input class="form-control" id="email" name="email" type="email" placeholder="例如：zhangquandan@520it.com"
                                   pattern="^[\w!$%&'*+/=?^_`{|}~-]+(?:\.[\w!$%&'*+/=?^_`{|}~-]+)*@520it.com$"
                                   data-bv-emailaddress-message="请输入带有@520it.com的地址"
                                   required data-bv-notempty-message="请输入有效的邮箱地址520it.com"/>

                        </div>
                    </div>

                    <input type="hidden" name="forgot" value="forgot" >

                    <div class="form-group">
                        <label class="col-lg-3 control-label">验证码</label>
                        <img style="padding-top:12px" id="checkpic" onclick="changing();" src='<?php echo url('register/image');?>' />
                        <div class="col-lg-5">
                            <input class="form-control" name="value"  placeholder="输入右侧显示的4位验证码，点图刷新"
                                   pattern="^[A-Za-z0-9]{4}$"
                                   data-bv-message="请输入4位验证码"
                                   data-bv-emailaddress-message="输入4位验证码"
                                   required data-bv-notempty-message="输入4位验证码"
                                   data-bv-remote="true" data-bv-remote-url="<?php echo url('register/ajaxReturn');?>&query=imageCode"
                                   data-bv-remote-message="验证码错误!"
                            />

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary">点击发送重置请求到邮箱</button>
                        </div>
                    </div>
                </form>

            </div>
        </section>
        <!-- :form -->
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#defaultForm').bootstrapValidator();
    });
</script>

</body></html>
