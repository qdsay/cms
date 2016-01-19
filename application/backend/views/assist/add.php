<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>勤道CMS - 后台管理</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/center.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.validate.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/editor/ueditor.config.js')?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url('assets/editor/ueditor.all.min.js')?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url('assets/editor/lang/zh-cn/zh-cn.js')?>" type="text/javascript"></script>
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
    <div id="crumbs">当前位置：<?php echo $current;?>管理
      <div>
        <a class="btn" href="<?php echo base_url('assist')?>"><span>返回列表</span></a>
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
        <form action="<?php echo base_url('assist/add')?>" method="post" name="myform" id="myform">
          <div class="item"><label class="item-title mark" for="title">标题：</label><input type="text" class="input-txt long" name="title" id="title" /></div>
          <div class="item"><label class="item-title mark" for="aliases">别名：</label><input type="text" class="input-txt long" name="aliases" id="aliases" /></div>
          <div class="item editor"><label class="item-title" for="contents">内容：</label><div class="item-area">
            <script name="contents" id="contents" type="text/plain" style="width:100%;height:300px;"></script>
          </div></div>
          <div class="item"><label class="item-title mark" for="enabled">是否启用：</label><input type="checkbox" name="enabled" id="enabled" value="1" /></div>
          <div class="item"><label class="item-title" for="btn">&nbsp;</label>
            <input type="submit" name="ok" id="ok" value="保存" /><a id="cancel" class="input-btn" href="<?php echo base_url('assist')?>">取消</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
var base_url = '<?php echo base_url()?>';
$().ready(function() {
    var contents = UE.getEditor('contents');

    $.validator.setDefaults({
        submitHandler: function(myform) {
            contents.sync();
            myform.submit(); 
        }
    });
    $("#myform").validate({
        rules: {
            title: {
                required: true,
                maxlength: 128
            },
            aliases: {
                required: true,
                maxlength: 32
            },
        },
        messages: {
            title: {
                required: "标题不能为空。",
                maxlength: "标题不能超过128个字符。"
            },
            aliases: {
                required: "别名不能为空。",
                maxlength: "别名不能超过32个字符。"
            },
        },
        success: "checked",
        focusInvalid: true,
        onkeyup: false
    });
});
</script>
</body>
</html>