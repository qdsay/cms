<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>勤道CMS - 后台管理</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/center.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/overall.js')?>" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
var base_url = '<?php echo base_url('assist')?>';
</script>
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
<?php if (qd_func_auth('add', $auth['assist'], 'edit')): ?>
      <div>
        <a class="btn" href="<?php echo base_url('assist/add')?>"><span>添加页面</span></a>
      </div>
<?php endif;?>
    </div>
    <div id="panel">
      <div id="headbar">
        <div id="topsearch">
          <form id="seachform" name="seachform" method="get" action="<?php echo base_url('assist/pages')?>">
            <input name="title" type="text" class="input-txt short" id="title" title="标题" onfocus="javascript:if(this.value == '标题') this.value = '';" value="<?php echo empty($where['title'])?'标题':$where['title']?>" />
            <input name="aliases" type="text" class="input-txt short" id="aliases" title="别名" onfocus="javascript:if(this.value == '别名') this.value = '';" value="<?php echo empty($where['aliases'])?'别名':$where['aliases']?>" />
            <button id="search" class="input-btn" type="submit">搜索</button>
          </form>
        </div>
        <div id="toppage"><?php echo $paging->tinylinks();?></div>
      </div>
      <div id="subpanel">
        <form id="listform" name="listform" method="post" action="<?php echo base_url('assist/batch/del')?>">
        <table class="row-list" width="100%" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th scope="col">全选<input type="checkbox" name="checkAll" id="checkAll" /></th>
              <th scope="col">标题</th>
              <th scope="col">别名</th>
              <th scope="col"><?php echo qd_order_by('assist/pages', $paging->query, 'disabled', '是否启用')?></th>
              <th scope="col"><?php echo qd_order_by('assist/pages', $paging->query, 'addtime', '添加时间')?></th>
              <th scope="col">操作</th>
            </tr>
          </thead>
<?php if (empty($list)): ?>
            <tbody>
              <tr>
                <td colspan="6">暂未添加页面：<a href="<?php echo base_url('assist/add')?>">添加</a></td>
              </tr>
            </tbody>
<?php else: ?>
          <tbody>
<?php foreach($list as $k=>$row):?>
            <tr id="<?php echo $row->id;?>">
              <td><input type="checkbox" name="assist[<?php echo $row->id;?>]" id="assist_<?php echo $row->id;?>" value="<?php echo $row->id;?>" class="checkIt" /></td>
              <td><?php echo $row->title;?></td>
              <td><?php echo $row->aliases;?></td>
              <td><a id="<?php echo $row->id;?>" class="setDisabled" status="<?php echo $row->disabled;?>" href="javascript:void(0)"><?php echo $disabled[$row->disabled];?></a></td>
              <td><?php echo date('Y-m-d', $row->addtime);?></td>
              <td><a href="<?php echo base_url('assist/view/'.$row->id)?>">查看</a>
<?php if (qd_func_auth('edit', $auth['assist'], 'edit')): ?>
                | <a href="<?php echo base_url('assist/edit/'.$row->id)?>">编辑</a>
<?php endif;?>
<?php if (qd_func_auth('del', $auth['assist'], 'del')): ?>
                | <a id="<?php echo $row->id;?>" title="页面:<?php echo $row->title;?>" class="delIt" href="javascript:void(0)">删除</a>
<?php endif;?>
              </td>
            </tr>
<?php endforeach;?>
          </tbody>
<?php endif;?>
        </table>
        <div id="footbar">
          <div id="action"><button id="delChecked" type="button">删除选中</button></div>
          <div id="paging"><?php echo $paging->links();?></div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>