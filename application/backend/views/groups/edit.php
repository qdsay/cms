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
    <div id="crumbs">当前位置：用户组管理
      <div>
        <a class="btn" href="<?php echo base_url('groups')?>"><span>返回列表</span></a>
      </div>
    </div>
    <div id="panel">
      <div class="clear"></div>
      <div id="subpanel">
        <form action="<?php echo base_url('groups/edit/'.$groups->id)?>" method="post" name="myform" id="myform">
          <div class="item"><label class="item-title mark" for="name">用户组：</label><input type="text" class="input-txt" name="name" id="name" value="<?php echo $groups->name;?>" /></div>
          <div class="item"><label class="item-title" for="auth">权限：</label><div class="item-area">
          <table class="col-list" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
              <th width="15%" scope="row">模块</th>
              <th width="85%">功能</td>
            </tr>
<?php foreach($allow as $ctrl => $controler):?>
            <tr>
              <td scope="row"><input type="checkbox" name="controler[]" id="<?php echo $ctrl;?>" class="controler" value="<?php echo $ctrl;?>" <?php if (isset($groups->auth[$ctrl])) echo 'checked="checked" '?>/><?php echo $controler['title'];?></th>
              <td>
<?php foreach($controler['auth'] as $do => $method):?>
                <lable><input type="checkbox" name="<?php echo $ctrl;?>[]" id="<?php echo $ctrl;?>-<?php echo $do;?>" class="<?php echo $ctrl;?>" value="<?php echo $do;?>" <?php if (isset($groups->auth[$ctrl]) && in_array($do, $groups->auth[$ctrl])) echo 'checked="checked" '?>/><?php echo $do;?></lable>
<?php endforeach;?>
              </td>
            </tr>
<?php endforeach;?>
            </tbody>
          </table></div></div>
          <div class="item"><label class="item-title mark" for="enabled">是否启用：</label><input type="checkbox" name="enabled" id="enabled" value="1"<?php if($groups->enabled == 1):?> checked="checked"<?php endif;?>/></div>
          <div class="item"><label class="item-title" for="ok">&nbsp;</label>
            <input type="submit" name="ok" id="ok" value="保存" /><a id="cancel" class="input-btn" href="<?php echo base_url('groups')?>">取消</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
$().ready(function() {
	$(":checkbox").click(function(){
		if($(this).attr("class") == "controler") {
			if($(this).attr("checked") == "checked"){
				$("."+$(this).attr("id")).attr("checked", true);
			} else {
				$("."+$(this).attr("id")).attr("checked", false);
			}
		} else {
			var checked = false;
			$("."+$(this).attr("class")).each(function(i){
				if($(this).attr("checked") == "checked"){
					checked = true;
				}
			});
			$("#"+$(this).attr("class")).attr("checked", checked);
		}
	});

	$.validator.setDefaults({
		submitHandler: function(myform) {
			editor.sync();
			myform.submit(); 
		}
	});
	$("#myform").validate({
		rules: {
			name: {
				required: true,
				maxlength: 16
			}
		},
		messages: {
			name: {
				required: "用户组不能为空。",
				maxlength: "长度不能超过16"
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