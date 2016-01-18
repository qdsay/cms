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
    <div id="crumbs">当前位置：<?php echo $current;?>管理
      <div>
        <a class="btn" href="<?php echo base_url('article')?>"><span>返回列表</span></a>
      </div>
    </div>
    <div id="panel">
<?php if (isset($notice)): ?>
      <div id="notice">
        <h5 class="<?php echo $notice['result'];?>"><?php echo $notice['title'];?></h5>
        <p><a class="input-btn" href="<?php echo base_url('article/add')?>">继续添加</a><a class="input-btn" href="<?php echo base_url('article')?>">返回列表</a></p>
      </div>
<?php endif; ?>
      <div class="clear"></div>
      <div id="subpanel">
        <h3 class="cut-off"><span>基本信息</span><?php if (qd_func_auth('edit', $auth['article'], 'edit')): ?><a href="<?php echo base_url('article/edit/'.$article->id)?>">编辑</a><?php endif;?></h3>
        <table class="col-list" width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <th width="100px;" scope="row">标题：</th>
            <td><?php echo $article->title;?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">分类：</th>
            <td><?php echo array_key_exists($article->catalog_id, $catalog) ? $catalog[$article->catalog_id]['name'] : '';?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">文章配图：</th>
            <td><?php if ($article->image):?><a href="/<?php echo $article->image;?>" target="_blank"><img width="24" height="24" src="/<?php echo $article->image;?>"></a><?php endif;?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">标签：</th>
            <td><?php echo $article->tags;?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">摘要：</th>
            <td><?php echo $article->summary;?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">内容：</th>
            <td><?php echo $article->contents;?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">作者：</th>
            <td><?php echo $article->author;?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">信息来源：</th>
            <td><?php echo $article->origin;?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">推荐级别：</th>
            <td><?php echo isset($level[$article->level]) ? $level[$article->level] : '未分配';?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">是否启用：</th>
            <td><?php echo $disabled[$article->disabled];?></td>
          </tr>
          <tr>
            <th width="100px;" scope="row">添加时间：</th>
            <td><?php echo date('Y-m-d H:i:s', $article->addtime);?></td>
          </tr>
        </table>
<?php if (! empty($seo)):?>
        <h3 class="cut-off"><span>SEO设置</span><?php if (qd_func_auth('edit', $auth['article'], 'edit')): ?><a href="<?php echo base_url('article/seo/'.$article->id)?>">编辑</a><?php endif;?></h3>
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
<?php endif;?>
      </div>
    </div>
  </div>
</div>
</body>
</html>