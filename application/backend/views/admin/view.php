<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>勤道CMS - 后台管理</title>
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
    <div id="crumbs">当前位置：管理员管理
      <div>
        <a class="btn" href="<?php echo base_url('admin')?>"><span>重新编辑</span></a>
      </div>
    </div>
    <div id="panel">
<?php if (isset($notice)): ?>
      <div id="notice">
        <h5 class="<?php echo $notice['result'];?>"><?php echo $notice['title'];?></h5>
      </div>
<?php endif; ?>
      <div class="clear"></div>
      <div id="subpanel">
        <table class="col-list" width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <th width="80px;" scope="row">用户名：</th>
            <td><?php echo $admin->username;?></td>
          </tr>
          <tr>
            <th width="80px;" scope="row">密码：</th>
            <td>&bull; &bull; &bull; &bull; &bull; &bull; &bull; &bull; &bull;</td>
          </tr>
          <tr>
<?php foreach($groups as $k => $v):?>
<?php if($k == $admin->groups_id):?>
            <th width="80px;" scope="row">用户组：</th>
            <td><?php echo $v;?></td>
<?php endif;?>
<?php endforeach;?>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>