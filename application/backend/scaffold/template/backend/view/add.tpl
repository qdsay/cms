<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$site} - 后台管理</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/center.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.validate.min.js')?>" type="text/javascript"></script>
{if $catalog}
<script src="<?php echo base_url('js/jquery.qd.catalog.js')?>" type="text/javascript"></script>
{/if}
{if $date}
<link href="<?php echo base_url('css/jquery/jquery.ui.core.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/jquery/jquery.ui.theme.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/jquery/jquery.ui.datepicker.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.ui.core.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.ui.datepicker.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.ui.datepicker-zh-CN.js')?>" type="text/javascript"></script>
{/if}
{if $upload}
<script src="<?php echo base_url('js/ajaxfileupload.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.qd.uploads.js')?>" type="text/javascript"></script>
{/if}
{if $position}
<script src="<?php echo base_url('js/jquery.qd.region.js')?>" type="text/javascript"></script>
{/if}
{if $editor}
<script src="<?php echo base_url('assets/editor/ueditor.config.js')?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url('assets/editor/ueditor.all.min.js')?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url('assets/editor/lang/zh-cn/zh-cn.js')?>" type="text/javascript"></script>
{/if}
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
      <div id="headbar">
        <div id="topitems">
          <ul>
<?php foreach($items as $k => $v):?>
<?php if($k == 'edit'):?>
            <li class="on"><?php echo $v;?></li>
<?php else:?>
            <li class="step">&gt;</li><li><?php echo $v;?></li>
<?php endif;?>
<?php endforeach;?>
          </ul>
        </div>
      </div>
      <div id="subpanel">
        <form action="<?php echo base_url('{$table}/add')?>" method="post" name="myform" id="myform">
{foreach from=$entry item=format key=field}
{if $format eq 'catalog'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label>
            <select id="{$field|strip_id}" default="">
              <option value="">选择{$comments[$field]|default:$field}</option>
            </select>
            <input type="hidden" name="{$field}" id="{$field}" title="{$comments[$field]|default:$field}" value="" />
          </div>
{elseif $format eq 'select-from-db'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label>
            <select name="{$field}" id="{$field}">
              <option value="">{$comments[$field]|default:$field}</option>
<?php foreach(${$field|strip_id} as $k => $v):?>
              <option value="<?php echo $k;?>"><?php echo $v;?></option>
<?php endforeach;?>
            </select>
          </div>
{elseif $format eq 'select-from-array'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label>
            <select name="{$field}" id="{$field}">
              <option value="">{$comments[$field]|default:$field}</option>
<?php foreach(${$field} as $k => $v):?>
              <option value="<?php echo $k;?>"><?php echo $v;?></option>
<?php endforeach;?>
            </select>
          </div>
{elseif $format eq 'radio-from-db'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label>
<?php foreach(${$field|strip_id} as $k => $v):?>
            <span class="item-span"><?php echo $v;?>： <input type="radio" name="{$field}" id="{$field}" value="<?php echo $k;?>" /></span>
<?php endforeach;?>
          </div>
{elseif $format eq 'radio-from-array'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label>
<?php foreach(${$field} as $k => $v):?>
            <span class="item-span"><?php echo $v;?>： <input type="radio" name="{$field}" id="{$field}" value="<?php echo $k;?>" /></span>
<?php endforeach;?>
          </div>
{elseif $format eq 'checkbox-from-db'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label>
<?php foreach(${$field|strip_id} as $k => $v):?>
            <span class="item-span"><?php echo $v;?>： <input type="checkbox" name="{$field}" id="{$field}" value="<?php echo $k;?>" /></span>
<?php endforeach;?>
          </div>
{elseif $format eq 'checkbox-from-array'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label>
<?php foreach(${$field} as $k => $v):?>
            <span class="item-span"><?php echo $v;?>： <input type="checkbox" name="{$field}" id="{$field}" value="<?php echo $k;?>" /></span>
<?php endforeach;?>
          </div>
{elseif $format eq 'switch'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label><input type="checkbox" name="{$field}" id="{$field}" value="1" /></div>
{elseif $format eq 'disabled'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label><input type="checkbox" name="{$field}" id="{$field}" value="1" /></div>
{elseif $format eq 'textarea'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label><div class="item-area"><textarea name="{$field}" id="{$field}" cols="45" rows="3"></textarea></div></div>
{elseif $format eq 'editor'}
          <div class="item editor"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label><div class="item-area">
            <script name="{$field}" id="{$field}" type="text/plain" style="width:100%;height:300px;"></script>
          </div></div>
{elseif $format eq 'attach'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label><div class="item-attach">
            <input type="file" name="upload_{$field}" id="upload_{$field}" class="attach" readonly="readonly" />
            <input type="text" class="input-txt long" name="{$field}" id="{$field}" />
            <input type="button" class="attach-btn" value="上传" />
          </div></div>
{elseif $format eq 'image'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label>
            <div class="item-area">
              <div class="img-show"></div>
              <div class="img-pick">
                <input type="file" name="upload_{$field}" id="upload_{$field}" unselectable="on" />
                <input type="hidden" name="{$field}" id="{$field}" value="" />
              </div>
              <div class="img-info">限{$configs[$field]}M.</div>
            </div>
          </div>
{elseif $format eq 'text'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label><input type="text" class="input-txt long" name="{$field}" id="{$field}" /></div>
{elseif $format eq 'password'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label><input type="password" class="input-txt long" name="{$field}" id="{$field}" /></div>
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="re{$field}">确认{$comments[$field]|default:$field}：</label><input type="password" class="input-txt long" name="re{$field}" id="re{$field}" /></div>
{elseif $format eq 'date'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">{$comments[$field]|default:$field}：</label><input type="text" class="input-txt long" style="z-index:1000;position:relative;" name="{$field}" id="{$field}" /></div>
{elseif $format eq 'position'}
          <div class="item"><label class="item-title{if $null[$field] eq 'NO'} mark{/if}" for="{$field}">区域：</label>
{foreach name=seek from=$position item=format key=field}
            <select id="{$field}" name="{$field}"{if $smarty.foreach.seek.index > 0} style="display:none"{/if}><option value="">{$comments[$field]|default:$field}</option></select>
{/foreach}
          </div>
{/if}
{/foreach}
          <div class="item"><label class="item-title" for="btn">&nbsp;</label>
{if $hidden}
{foreach from=$hidden item=format key=field}
            <input type="hidden" name="{$field}" id="{$field}" value="" />
{/foreach}
{/if}
            <input type="submit" name="ok" id="ok" value="保存" /><a id="cancel" class="input-btn" href="<?php echo base_url('{$table}')?>">取消</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
var base_url = '<?php echo base_url()?>';
$().ready(function() {
{if $catalog}

{foreach from=$catalog item=format key=field}
    $( "#{$field|strip_id}" ).catalog(<?php echo qd_format_catalog(${$field|strip_id});?>);
{/foreach}
{/if}
{if $upload}

{foreach from=$upload item=format key=field}
{if $format eq 'image'}
    $("#upload_{$field}").uploads({ctrl:'{$table}',field:'{$field}',preview:true});
{else}
    $("#upload_{$field}").uploads({ctrl:'{$table}',field:'{$field}'});
{/if}
{/foreach}

{/if}
{if $editor}
{foreach from=$editor item=format key=field}
    var {$field} = UE.getEditor('{$field}');
{/foreach}

{/if}
{if $date}
{foreach from=$date item=format key=field}
    $( "#{$field}" ).datepicker({
        changeMonth: true,
        changeYear: true
    }, "showAnim", "slideDown");
{/foreach}

{/if}
{if $position}
    $.region({
{foreach from=$position item=format key=field}
{if $format eq 'position-province'}
      province:$("#{$field}"){elseif $format eq 'position-city'},
      city:$("#{$field}"){elseif $format eq 'position-district'},
      district:$("#{$field}")
{/if}
{/foreach}

    });

{/if}
    $.validator.setDefaults({
        submitHandler: function(myform) {
{if $editor}
{foreach from=$editor item=format key=field}
            {$field}.sync();
{/foreach}
{/if}
            myform.submit(); 
        }
    });
    $("#myform").validate({
        rules: {
{foreach name=seek from=$verify item=format key=field}
{if $format eq 'password'}
            {$field}: {
{if $null[$field] eq 'NO'}
                required: true,
{/if}
                minlength: 6,
{if $max_lengths[$field] gt 0}
                maxlength: {$max_lengths[$field]}

{/if}
            },
            re{$field}: {
{if $null[$field] eq 'NO'}
                required: true,
{/if}
                minlength: 6,
{if $max_lengths[$field] gt 0}
                maxlength: {$max_lengths[$field]},
{/if}
                equalTo:"#{$field}"
            }{if not $smarty.foreach.seek.last},{/if}

{elseif $format neq 'attach' and $format neq 'image' and $format neq 'null' and $format neq 'disabled' and $format neq 'editor'}
            {$field}: {
{if $null[$field] eq 'NO'}
                required: true,
{if $format eq 'catalog'}
                min: 1{if $format eq 'text' or $format eq 'textarea'},{/if}

{elseif $format eq 'select-from-db' or $format eq 'radio-from-db' or $format eq 'checkbox-from-db'}
                min: 1{if $format eq 'text' or $format eq 'textarea'},{/if}

{elseif ($format eq 'select-from-array' or $format eq 'radio-from-array' or $format eq 'checkbox-from-array') and $integer[$field]}
                min: 1{if $format eq 'text' or $format eq 'textarea'},{/if}

{else}
{/if}
{/if}
{if $format eq 'text' or $format eq 'textarea'}
                maxlength: {$max_lengths[$field]}

{/if}
            }{if not $smarty.foreach.seek.last},{/if}

{elseif $null[$field] eq 'NO'}
            {$field}: {
                required: true{if $format eq 'text' or $format eq 'textarea'},{/if}

            }{if not $smarty.foreach.seek.last},{/if}

{/if}
{/foreach}
        },
        messages: {
{foreach name=seek from=$verify item=format key=field}
{if $format eq 'password'}
            {$field}: {
{if $null[$field] eq 'NO'}
                required: "{$comments[$field]|default:$field}不能为空。",
{/if}
                minlength: "{$comments[$field]|default:$field}不能小于6个字符。"{if $max_lengths[$field] gt 0},{/if}

{if $max_lengths[$field] gt 0}
                maxlength: "{$comments[$field]|default:$field}不能超过{$max_lengths[$field]}个字符。"
{/if}
            },
            re{$field}: {
{if $null[$field] eq 'NO'}
                required: "确认{$comments[$field]|default:$field}不能为空。",
{/if}
                minlength: "确认{$comments[$field]|default:$field}不能小于6个字符。",
{if $max_lengths[$field] gt 0}
                maxlength: "确认{$comments[$field]|default:$field}不能超过{$max_lengths[$field]}个字符。",
{/if}
                equalTo: "确认{$comments[$field]|default:$field}与{$comments[$field]|default:$field}不一致。"
            }{if not $smarty.foreach.seek.last},{/if}

{elseif $format neq 'attach' and $format neq 'image' and $format neq 'null' and $format neq 'disabled' and $format neq 'editor'}
            {$field}: {
{if $null[$field] eq 'NO'}
                required: "{$comments[$field]|default:$field}不能为空。",
{if $format eq 'catalog'}
                min: "请选择{$comments[$field]|default:$field}"{if $format eq 'text' or $format eq 'textarea'},{/if}

{elseif $format eq 'select-from-db' or $format eq 'radio-from-db' or $format eq 'checkbox-from-db'}
                min: "请选择{$comments[$field]|default:$field}"{if $format eq 'text' or $format eq 'textarea'},{/if}

{elseif ($format eq 'select-from-array' or $format eq 'radio-from-array' or $format eq 'checkbox-from-array') and $integer[$field]}
                min: "请选择{$comments[$field]|default:$field}"{if $format eq 'text' or $format eq 'textarea'},{/if}

{else}
{/if}
{/if}
{if $format eq 'text' or $format eq 'textarea'}
                maxlength: "{$comments[$field]|default:$field}不能超过{$max_lengths[$field]}个字符。"
{/if}
            }{if not $smarty.foreach.seek.last},{/if}

{elseif $null[$field] eq 'NO'}
            {$field}: {
                required: "{$comments[$field]|default:$field}不能为空。"{if $format eq 'text' or $format eq 'textarea'},{/if}

            }{if not $smarty.foreach.seek.last},{/if}

{/if}
{/foreach}
        },
{if $position}
        groups: {
            position: "{foreach name=seek from=$position item=format key=field}{$field}{if not $smarty.foreach.seek.last} {/if}{/foreach}"
        },
        errorPlacement:function(error,element) {
            if ({foreach name=seek from=$position item=format key=field}element.attr("name") == "{$field}"{if not $smarty.foreach.seek.last} || {/if}{/foreach}) {
                error.insertAfter("#{foreach name=seek from=$position item=format key=field}{if $smarty.foreach.seek.last}{$field}{/if}{/foreach}");
            } else {
                error.insertAfter(element);
            }
        },
{/if}
        success: "checked",
        focusInvalid: true,
        onkeyup: false
    });
});
</script>
</body>
</html>