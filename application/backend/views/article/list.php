<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>勤道CMS - 后台管理</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/center.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.qd.catalog.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/overall.js')?>" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
var base_url = '<?php echo base_url('article')?>';
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
<?php if (qd_func_auth('add', $auth['article'], 'edit')): ?>
      <div>
        <a class="btn" href="<?php echo base_url('article/add')?>"><span>添加文章</span></a>
      </div>
<?php endif;?>
    </div>
    <div id="panel">
      <div id="headbar">
        <div id="topsearch">
          <form id="seachform" name="seachform" method="get" action="<?php echo base_url('article/pages')?>">
            <input name="title" type="text" class="input-txt short" id="title" title="标题" onfocus="javascript:if(this.value == '标题') this.value = '';" value="<?php echo empty($where['title'])?'标题':$where['title']?>" />
            <select id="catalog" for="catalog_id" default="<?php echo qd_trace_catalog($catalog, $where['catalog_id']);?>">
              <option value="">选择分类</option>
            </select>
            <input type="hidden" name="catalog_id" id="catalog_id" class="catalog" title="分类" value="<?php echo $where['catalog_id'];?>" />
            <button id="search" class="input-btn" type="submit">搜索</button>
          </form>
        </div>
        <div id="toppage"><?php echo $paging->tinylinks();?></div>
      </div>
      <div id="subpanel">
        <form id="listform" name="listform" method="post" action="<?php echo base_url('article/batch/del')?>">
        <table class="row-list" width="100%" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th scope="col">全选<input type="checkbox" name="checkAll" id="checkAll" /></th>
              <th scope="col">标题</th>
              <th scope="col">分类</th>
              <th scope="col">文章配图</th>
              <th scope="col">作者</th>
              <th scope="col"><?php echo qd_order_by('article/pages', $paging->query, 'disabled', '是否启用')?></th>
              <th scope="col"><?php echo qd_order_by('article/pages', $paging->query, 'addtime', '添加时间')?></th>
              <th scope="col">操作</th>
            </tr>
          </thead>
<?php if (empty($list)): ?>
            <tbody>
              <tr>
                <td colspan="8">暂未添加文章：<a href="<?php echo base_url('article/add')?>">添加</a></td>
              </tr>
            </tbody>
<?php else: ?>
          <tbody>
<?php foreach($list as $k=>$row):?>
            <tr id="<?php echo $row->id;?>">
              <td><input type="checkbox" name="article[<?php echo $row->id;?>]" id="article_<?php echo $row->id;?>" value="<?php echo $row->id;?>" class="checkIt" /></td>
              <td><?php echo $row->title;?></td>
              <td><?php echo isset($catalog[$row->catalog_id]) ? $catalog[$row->catalog_id]['name'] : '未分配';?></td>
              <td><?php if ($row->image):?><a href="/<?php echo $row->image;?>" target="_blank"><img width="24" height="24" src="/<?php echo $row->image;?>"></a><?php endif;?></td>
              <td><?php echo $row->author;?></td>
              <td><a id="<?php echo $row->id;?>" class="setDisabled" status="<?php echo $row->disabled;?>" href="javascript:void(0)"><?php echo $disabled[$row->disabled];?></a></td>
              <td><?php echo date('Y-m-d', $row->addtime);?></td>
              <td><a href="<?php echo base_url('article/view/'.$row->id)?>">查看</a>
<?php if (qd_func_auth('edit', $auth['article'], 'edit')): ?>
                | <a href="<?php echo base_url('article/edit/'.$row->id)?>">编辑</a>
<?php endif;?>
<?php if (qd_func_auth('del', $auth['article'], 'del')): ?>
                | <a id="<?php echo $row->id;?>" title="文章:<?php echo $row->title;?>" class="delIt" href="javascript:void(0)">删除</a>
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
<script language="javascript" type="text/javascript">
$().ready(function() {
    $( "#catalog" ).catalog(<?php echo qd_format_catalog($catalog);?>);
});
</script>
</body>
</html>