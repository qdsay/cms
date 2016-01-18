<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>勤道CMS - 后台管理</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/center.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/ajaxfileupload.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.qd.gallery.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.dragsort.min.js')?>" type="text/javascript"></script>
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
        <a class="btn" href="<?php echo base_url($caller)?>"><span>返回列表</span></a>
      </div>
    </div>
    <div id="panel">
      <div id="headbar">
        <div id="topitems">
          <ul>
<?php foreach($items as $k => $v):?>
<?php if($k == 'gallery'):?>
            <li class="on"><?php echo $v;?></li>
<?php else:?>
            <li><a href="<?php echo base_url($caller.'/'.$k.'/'.$caller_id)?>"><?php echo $v;?></a></li>
<?php endif;?>
<?php endforeach;?>
          </ul>
        </div>
      </div>
      <div id="subpanel">
        <form action="<?php echo base_url($caller.'/gallery/'.$caller_id.'/save')?>" method="post" name="myform" id="myform">
          <div class="clear">
            <ul id="gallery">
<?php if (! empty($gallery)): ?>
<?php foreach($gallery as $k => $row):?>
              <li>
                <div class="gallery-view"><span><img src="/<?php echo $row->image;?>"></span></div>
                <div class="gallery-info"><input type="hidden" ref="ids" name="ids[<?php echo $k;?>]" value="<?php echo $row->id;?>" /><input type="hidden" ref="images" name="images[<?php echo $k;?>]" value="<?php echo $row->image;?>" /><textarea name="info[<?php echo $k;?>]" rows="3" cols="45"><?php echo $row->info;?></textarea></div>
                <div class="gallery-move"></div>
              </li>
<?php endforeach;?>
<?php endif;?>
            </ul>
          </div>
          <div class="clear">
            <div class="gallery-upload">
              <div class="img-pick"><input type="file" name="upload_image" id="upload_image" unselectable="on" /></div>
              <div class="img-info">限2M图片.</div>
            </div>
          </div>
          <div class="clear hr" grade="0">
            <div class="gallery-action">
              <input type="submit" name="ok" id="ok" value="保存" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
var base_url = '<?php echo base_url()?>';
$().ready(function() {
    $("#upload_image").gallery({ctrl:'<?php echo $caller;?>',field:'image'});
});
</script>
</body>
</html>