<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_var['site']; ?> - 后台管理</title>
<link href="<?php echo '<?php'; ?>
 echo base_url('css/style.css')<?php echo '?>'; ?>
" rel="stylesheet" type="text/css" />
<link href="<?php echo '<?php'; ?>
 echo base_url('css/center.css')<?php echo '?>'; ?>
" rel="stylesheet" type="text/css" />
<script src="<?php echo '<?php'; ?>
 echo base_url('js/jquery.min.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<script src="<?php echo '<?php'; ?>
 echo base_url('js/jquery.validate.min.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<?php if ($this->_var['catalog']): ?>
<script src="<?php echo '<?php'; ?>
 echo base_url('js/jquery.qd.catalog.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<?php endif; ?>
<?php if ($this->_var['date']): ?>
<link href="<?php echo '<?php'; ?>
 echo base_url('css/jquery/jquery.ui.core.css')<?php echo '?>'; ?>
" rel="stylesheet" type="text/css" />
<link href="<?php echo '<?php'; ?>
 echo base_url('css/jquery/jquery.ui.theme.css')<?php echo '?>'; ?>
" rel="stylesheet" type="text/css" />
<link href="<?php echo '<?php'; ?>
 echo base_url('css/jquery/jquery.ui.datepicker.css')<?php echo '?>'; ?>
" rel="stylesheet" type="text/css" />
<script src="<?php echo '<?php'; ?>
 echo base_url('js/jquery.ui.core.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<script src="<?php echo '<?php'; ?>
 echo base_url('js/jquery.ui.datepicker.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<script src="<?php echo '<?php'; ?>
 echo base_url('js/jquery.ui.datepicker-zh-CN.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<?php endif; ?>
<?php if ($this->_var['upload']): ?>
<script src="<?php echo '<?php'; ?>
 echo base_url('js/ajaxfileupload.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<script src="<?php echo '<?php'; ?>
 echo base_url('js/jquery.qd.uploads.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<?php endif; ?>
<?php if ($this->_var['position']): ?>
<script src="<?php echo '<?php'; ?>
 echo base_url('js/jquery.qd.region.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<?php endif; ?>
<?php if ($this->_var['editor']): ?>
<script src="<?php echo '<?php'; ?>
 echo base_url('assets/editor/ueditor.config.js')<?php echo '?>'; ?>
" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo '<?php'; ?>
 echo base_url('assets/editor/ueditor.all.min.js')<?php echo '?>'; ?>
" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo '<?php'; ?>
 echo base_url('assets/editor/lang/zh-cn/zh-cn.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
<?php endif; ?>
<script src="<?php echo '<?php'; ?>
 echo base_url('js/overall.js')<?php echo '?>'; ?>
" type="text/javascript"></script>
</head>

<body>
<!--header--->
<?php echo '<?php'; ?>
 $this->load->view('header');<?php echo '?>'; ?>

<!--header end-->
<div id="wrapper">
<!--menu--->
<?php echo '<?php'; ?>
 $this->load->view('menu');<?php echo '?>'; ?>

<!--menu end-->
  <div id="main">
    <div id="crumbs">当前位置：<?php echo '<?php'; ?>
 echo $current;<?php echo '?>'; ?>
管理
      <div>
        <a class="btn" href="<?php echo '<?php'; ?>
 echo base_url('<?php echo $this->_var['table']; ?>')<?php echo '?>'; ?>
"><span>返回列表</span></a>
      </div>
    </div>
    <div id="panel">
      <div id="headbar">
        <div id="topitems">
          <ul>
<?php echo '<?php'; ?>
 foreach($items as $k => $v):<?php echo '?>'; ?>

<?php echo '<?php'; ?>
 if($k == 'edit'):<?php echo '?>'; ?>

            <li class="on">基本信息</li>
<?php echo '<?php'; ?>
 else:<?php echo '?>'; ?>

            <li><a href="<?php echo '<?php'; ?>
 echo base_url('<?php echo $this->_var['table']; ?>/'.$k.'/'.$<?php echo $this->_var['table']; ?>->id)<?php echo '?>'; ?>
"><?php echo '<?php'; ?>
 echo $v;<?php echo '?>'; ?>
</a></li>
<?php echo '<?php'; ?>
 endif;<?php echo '?>'; ?>

<?php echo '<?php'; ?>
 endforeach;<?php echo '?>'; ?>

          </ul>
        </div>
      </div>
      <div id="subpanel">
        <form action="<?php echo '<?php'; ?>
 echo base_url('<?php echo $this->_var['table']; ?>/edit/'.$<?php echo $this->_var['table']; ?>->id)<?php echo '?>'; ?>
" method="post" name="myform" id="myform">
<?php $_from = $this->_var['entry']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85381500_1453191028');if (count($_from)):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85381500_1453191028']):
?>
<?php if ($this->_var['format_0_85381500_1453191028'] == 'catalog'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label>
            <select id="<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>" default="<?php echo '<?php'; ?>
 echo qd_trace_catalog($<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>, $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>);<?php echo '?>'; ?>
">
              <option value="">选择<?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?></option>
            </select>
            <input type="hidden" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>" title="<?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>" value="<?php echo '<?php'; ?>
 echo $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>;<?php echo '?>'; ?>
" />
          </div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'select-from-db'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label>
            <select name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>">
              <option value=""><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?></option>
<?php echo '<?php'; ?>
 foreach($<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?> as $k => $v):<?php echo '?>'; ?>

              <option<?php echo '<?php'; ?>
 if($k == $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>) echo ' selected="selected"';<?php echo '?>'; ?>
 value="<?php echo '<?php'; ?>
 echo $k;<?php echo '?>'; ?>
"><?php echo '<?php'; ?>
 echo $v;<?php echo '?>'; ?>
</option>
<?php echo '<?php'; ?>
 endforeach;<?php echo '?>'; ?>

            </select>
          </div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'select-from-array'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label>
            <select name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>">
              <option value=""><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?></option>
<?php echo '<?php'; ?>
 foreach($<?php echo $this->_var['field']; ?> as $k => $v):<?php echo '?>'; ?>

              <option<?php echo '<?php'; ?>
 if($k == $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>) echo ' selected="selected"';<?php echo '?>'; ?>
 value="<?php echo '<?php'; ?>
 echo $k;<?php echo '?>'; ?>
"><?php echo '<?php'; ?>
 echo $v;<?php echo '?>'; ?>
</option>
<?php echo '<?php'; ?>
 endforeach;<?php echo '?>'; ?>

            </select>
          </div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'radio-from-db'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label>
<?php echo '<?php'; ?>
 foreach($<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?> as $k => $v):<?php echo '?>'; ?>

            <span class="item-title"><?php echo '<?php'; ?>
 echo $v;<?php echo '?>'; ?>
： <input type="radio" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>"<?php echo '<?php'; ?>
 if($k == $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>) echo ' checked="checked"';<?php echo '?>'; ?>
 value="<?php echo '<?php'; ?>
 echo $k;<?php echo '?>'; ?>
" /></span>
<?php echo '<?php'; ?>
 endforeach;<?php echo '?>'; ?>

          </div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'radio-from-array'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label>
<?php echo '<?php'; ?>
 foreach($<?php echo $this->_var['field']; ?> as $k => $v):<?php echo '?>'; ?>

            <span class="item-title"><?php echo '<?php'; ?>
 echo $v;<?php echo '?>'; ?>
： <input type="radio" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>"<?php echo '<?php'; ?>
 if($k == $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>) echo ' checked="checked"';<?php echo '?>'; ?>
 value="<?php echo '<?php'; ?>
 echo $k;<?php echo '?>'; ?>
" /></span>
<?php echo '<?php'; ?>
 endforeach;<?php echo '?>'; ?>

          </div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'checkbox-from-db'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label>
<?php echo '<?php'; ?>
 foreach($<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?> as $k => $v):<?php echo '?>'; ?>

            <span class="item-title"><?php echo '<?php'; ?>
 echo $v;<?php echo '?>'; ?>
： <input type="checkbox" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>"<?php echo '<?php'; ?>
 if($k == $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>) echo ' checked="checked"';<?php echo '?>'; ?>
 value="<?php echo '<?php'; ?>
 echo $k;<?php echo '?>'; ?>
" /></span>
<?php echo '<?php'; ?>
 endforeach;<?php echo '?>'; ?>

          </div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'checkbox-from-array'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label>
<?php echo '<?php'; ?>
 foreach($<?php echo $this->_var['field']; ?> as $k => $v):<?php echo '?>'; ?>

            <span class="item-title"><?php echo '<?php'; ?>
 echo $v;<?php echo '?>'; ?>
： <input type="checkbox" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>"<?php echo '<?php'; ?>
 if($k == $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>) echo ' checked="checked"';<?php echo '?>'; ?>
 value="<?php echo '<?php'; ?>
 echo $k;<?php echo '?>'; ?>
" /></span>
<?php echo '<?php'; ?>
 endforeach;<?php echo '?>'; ?>

          </div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'switch'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label><input type="checkbox" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>" value="1"<?php echo '<?php'; ?>
 if($<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?> == 1) echo ' checked="checked"';<?php echo '?>'; ?>
/></div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'disabled'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label><input type="checkbox" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>" value="1"<?php echo '<?php'; ?>
 if($<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?> == 1) echo ' checked="checked"';<?php echo '?>'; ?>
/></div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'textarea'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label><div class="item-area"><textarea name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>" cols="45" rows="3"><?php echo '<?php'; ?>
 echo $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>;<?php echo '?>'; ?>
</textarea></div></div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'editor'): ?>
          <div class="item editor"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label><div class="item-area">
            <script name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>" type="text/plain" style="width:100%;height:300px;"><?php echo '<?php'; ?>
 echo $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>;<?php echo '?>'; ?>
</script>
          </div></div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'attach'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label><div class="item-attach">
            <input type="file" name="upload_<?php echo $this->_var['field']; ?>" id="upload_<?php echo $this->_var['field']; ?>" class="attach" readonly="readonly" />
            <input type="text" class="input-txt long" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>" />
            <input type="button" class="attach-btn" value="上传" />
<?php echo '<?php'; ?>
 if(! empty($<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>)):<?php echo '?>'; ?>

            <cite class="download"><a href="/<?php echo '<?php'; ?>
 echo $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>;<?php echo '?>'; ?>
" target="_blank">下载</a></cite>
<?php echo '<?php'; ?>
 endif;<?php echo '?>'; ?>

            </div></div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'image'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label>
            <div class="item-area">
              <div class="img-show">
<?php echo '<?php'; ?>
 if(! empty($<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>)):<?php echo '?>'; ?>

                <div class="img-view">
                  <span><img for="<?php echo $this->_var['field']; ?>" src="/<?php echo '<?php'; ?>
 echo $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>;<?php echo '?>'; ?>
"></span>
                  <div id="move-<?php echo $this->_var['field']; ?>" class="img-move"></div>
                </div>
<?php echo '<?php'; ?>
 endif;<?php echo '?>'; ?>

              </div>
              <div class="img-pick">
                <input type="file" name="upload_<?php echo $this->_var['field']; ?>" id="upload_<?php echo $this->_var['field']; ?>" unselectable="on" />
                <input type="hidden" value="<?php echo '<?php'; ?>
 echo $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>;<?php echo '?>'; ?>
" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>">
              </div>
              <div class="img-info">限<?php echo $this->_var['configs'][$this->_var['field']]; ?>M.</div>
            </div>
          </div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'text'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label><input type="text" class="input-txt long" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>" value="<?php echo '<?php'; ?>
 echo $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>;<?php echo '?>'; ?>
" /></div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'password'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label><input type="password" class="input-txt long" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>" /></div>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="re<?php echo $this->_var['field']; ?>">确认<?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label><input type="password" class="input-txt long" name="re<?php echo $this->_var['field']; ?>" id="re<?php echo $this->_var['field']; ?>" /></div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'date'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>"><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>：</label><input type="text" class="input-txt long" style="z-index:1000;position:relative;" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>" value="<?php echo '<?php'; ?>
 echo $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>;<?php echo '?>'; ?>
" /></div>
<?php elseif ($this->_var['format_0_85381500_1453191028'] == 'position'): ?>
          <div class="item"><label class="item-title<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?> mark<?php endif; ?>" for="<?php echo $this->_var['field']; ?>">区域：</label>
<?php $_from = $this->_var['position']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format']):
        $this->_foreach['seek']['iteration']++;
?>
            <select id="<?php echo $this->_var['field']; ?>" name="<?php echo $this->_var['field']; ?>" value="<?php echo '<?php'; ?>
 echo $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>;<?php echo '?>'; ?>
"<?php if (($this->_foreach['seek']['iteration'] - 1) > 0): ?> style="display:none"<?php endif; ?>><option value=""><?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?></option></select>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </div>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <div class="item"><label class="item-title" for="btn">&nbsp;</label>
<?php if ($this->_var['hidden']): ?>
<?php $_from = $this->_var['hidden']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85489700_1453191028');if (count($_from)):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85489700_1453191028']):
?>
            <input type="hidden" name="<?php echo $this->_var['field']; ?>" id="<?php echo $this->_var['field']; ?>" value="<?php echo '<?php'; ?>
 echo $<?php echo $this->_var['table']; ?>-><?php echo $this->_var['field']; ?>;<?php echo '?>'; ?>
" />
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
            <input type="submit" name="ok" id="ok" value="保存" /><a id="cancel" class="input-btn" href="<?php echo '<?php'; ?>
 echo base_url('<?php echo $this->_var['table']; ?>')<?php echo '?>'; ?>
">取消</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
var base_url = '<?php echo '<?php'; ?>
 echo base_url()<?php echo '?>'; ?>
';
$().ready(function() {
<?php if ($this->_var['catalog']): ?>

<?php $_from = $this->_var['catalog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85494100_1453191028');if (count($_from)):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85494100_1453191028']):
?>
    $( "#<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>" ).catalog(<?php echo '<?php'; ?>
 echo qd_format_catalog($<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>);<?php echo '?>'; ?>
);
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['upload']): ?>

<?php $_from = $this->_var['upload']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85497900_1453191028');if (count($_from)):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85497900_1453191028']):
?>
<?php if ($this->_var['format_0_85497900_1453191028'] == 'image'): ?>
    $("#upload_<?php echo $this->_var['field']; ?>").uploads({ctrl:'<?php echo $this->_var['table']; ?>',field:'<?php echo $this->_var['field']; ?>',preview:true});
<?php else: ?>
    $("#upload_<?php echo $this->_var['field']; ?>").uploads({ctrl:'<?php echo $this->_var['table']; ?>',field:'<?php echo $this->_var['field']; ?>'});
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php endif; ?>
<?php if ($this->_var['editor']): ?>
<?php $_from = $this->_var['editor']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85503800_1453191028');if (count($_from)):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85503800_1453191028']):
?>
    var <?php echo $this->_var['field']; ?> = UE.getEditor('<?php echo $this->_var['field']; ?>');
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php endif; ?>
<?php if ($this->_var['date']): ?>
<?php $_from = $this->_var['date']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85507100_1453191028');if (count($_from)):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85507100_1453191028']):
?>
    $( "#<?php echo $this->_var['field']; ?>" ).datepicker({
        changeMonth: true,
        changeYear: true
    }, "showAnim", "slideDown");
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php endif; ?>
<?php if ($this->_var['position']): ?>
    $.region({
<?php $_from = $this->_var['position']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85510200_1453191028');if (count($_from)):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85510200_1453191028']):
?>
<?php if ($this->_var['format_0_85510200_1453191028'] == 'position-province'): ?>
      province:$("#<?php echo $this->_var['field']; ?>")<?php elseif ($this->_var['format_0_85510200_1453191028'] == 'position-city'): ?>,
      city:$("#<?php echo $this->_var['field']; ?>")<?php elseif ($this->_var['format_0_85510200_1453191028'] == 'position-district'): ?>,
      district:$("#<?php echo $this->_var['field']; ?>")
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

    });

<?php endif; ?>
    $.validator.setDefaults({
        submitHandler: function(myform) {
<?php if ($this->_var['editor']): ?>
<?php $_from = $this->_var['editor']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85517400_1453191028');if (count($_from)):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85517400_1453191028']):
?>
            <?php echo $this->_var['field']; ?>.sync();
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
            myform.submit(); 
        }
    });
    $("#myform").validate({
        rules: {
<?php $_from = $this->_var['verify']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85519800_1453191028');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85519800_1453191028']):
        $this->_foreach['seek']['iteration']++;
?>
<?php if ($this->_var['format_0_85519800_1453191028'] == 'password'): ?>
            <?php echo $this->_var['field']; ?>: {
<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?>
                required: true,
<?php endif; ?>
                minlength: 6<?php if ($this->_var['max_lengths'] [ $this->_var['field'] ] > 0): ?>,<?php endif; ?>

<?php if ($this->_var['max_lengths'] [ $this->_var['field'] ] > 0): ?>
                maxlength: <?php echo $this->_var['max_lengths'][$this->_var['field']]; ?>

<?php endif; ?>
            },
            re<?php echo $this->_var['field']; ?>: {
<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?>
                required: true,
<?php endif; ?>
                minlength: 6,
<?php if ($this->_var['max_lengths'] [ $this->_var['field'] ] > 0): ?>
                maxlength: <?php echo $this->_var['max_lengths'][$this->_var['field']]; ?>,
<?php endif; ?>
                equalTo:"#<?php echo $this->_var['field']; ?>"
            }<?php if (! ($this->_foreach['seek']['iteration'] == $this->_foreach['seek']['total'])): ?>,<?php endif; ?>

<?php elseif ($this->_var['format_0_85519800_1453191028'] != 'attach' && $this->_var['format_0_85519800_1453191028'] != 'image' && $this->_var['format_0_85519800_1453191028'] != 'null' && $this->_var['format_0_85519800_1453191028'] != 'disabled'): ?>
            <?php echo $this->_var['field']; ?>: {
<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?>
                required: true,
<?php if ($this->_var['format_0_85519800_1453191028'] == 'catalog'): ?>
                min: 1<?php if ($this->_var['format_0_85519800_1453191028'] == 'text' || $this->_var['format_0_85519800_1453191028'] == 'textarea'): ?>,<?php endif; ?>

<?php elseif ($this->_var['format_0_85519800_1453191028'] == 'select-from-db' || $this->_var['format_0_85519800_1453191028'] == 'radio-from-db' || $this->_var['format_0_85519800_1453191028'] == 'checkbox-from-db'): ?>
                min: 1<?php if ($this->_var['format_0_85519800_1453191028'] == 'text' || $this->_var['format_0_85519800_1453191028'] == 'textarea'): ?>,<?php endif; ?>

<?php elseif (( $this->_var['format_0_85519800_1453191028'] == 'select-from-array' || $this->_var['format_0_85519800_1453191028'] == 'radio-from-array' || $this->_var['format_0_85519800_1453191028'] == 'checkbox-from-array' ) && $this->_var['integer'] [ $this->_var['field'] ]): ?>
                min: 1<?php if ($this->_var['format_0_85519800_1453191028'] == 'text' || $this->_var['format_0_85519800_1453191028'] == 'textarea'): ?>,<?php endif; ?>

<?php else: ?>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_var['format_0_85519800_1453191028'] == 'text' || $this->_var['format_0_85519800_1453191028'] == 'textarea'): ?>
                maxlength: <?php echo $this->_var['max_lengths'][$this->_var['field']]; ?>

<?php endif; ?>
            }<?php if (! ($this->_foreach['seek']['iteration'] == $this->_foreach['seek']['total'])): ?>,<?php endif; ?>

<?php elseif ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?>
            <?php echo $this->_var['field']; ?>: {
                required: true<?php if ($this->_var['format_0_85519800_1453191028'] == 'text' || $this->_var['format_0_85519800_1453191028'] == 'textarea'): ?>,<?php endif; ?>

            }<?php if (! ($this->_foreach['seek']['iteration'] == $this->_foreach['seek']['total'])): ?>,<?php endif; ?>

<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        },
        messages: {
<?php $_from = $this->_var['verify']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85565600_1453191028');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85565600_1453191028']):
        $this->_foreach['seek']['iteration']++;
?>
<?php if ($this->_var['format_0_85565600_1453191028'] == 'password'): ?>
            <?php echo $this->_var['field']; ?>: {
<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?>
                required: "<?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>不能为空。",
<?php endif; ?>
                minlength: "长度不能小于6个字符"<?php if ($this->_var['max_lengths'] [ $this->_var['field'] ] > 0): ?>,<?php endif; ?>

<?php if ($this->_var['max_lengths'] [ $this->_var['field'] ] > 0): ?>
                maxlength: "长度不能超过<?php echo $this->_var['max_lengths'][$this->_var['field']]; ?>"
<?php endif; ?>
            },
            re<?php echo $this->_var['field']; ?>: {
<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?>
                required: "<?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>不能为空。",
<?php endif; ?>
                minlength: "长度不能小于6个字符",
<?php if ($this->_var['max_lengths'] [ $this->_var['field'] ] > 0): ?>
                maxlength: "长度不能超过<?php echo $this->_var['max_lengths'][$this->_var['field']]; ?>个字符",
<?php endif; ?>
                equalTo: "确认密码与密码不一致。"
            }<?php if (! ($this->_foreach['seek']['iteration'] == $this->_foreach['seek']['total'])): ?>,<?php endif; ?>

<?php elseif ($this->_var['format_0_85565600_1453191028'] != 'attach' && $this->_var['format_0_85565600_1453191028'] != 'image' && $this->_var['format_0_85565600_1453191028'] != 'null' && $this->_var['format_0_85565600_1453191028'] != 'disabled'): ?>
            <?php echo $this->_var['field']; ?>: {
<?php if ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?>
                required: "<?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>不能为空。",
<?php if ($this->_var['format_0_85565600_1453191028'] == 'catalog'): ?>
                min: "请选择<?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>"<?php if ($this->_var['format_0_85565600_1453191028'] == 'text' || $this->_var['format_0_85565600_1453191028'] == 'textarea'): ?>,<?php endif; ?>

<?php elseif ($this->_var['format_0_85565600_1453191028'] == 'select-from-db' || $this->_var['format_0_85565600_1453191028'] == 'radio-from-db' || $this->_var['format_0_85565600_1453191028'] == 'checkbox-from-db'): ?>
                min: "请选择<?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>"<?php if ($this->_var['format_0_85565600_1453191028'] == 'text' || $this->_var['format_0_85565600_1453191028'] == 'textarea'): ?>,<?php endif; ?>

<?php elseif (( $this->_var['format_0_85565600_1453191028'] == 'select-from-array' || $this->_var['format_0_85565600_1453191028'] == 'radio-from-array' || $this->_var['format_0_85565600_1453191028'] == 'checkbox-from-array' ) && $this->_var['integer'] [ $this->_var['field'] ]): ?>
                min: "请选择<?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>"<?php if ($this->_var['format_0_85565600_1453191028'] == 'text' || $this->_var['format_0_85565600_1453191028'] == 'textarea'): ?>,<?php endif; ?>

<?php else: ?>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_var['format_0_85565600_1453191028'] == 'text' || $this->_var['format_0_85565600_1453191028'] == 'textarea'): ?>
                maxlength: "长度不能超过<?php echo $this->_var['max_lengths'][$this->_var['field']]; ?>"
<?php endif; ?>
            }<?php if (! ($this->_foreach['seek']['iteration'] == $this->_foreach['seek']['total'])): ?>,<?php endif; ?>

<?php elseif ($this->_var['null'] [ $this->_var['field'] ] == 'NO'): ?>
            <?php echo $this->_var['field']; ?>: {
                required: "<?php echo empty($this->_var['comments'][$this->_var['field']]) ? $this->_var['field'] : $this->_var['comments'][$this->_var['field']]; ?>不能为空。"<?php if ($this->_var['format_0_85565600_1453191028'] == 'text' || $this->_var['format_0_85565600_1453191028'] == 'textarea'): ?>,<?php endif; ?>

            }<?php if (! ($this->_foreach['seek']['iteration'] == $this->_foreach['seek']['total'])): ?>,<?php endif; ?>

<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        },
<?php if ($this->_var['position']): ?>
        groups: {
            position: "<?php $_from = $this->_var['position']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85618300_1453191028');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85618300_1453191028']):
        $this->_foreach['seek']['iteration']++;
?><?php echo $this->_var['field']; ?><?php if (! ($this->_foreach['seek']['iteration'] == $this->_foreach['seek']['total'])): ?> <?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>"
        },
        errorPlacement:function(error,element) {
            if (<?php $_from = $this->_var['position']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85622400_1453191028');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85622400_1453191028']):
        $this->_foreach['seek']['iteration']++;
?>element.attr("name") == "<?php echo $this->_var['field']; ?>"<?php if (! ($this->_foreach['seek']['iteration'] == $this->_foreach['seek']['total'])): ?> || <?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>) {
                error.insertAfter("#<?php $_from = $this->_var['position']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format_0_85626200_1453191028');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format_0_85626200_1453191028']):
        $this->_foreach['seek']['iteration']++;
?><?php if (($this->_foreach['seek']['iteration'] == $this->_foreach['seek']['total'])): ?><?php echo $this->_var['field']; ?><?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>");
            } else {
                error.insertAfter(element);
            }
        },
<?php endif; ?>
        success: "checked",
        focusInvalid: true,
        onkeyup: false
    });
});
</script>
</body>
</html>