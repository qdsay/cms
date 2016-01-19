<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$site} - 后台管理</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/center.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
{if $wheres and ($catalog or $position or $date)}
{foreach from=$wheres item=format key=field}
{if $catalog and $entry[$field] eq 'catalog'}
<script src="<?php echo base_url('js/jquery.qd.catalog.js')?>" type="text/javascript"></script>
{elseif $date and $entry[$field] eq 'date'}
<link href="<?php echo base_url('css/jquery/jquery.ui.core.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/jquery/jquery.ui.theme.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/jquery/jquery.ui.datepicker.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.ui.core.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.ui.datepicker.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.ui.datepicker-zh-CN.js')?>" type="text/javascript"></script>
{elseif $position and $entry[$field] eq 'position-province' or $position and $entry[$field] eq 'position-city' or $position and $entry[$field] eq 'position-district'}
<script src="<?php echo base_url('js/jquery.qd.region.js')?>" type="text/javascript"></script>
{/if}
{/foreach}
{/if}
<script src="<?php echo base_url('js/overall.js')?>" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
var base_url = '<?php echo base_url('{$table}')?>';
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
<?php if (qd_func_auth('add', $auth['{$table}'], 'edit')): ?>
      <div>
        <a class="btn" href="<?php echo base_url('{$table}/add')?>"><span>添加{$comment|default:$table}</span></a>
      </div>
<?php endif;?>
    </div>
    <div id="panel">
{if $wheres}
      <div id="headbar">
        <div id="topsearch">
          <form id="seachform" name="seachform" method="get" action="<?php echo base_url('{$table}/pages')?>">
{foreach from=$wheres item=format key=field}
{if $entry[$field] eq 'text'}
            <input name="{$field}" type="text" class="input-txt short" id="{$field}" title="{$comments[$field]|default:$field}" onfocus="javascript:if(this.value == '{$comments[$field]|default:$field}') this.value = '';" value="<?php echo empty($where['{$field}'])?'{$comments[$field]|default:$field}':$where['{$field}']?>" />
{elseif $entry[$field] eq 'catalog'}
            <select id="{$field|strip_id}" for="{$field}" default="<?php echo qd_trace_catalog(${$field|strip_id}, $where['{$field}']);?>">
              <option value="">选择{$comments[$field]|default:$field}</option>
            </select>
            <input type="hidden" name="{$field}" id="{$field}" class="catalog" title="{$comments[$field]|default:$field}" value="<?php echo $where['{$field}'];?>" />
{elseif $entry[$field] eq 'select-from-db' or $entry[$field] eq 'radio-from-db' or $entry[$field] eq 'checkbox-from-db'}
            <select name="{$field}" id="{$field}">
              <option value="">{$comments[$field]|default:$field}</option>
<?php foreach(${$field|strip_id} as $k => $v):?>
              <option<?php if(isset($where['{$field}']) && $where['{$field}'] == $k) echo ' selected="selected"'?> value="<?php echo $k;?>"><?php echo $v;?></option>
<?php endforeach;?>
            </select>
{elseif $entry[$field] eq 'select-from-array' or $entry[$field] eq 'radio-from-array' or $entry[$field] eq 'checkbox-from-array'}
            <select name="{$field}" id="{$field}">
              <option value="">{$comments[$field]|default:$field}</option>
<?php foreach(${$field} as $k => $v):?>
              <option<?php if(isset($where['{$field}']) && $where['{$field}'] == $k) echo ' selected="selected"'?> value="<?php echo $k;?>"><?php echo $v;?></option>
<?php endforeach;?>
            </select>
{elseif $entry[$field] eq 'date'}
            <input type="text" class="input-txt short" style="z-index:1000;position:relative;" name="{$field}" id="{$field}" title="{$comments[$field]|default:$field}" onfocus="javasctipt:if(this.value == '{$comments[$field]|default:$field}') this.value = '';" value="<?php echo empty($where['{$field}'])?'{$comments[$field]|default:$field}':$where['{$field}']?>" />
{elseif $entry[$field] eq 'addtime'}
            <input type="text" class="input-txt short" style="z-index:1000;position:relative;" name="{$field}" id="{$field}" title="{$comments[$field]|default:$field}" onfocus="javasctipt:if(this.value == '{$comments[$field]|default:$field}') this.value = '';" value="<?php echo empty($where['{$field}'])?'{$comments[$field]|default:$field}':$where['{$field}']?>" />
{elseif $entry[$field] eq 'position-province'}
            <select id="{$field|strip_id}_province"><option value="">省份</option></select>
            <input type="hidden" name="{$field}" id="{$field}" value="<?php echo $where['{$field}'];?>" />
{elseif $entry[$field] eq 'position-city'}
            <select id="{$field|strip_id}_province"><option value="">省份</option></select>
            <select id="{$field|strip_id}_city" style="display:none"><option value="">城市</option></select>
            <input type="hidden" name="{$field}" id="{$field}" value="<?php echo $where['{$field}'];?>" />
{elseif $entry[$field] eq 'position-district'}
            <select id="{$field|strip_id}_province"><option value="">省份</option></select>
            <select id="{$field|strip_id}_city" style="display:none"><option value="">城市</option></select>
            <select id="{$field|strip_id}_district" style="display:none"><option value="">区县</option></select>
            <input type="hidden" name="{$field}" id="{$field}" value="<?php echo $where['{$field}'];?>" />
{/if}
{/foreach}
            <button id="search" class="input-btn" type="submit">搜索</button>
          </form>
        </div>
        <div id="toppage"><?php echo $paging->tinylinks();?></div>
      </div>
{else}
      <div class="clear"></div>
{/if}
      <div id="subpanel">
        <form id="listform" name="listform" method="post" action="<?php echo base_url('{$table}/batch/del')?>">
        <table class="row-list" width="100%" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th scope="col">全选<input type="checkbox" name="checkAll" id="checkAll" /></th>
{foreach name=seek from=$lists item=format key=field}
{if $field neq 'id'}
{if $sort[$field]}
              <th scope="col"><?php echo qd_order_by('{$table}/pages', $paging->query, '{$field}', '{$comments[$field]|default:$field}')?></th>
{elseif $field eq 'position'}
              <th scope="col">区域</th>
{else}
              <th scope="col">{$comments[$field]|default:$field}</th>
{/if}
{/if}
{/foreach}
              <th scope="col">操作</th>
            </tr>
          </thead>
<?php if (empty($list)): ?>
            <tbody>
              <tr>
                <td colspan="{$col}">暂未添加{$comment|default:$table}：<a href="<?php echo base_url('{$table}/add')?>">添加</a></td>
              </tr>
            </tbody>
<?php else: ?>
          <tbody>
<?php foreach($list as $k=>$row):?>
            <tr id="<?php echo $row->id;?>">
              <td><input type="checkbox" name="{$table}[<?php echo $row->id;?>]" id="{$table}_<?php echo $row->id;?>" value="<?php echo $row->id;?>" class="checkIt" /></td>
{foreach from=$lists item=format key=key}
{if $key neq 'id'}
{if $entry[$key] eq 'catalog'}
              <td><?php echo isset(${$key|strip_id}[$row->{$key}]) ? ${$key|strip_id}[$row->{$key}]['name'] : '未分配';?></td>
{elseif $entry[$key] eq 'select-from-array' or $entry[$key] eq 'radio-from-array' or $entry[$key] eq 'checkbox-from-array'}
              <td><?php echo isset(${$key}[$row->{$key}]) ? ${$key}[$row->{$key}] : '未分配';?></td>
{elseif  $entry[$key] eq 'select-from-db' or $entry[$key] eq 'radio-from-db' or $entry[$key] eq 'checkbox-from-db'}
              <td><?php echo isset(${$key|strip_id}[$row->{$key}]) ? ${$key|strip_id}[$row->{$key}] : '未分配';?></td>
{elseif $entry[$key] eq 'switch'}
              <td><a id="<?php echo $row->id;?>" name="{$key}" class="switchIt" status="<?php echo $row->{$key};?>" href="javascript:void(0)"><?php echo ${$key}[$row->{$key}];?></a></td>
{elseif $entry[$key] eq 'enabled'}
              <td><a id="<?php echo $row->id;?>" class="setEnabled" status="<?php echo $row->{$key};?>" href="javascript:void(0)"><?php echo ${$key}[$row->{$key}];?></a></td>
{elseif $entry[$key] eq 'image' or $entry[$key] eq 'gallery'}
              <td><?php if ($row->{$key}):?><a href="/<?php echo $row->{$key};?>" target="_blank"><img width="24" height="24" src="/<?php echo $row->{$key};?>"></a><?php endif;?></td>
{elseif $entry[$key] eq 'addtime'}
              <td><?php echo date('Y-m-d', $row->{$key});?></td>
{elseif $entry[$key] eq 'timestamp'}
              <td><?php echo date('Y-m-d', strtotime($row->{$key}));?></td>
{elseif $entry[$key] eq 'position'}
              <td><?php echo qd_position({foreach name=seek from=$position item=format key=field}$row->{$field}{if not $smarty.foreach.seek.last}, {/if}{/foreach});?></td>
{else}
              <td><?php echo $row->{$key};?></td>
{/if}
{/if}
{/foreach}
              <td><a href="<?php echo base_url('{$table}/view/'.$row->{$fields[0]})?>">查看</a>
<?php if (qd_func_auth('edit', $auth['{$table}'], 'edit')): ?>
                | <a href="<?php echo base_url('{$table}/edit/'.$row->{$fields[0]})?>">编辑</a>
<?php endif;?>
<?php if (qd_func_auth('del', $auth['{$table}'], 'del')): ?>
                | <a id="<?php echo $row->{$fields[0]};?>" title="{$comment|default:$table}:<?php echo $row->{$fields[1]};?>" class="delIt" href="javascript:void(0)">删除</a>
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
{if $wheres and ($catalog or $position or $date)}
<script language="javascript" type="text/javascript">
$().ready(function() {
{if $catalog}
{foreach from=$catalog item=format key=field}
    $( "#{$field|strip_id}" ).catalog(<?php echo qd_format_catalog(${$field|strip_id});?>);
{/foreach}
{/if}
{foreach from=$wheres item=format key=field}
{if $date and $entry[$field] eq 'date'}
    $( "#{$field}" ).datepicker({
        changeMonth: true,
        changeYear: true
    }, "showAnim", "slideDown");
{elseif $position and $entry[$field] eq 'position-province'}
    $.region({province:$("#{$field|strip_id}_province")}, region:$("#{$field}"));
{elseif $position and $entry[$field] eq 'position-city'}
    $.region({province:$("#{$field|strip_id}_province"), city:$("#{$field|strip_id}_city"), region:$("#{$field}")});
{elseif $position and $entry[$field] eq 'position-district'}
    $.region({province:$("#{$field|strip_id}_province"), city:$("#{$field|strip_id}_city"), district:$("#{$field|strip_id}_district"), region:$("#{$field}")});
{/if}
{/foreach}
});
</script>
{/if}
</body>
</html>