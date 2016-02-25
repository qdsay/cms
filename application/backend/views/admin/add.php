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
    <div id="crumbs">当前位置：管理员管理
      <div>
        <a class="btn" href="<?php echo base_url('admin')?>"><span>返回列表</span></a>
      </div>
    </div>
    <div id="panel">
      <div id="headbar">
        <div id="topitems">
          <ul>
<?php foreach($items as $k => $v):?>
<?php if($k == 'edit'):?>
            <li class="on"><?php echo $v;?></li>
<?php else:?>
            <li class="step">&gt;</li><li><?php echo $v;?></li>
<?php endif;?>
<?php endforeach;?>
          </ul>
        </div>
      </div>
      <div id="subpanel">
        <form action="<?php echo base_url('admin/add')?>" method="post" name="myform" id="myform">
          <div class="item"><label class="item-title mark" for="username">用户名：</label><input type="text" class="input-txt" name="username" id="username" /></div>
          <div class="item"><label class="item-title mark" for="password">密码：</label><input type="password" class="input-txt" name="password" id="password" /></div>
          <div class="item"><label class="item-title mark" for="repassword">确认密码：</label><input type="password" class="input-txt" name="repassword" id="repassword" /></div>
          <div class="item"><label class="item-title mark" for="groups">用户组：</label>
            <select name="groups" id="groups">
              <option value="0">用户组</option>
<?php foreach($groups as $k => $v):?>
              <option value="<?php echo $k;?>"><?php echo $v;?></option>
<?php endforeach;?>
            </select>
          </div>
          <div class="item"><label class="item-title mark" for="enabled">是否启用：</label><input type="checkbox" name="enabled" id="enabled" value="1" /></div>
          <div class="item"><label class="item-title" for="btn">&nbsp;</label>
            <input type="submit" name="ok" id="ok" value="保存" /><a id="cancel" class="input-btn" href="<?php echo base_url('admin')?>">取消</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
$().ready(function() {
	$.validator.setDefaults({
		submitHandler: function(myform) {
			editor.sync();
			myform.submit(); 
		}
	});
	$("#myform").validate({
		rules: {
			username: {
				required: true,
				maxlength: 16
			},
			password: {
				required: true,
				minlength: 6,
				maxlength: 32
			},
			repassword: {
				required: true,
				minlength: 6,
				maxlength: 32,
				equalTo:"#password"
			},
			groups_id: {
				min: 1
			}
		},
		messages: {
			username: {
				required: "用户名不能为空。",
				maxlength: "用户名不能超过16个字符。"
			},
			password: {
				required: "密码不能为空。",
				minlength: "密码不能小于6个字符。",
				maxlength: "密码不能超过32个字符。"
			},
			repassword: {
				required: "确认密码不能为空。",
				minlength: "确认密码不能小于6个字符。",
				maxlength: "确认密码不能超过32个字符。",
				equalTo: "确认密码与密码不一致。"
			},
			groups_id: {
				min: "请选择用户组"
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