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
    <div id="crumbs">当前位置：分类目录管理
      <div>
        <a class="btn" href="<?php echo base_url('catalog/pages/'.$current)?>"><span>返回列表</span></a>
      </div>
    </div>
    <div id="panel">
      <div id="headbar">
        <div id="topitems">
          <ul>
            <li class="on">基本信息</li>
            <li><a href="<?php echo base_url('catalog/seo/'.$current.'/'.$catalog->id)?>">SEO设置</a></li>
          </ul>
        </div>
      </div>
      <div class="clear"></div>
      <div id="subpanel">
        <form action="<?php echo base_url('catalog/edit/'.$current.'/'.$catalog->id)?>" method="post" name="myform" id="myform">
          <div class="item"><label class="item-title mark" for="name">分类名称：</label><input type="text" class="input-txt long" name="name" id="name" value="<?php echo $catalog->name;?>" /></div>
          <div class="item"><label class="item-title" for="aliases">分类别名：</label><input type="text" class="input-txt long" name="aliases" id="aliases" value="<?php echo $catalog->aliases;?>" /></div>
          <div class="item"><label class="item-title" for="disabled">是否启用：</label><input type="checkbox" name="disabled" id="disabled" value="1"<?php if($catalog->disabled == 1) echo ' checked="checked"';?>/></div>
          <div class="item"><label class="item-title" for="btn">&nbsp;</label>
            <input type="submit" name="ok" id="ok" value="保存" /><a id="cancel" class="input-btn" href="<?php echo base_url('catalog')?>">取消</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
var base_url ='<?php echo base_url()?>';
$().ready(function() {

    $.validator.setDefaults({
        submitHandler: function(myform) {
            myform.submit(); 
        }
    });
    $("#myform").validate({
        rules: {
            name: {
                required: true,
                maxlength: 32
            },
            aliases: {
                maxlength: 32
            }
        },
        messages: {
            name: {
                required: "分类名称不能为空。",
                maxlength: "长度不能超过32"
            },
            aliases: {
                maxlength: "长度不能超过32"
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