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
    <div id="crumbs">当前位置：<?php echo $current;?>管理
      <div>
        <a class="btn" href="<?php echo base_url($caller)?>"><span>返回列表</span></a>
      </div>
    </div>
    <div id="panel">
      <div id="headbar">
        <div id="topitems">
          <ul>
<?php foreach($items as $k => $v):?>
<?php if($k == 'seo'):?>
            <li class="on"><?php echo $v;?></li>
<?php else:?>
            <li><a href="<?php echo base_url($caller.'/'.$k.'/'.$caller_id)?>"><?php echo $v;?></a></li>
<?php endif;?>
<?php endforeach;?>
          </ul>
        </div>
      </div>
      <div id="subpanel">
        <form action="<?php echo base_url($caller.'/seo/'.$caller_id)?>" method="post" name="myform" id="myform">
          <div class="item"><label class="item-title" for="title">SEO标题：</label><input type="text" class="input-txt long" name="title" id="title" value="<?php echo $seo['title'];?>" /></div>
          <div class="item"><label class="item-title" for="keywords">SEO关键词：</label><input type="text" class="input-txt long" name="keywords" id="keywords" value="<?php echo $seo['keywords'];?>" /></div>
          <div class="item"><label class="item-title" for="description">SEO描述：</label><div class="item-area"><textarea name="description" id="description" cols="45" rows="3"><?php echo $seo['description'];?></textarea></div></div>
          <div class="item"><label class="item-title" for="btn">&nbsp;</label>
            <input type="submit" name="ok" id="ok" value="保存" /><a id="cancel" class="input-btn" href="<?php echo base_url($caller)?>">取消</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
$().ready(function() {
    $("#myform").validate({
        rules: {
            title: {
                required: true,
                maxlength: 128
            },
            keywords: {
                maxlength: 255
            },
            description: {
                maxlength: 255
            }
        },
        messages: {
            title: {
                required: "SEO标题不能为空。",
                maxlength: "SEO标题不能超过128个字符。"
            },
            keywords: {
                maxlength: "SEO关键词不能超过255个字符。"
            },
            description: {
                maxlength: "SEO描述不能超过255个字符。"
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