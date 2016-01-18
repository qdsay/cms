<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QD - 管理员登陆</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/user.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.validate.min.js')?>" type="text/javascript"></script>
</head>

<body>
<div id="main">
  <form id="myform" name="myform" method="post" action="<?php echo base_url('login/verify')?>">
    <div id="client"><img src="<?php echo base_url('images/logo.png')?>" /></div>
    <div id="loginBox">
      <p>
        <span for="username">用户名：</span><input type="text" name="username" id="username" />
      </p>
      <p><span for="password">密码：</span><input type="password" name="password" id="password" /></p>
      <p>
        <span for="captcha">验证码：</span><input type="text" name="captcha" id="captcha" class="small" />
        <img id="imgcode" src="<?php echo base_url('login/captcha')?>">
      </p>
      <p><span for="btn">&nbsp;</span><button>登录</button></p>
    </div>
  </form>
</div>
<script language="javascript" type="text/javascript">
var base_url ='<?php echo base_url()?>';
$().ready(function() {
  if (window != top) {
    top.location.href = location.href;
	}
  $("#imgcode").click(function(){
    $("#imgcode").attr("src", base_url+"login/captcha?r=" + Math.random());
  });
  $.validator.setDefaults({
    submitHandler: function(myform) {
      $.post(base_url+"login/verify", $("#myform").serialize(), function(data){
        switch(data.status){
          case 0:
            document.location.href = base_url+"index";
            break;
          case 1:
            $("#username").addClass("error");
            $("#username").parent().append('<label class="error">用户名或密码错误。</label>');
            break;
          case 2:
            $("#captcha").addClass("error");
            $("#captcha").parent().append('<label class="error">验证码错误。</label>');
            break;
          defalut:
            break;
        }
      }, "json");
    }
  });
  $("#myform").validate({
    rules: {
      username: "required",
      password: {
        required: true,
        minlength: 6,
        maxlength: 16
      },
      captcha: {
        required: true,
        minlength: 4,
        maxlength: 4
      }
    },
    messages: {
      username: "请输入用户名。",
      password: {
        required: "请输入密码。",
        minlength: "密码不能小于6个字符",
        maxlength: "密码不能小于16个字符"
      },
      captcha: {
        required: "请输入验证码。",
        minlength: "验证码不能小于4个字符",
        maxlength: "验证码不能大于4个字符"
      }
    },
    errorPlacement: function(error, element) {
      error.appendTo(element.parent("p"));
    },
    success: "checked",
    focusInvalid: true,   
    onkeyup: false
  });
});
</script>
</body>
</html>