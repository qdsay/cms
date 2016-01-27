<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QD - 管理后台</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/center.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
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
    <div id="crumbs">用户中心</div>
    <div class="clear"></div>
    <div id="panel">
      <div id="subpanel">
<?php if (in_array(false, $writeable)): ?>
        <div class="warning">
          <p>文件权限：</p>
<?php foreach($writeable as $path => $val):?>
<?php if ($val === false): ?>
          <p><?php echo $dir[$path] .' '. $path;?> 目录不可写</p>
<?php endif; ?>
<?php endforeach;?>
        </div>
<?php endif; ?>
<?php if (in_array(true, $scaffold)): ?>
        <div class="warning">
          <p>脚手架：</p>
<?php foreach($scaffold as $path => $val):?>
<?php if ($val === false): ?>
          <p><?php echo $path;?> 不存在</p>
<?php endif; ?>
<?php endforeach;?>
<?php if (! in_array(false, $scaffold)): ?>
          <p><a href="<?php echo base_url('scaffold')?>" target="_blank">生成代码</a></p>
<?php endif; ?>
        </div>
<?php endif; ?>
      </div>
    </div>
    <div id="copyright">Copyright © 2016 - Powered By QDSay 3.0 Dev 20160118</div>
  </div>
</div>
</body>
</html>