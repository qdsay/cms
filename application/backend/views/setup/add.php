<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>勤道CMS - 后台管理</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/center.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.validate.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/overall.js')?>" type="text/javascript"></script>
</head>

<body>
<!--header--->
<?php $this->load->view('header');?>
<!--header end-->
<div id="wrapper">
<!--menu--->
<?php $this->load->view('menu');?>
<!--menu end-->
  <div id="main">
    <div id="crumbs">当前位置：系统管理
      <div>
        <a class="btn" href="<?php echo base_url('setup')?>"><span>返回列表</span></a>
      </div>
    </div>
    <div id="panel">
      <div id="headbar">
        <div id="topitems">
          <ul>
            <li class="on">基本信息</li>
          </ul>
        </div>
      </div>
      <div id="subpanel">
        <form action="<?php echo base_url('setup/add')?>" method="post" name="myform" id="myform">
          <div class="item"><label class="item-title mark" for="item">项目：</label><input type="text" class="input-txt long" name="item" id="item" /></div>
          <div class="item"><label class="item-title mark" for="alias">别名：</label><input type="text" class="input-txt long" name="alias" id="alias" /></div>
          <div class="item"><label class="item-title" for="content">内容：</label><div class="item-area"><textarea name="content" id="content" cols="45" rows="3"></textarea></div></div>
          <div class="item"><label class="item-title" for="btn">&nbsp;</label>
            <input type="submit" name="ok" id="ok" value="保存" /><a id="cancel" class="input-btn" href="<?php echo base_url('setup')?>">取消</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
var base_url = '<?php echo base_url()?>';
$().ready(function() {
    $.validator.setDefaults({
        submitHandler: function(myform) {
            myform.submit(); 
        }
    });
    $("#myform").validate({
        rules: {
            item: {
                required: true,
                maxlength: 32
            },
            alias: {
                required: true,
                maxlength: 32
            },
            content: {
                maxlength: 255
            }
        },
        messages: {
            item: {
                required: "项目不能为空。",
                maxlength: "项目不能超过32个字符。"
            },
            alias: {
                required: "别名不能为空。",
                maxlength: "别名不能超过32个字符。"
            },
            content: {
                maxlength: "内容不能超过255个字符。"
            }
        },
        success: "checked",
        focusInvalid: true,
        onkeyup: false
    });
});
</script>
</body>
</html>