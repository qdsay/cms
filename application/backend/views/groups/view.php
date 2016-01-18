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
    <div id="crumbs">当前位置：用户组管理
      <div>
        <a class="btn" href="<?php echo base_url('groups')?>"><span>返回列表</span></a>
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
        <h3 class="cut-off"><span>权限信息</span><a href="<?php echo base_url('groups/edit/'.$groups->id)?>">编辑</a></h3>
        <table class="col-list" width="100%" border="1" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <th width="100px;" scope="row">用户组：</th>
              <td><?php echo $groups->name;?></td>
            </tr>
          </tbody>
        </table>
        <div class="clear"></div>
        <table class="col-list" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
          <tr>
            <th width="100px;" scope="row">模块</th>
            <td>功能</td>
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
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>