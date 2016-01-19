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
    <div id="crumbs">当前位置：分类目录管理
      <div>
        <a class="btn" href="<?php echo base_url('catalog/pages/'.$current)?>"><span>返回列表</span></a>
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
        <h3 class="cut-off"><span>基本信息</span><a href="<?php echo base_url('catalog/edit/'.$current.'/'.$catalog->id)?>">编辑</a></h3>
        <table class="col-list" width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <th width="100px;" scope="row">类型：</th>
            <td><?php echo $type[$catalog->type];?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">分类名称：</th>
            <td><?php echo $catalog->name;?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">分类别名：</th>
            <td><?php echo $catalog->aliases;?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">是否启用：</th>
            <td><?php echo $enabled[$catalog->enabled];?></td>
          </tr>
        </table>
        <h3 class="cut-off"><span>SEO设置</span><a href="<?php echo base_url('catalog/seo/'.$current.'/'.$catalog->id)?>">编辑</a></h3>
        <table class="col-list" width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <th width="100px;" scope="row">SEO标题：</th>
            <td><?php echo $seo['title'];?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">SEO关键词：</th>
            <td><?php echo $seo['keywords'];?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">SEO描述：</th>
            <td><?php echo $seo['description'];?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>