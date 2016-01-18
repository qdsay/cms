<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_var['site']; ?> - 后台管理</title>
<link href="<?php echo '<?php'; ?>
 echo base_url('css/style.css')<?php echo '?>'; ?>
" rel="stylesheet" type="text/css" />
<link href="<?php echo '<?php'; ?>
 echo base_url('css/center.css')<?php echo '?>'; ?>
" rel="stylesheet" type="text/css" />
<script src="<?php echo '<?php'; ?>
 echo base_url('js/jquery.min.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<script src="<?php echo '<?php'; ?>
 echo base_url('js/jquery.validate.min.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<script src="<?php echo '<?php'; ?>
 echo base_url('js/overall.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
</head>

<body>
<!--header--->
<?php echo '<?php'; ?>
 $this->load->view('header');<?php echo '?>'; ?>

<!--header end-->
<div id="wrapper">
<!--menu--->
<?php echo '<?php'; ?>
 $this->load->view('menu');<?php echo '?>'; ?>

<!--menu end-->
  <div id="main">
    <div id="crumbs">当前位置：<?php echo '<?php'; ?>
 echo $current;<?php echo '?>'; ?>
管理
      <div>
        <a class="btn" href="<?php echo '<?php'; ?>
 echo base_url('<?php echo $this->_var['table']; ?>')<?php echo '?>'; ?>
"><span>返回列表</span></a>
      </div>
    </div>
    <div id="panel">
      <div id="headbar">
        <div id="topitems">
          <ul>
            <li><a href="<?php echo '<?php'; ?>
 echo base_url('<?php echo $this->_var['table']; ?>/edit/'.$<?php echo $this->_var['table']; ?>->id)<?php echo '?>'; ?>
">基本信息</a></li>
            <li class="on">SEO设置</li>
          </ul>
        </div>
      </div>
      <div id="subpanel">
        <form action="<?php echo '<?php'; ?>
 echo base_url('<?php echo $this->_var['table']; ?>/seo/'.$<?php echo $this->_var['table']; ?>->id)<?php echo '?>'; ?>
" method="post" name="myform" id="myform">
          <div class="item"><label class="item-title" for="title">SEO标题：</label><input type="text" class="input-txt long" name="title" id="title" value="<?php if ($this->_var['seo'] [ 'title' ]): ?><?php echo '<?php'; ?>
 echo empty($seo['title']) ? $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['seo']['title']; ?> : $seo['title'];<?php echo '?>'; ?>
<?php else: ?><?php echo '<?php'; ?>
 echo $seo['title'];<?php echo '?>'; ?>
<?php endif; ?>" /></div>
          <div class="item"><label class="item-title" for="keywords">SEO关键词：</label><input type="text" class="input-txt long" name="keywords" id="keywords" value="<?php if ($this->_var['seo'] [ 'keywords' ]): ?><?php echo '<?php'; ?>
 echo empty($seo['keywords']) ? $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['seo']['keywords']; ?> : $seo['keywords'];<?php echo '?>'; ?>
<?php else: ?><?php echo '<?php'; ?>
 echo $seo['keywords'];<?php echo '?>'; ?>
<?php endif; ?>" /></div>
          <div class="item"><label class="item-title" for="description">SEO描述：</label><div class="item-area"><textarea name="description" id="description" cols="45" rows="3"><?php if ($this->_var['seo'] [ 'description' ]): ?><?php echo '<?php'; ?>
 echo empty($seo['description']) ? $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['seo']['description']; ?> : $seo['description'];<?php echo '?>'; ?>
<?php else: ?><?php echo '<?php'; ?>
 echo $seo['description'];<?php echo '?>'; ?>
<?php endif; ?></textarea></div></div>
          <div class="item"><label class="item-title" for="btn">&nbsp;</label>
            <input type="submit" name="ok" id="ok" value="保存" /><a id="cancel" href="<?php echo '<?php'; ?>
 echo base_url('<?php echo $this->_var['table']; ?>')<?php echo '?>'; ?>
">取消</a>
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