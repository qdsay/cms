<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$site} - 后台管理</title>
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
        <a class="btn" href="<?php echo base_url('{$table}')?>"><span>返回列表</span></a>
      </div>
    </div>
    <div id="panel">
<?php if (isset($notice)): ?>
      <div id="notice">
        <h5 class="<?php echo $notice['result'];?>"><?php echo $notice['title'];?></h5>
        <p><a class="input-btn" href="<?php echo base_url('{$table}/add')?>">继续添加</a><a class="input-btn" href="<?php echo base_url('{$table}')?>">返回列表</a></p>
      </div>
<?php endif; ?>
      <div class="clear"></div>
      <div id="subpanel">
        <h3 class="cut-off"><span>基本信息</span><?php if (qd_func_auth('edit', $auth['{$table}'], 'edit')): ?><a href="<?php echo base_url('{$table}/edit/'.${$table}->id)?>">编辑</a><?php endif;?></h3>
        <table class="col-list" width="100%" border="1" cellspacing="0" cellpadding="0">
{foreach from=$entry item=format key=field}
{if $format eq 'catalog'}
          <tr>
            <th width="100px;" scope="row">{$comments[$field]|default:$field}：</th>
            <td><?php echo array_key_exists(${$table}->{$field}, ${$field|strip_id}) ? ${$field|strip_id}[${$table}->{$field}]['name'] : '';?></td>
          </tr>
{elseif $format eq 'select-from-db' or $format eq 'radio-from-db' or $format eq 'checkbox-from-db'}
          <tr>
            <th width="100px;" scope="row">{$comments[$field]|default:$field}：</th>
            <td><?php echo ${$field|strip_id}[${$table}->{$field}];?></td>
          </tr>
{elseif $format eq 'select-from-array' or $format eq 'radio-from-array' or $format eq 'checkbox-from-array'}
          <tr>
            <th width="100px;" scope="row">{$comments[$field]|default:$field}：</th>
            <td><?php echo isset(${$field}[${$table}->{$field}]) ? ${$field}[${$table}->{$field}] : '未分配';?></td>
          </tr>
{elseif $format eq 'switch'}
          <tr>
            <th width="100px;" scope="row">{$comments[$field]|default:$field}：</th>
            <td><?php echo ${$field}[${$table}->{$field}];?></td>
          </tr>
{elseif $format eq 'enabled'}
          <tr>
            <th width="100px;" scope="row">{$comments[$field]|default:$field}：</th>
            <td><?php echo ${$field}[${$table}->{$field}];?></td>
          </tr>
{elseif $format eq 'image' or $format eq 'gallery'}
          <tr>
            <th width="100px;" scope="row">{$comments[$field]|default:$field}：</th>
            <td><?php if (${$table}->{$field}):?><a href="/<?php echo ${$table}->{$field};?>" target="_blank"><img width="24" height="24" src="/<?php echo ${$table}->{$field};?>"></a><?php endif;?></td>
          </tr>
{elseif $format eq 'attach'}
          <tr>
            <th width="100px;" scope="row">{$comments[$field]|default:$field}：</th>
            <td><?php if (${$table}->{$field}):?><a href="/<?php echo ${$table}->{$field};?>" target="_blank">下载</a><?php endif;?></td>
          </tr>
{elseif $format eq 'addtime'}
          <tr>
            <th width="100px;" scope="row">{$comments[$field]|default:$field}：</th>
            <td><?php echo date('Y-m-d H:i:s', ${$table}->{$field});?></td>
          </tr>
{elseif $format eq 'hidden'}
{elseif $format eq 'seo_title' or $format eq 'seo_keywords' or $format eq 'seo_description'}
{elseif $format eq 'position'}
          <tr>
            <th width="100px;" scope="row">区域：</th>
            <td><?php echo qd_position({foreach name=seek from=$position item=format key=field}${$table}->{$field}{if not $smarty.foreach.seek.last}, {/if}
{/foreach});?></td>
          </tr>
{else}
          <tr>
            <th width="100px;" scope="row">{$comments[$field]|default:$field}：</th>
            <td><?php echo ${$table}->{$field};?></td>
          </tr>
{/if}
{/foreach}
        </table>
{if $seo}
<?php if (! empty($seo)):?>
        <h3 class="cut-off"><span>SEO设置</span><?php if (qd_func_auth('edit', $auth['{$table}'], 'edit')): ?><a href="<?php echo base_url('{$table}/seo/'.${$table}->id)?>">编辑</a><?php endif;?></h3>
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
{/if}
{if $gallery}
<?php if (! empty($gallery)):?>
        <h3 class="cut-off"><span>SEO设置</span><?php if (qd_func_auth('edit', $auth['{$table}'], 'edit')): ?><a href="<?php echo base_url('{$table}/seo/'.${$table}->id)?>">编辑</a><?php endif;?></h3>
        <table class="col-list" width="100%" border="1" cellspacing="0" cellpadding="0">
{foreach from=$gallery item=format key=field}
          <tr>
            <th width="100px;" scope="row">{$comments[$field]|default:$field}：</th>
            <td>
<?php foreach($gallery as $val):?>
              <a href="/<?php echo $val->image;?>" target="_blank"><img width="24" height="24" src="/<?php echo $val->image;?>"></a>
<?php endforeach;?>
            </td>
          </tr>
{/foreach}
        </table>
<?php endif;?>
{/if}
      </div>
    </div>
  </div>
</div>
</body>
</html>