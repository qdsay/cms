<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>勤道CMS - 后台管理</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/center.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.validate.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.qd.catalog.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/ajaxfileupload.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.qd.uploads.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/editor/ueditor.config.js')?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url('assets/editor/ueditor.all.min.js')?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url('assets/editor/lang/zh-cn/zh-cn.js')?>" type="text/javascript"></script>
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
      <div id="headbar">
        <div id="topitems">
          <ul>
<?php foreach($items as $k => $v):?>
<?php if($k == 'edit'):?>
            <li class="on">基本信息</li>
<?php else:?>
            <li><a href="<?php echo base_url('article/'.$k.'/'.$article->id)?>"><?php echo $v;?></a></li>
<?php endif;?>
<?php endforeach;?>
          </ul>
        </div>
      </div>
      <div id="subpanel">
        <form action="<?php echo base_url('article/edit/'.$article->id)?>" method="post" name="myform" id="myform">
          <div class="item"><label class="item-title mark" for="title">标题：</label><input type="text" class="input-txt long" name="title" id="title" value="<?php echo $article->title;?>" /></div>
          <div class="item"><label class="item-title mark" for="catalog_id">分类：</label>
            <select id="catalog" default="<?php echo qd_trace_catalog($catalog, $article->catalog_id);?>">
              <option value="">选择分类</option>
            </select>
            <input type="hidden" name="catalog_id" id="catalog_id" title="分类" value="<?php echo $article->catalog_id;?>" />
          </div>
          <div class="item"><label class="item-title" for="image">文章配图：</label>
            <div class="item-area">
              <div class="img-show">
<?php if(! empty($article->image)):?>
                <div class="img-view">
                  <span><img for="image" src="/<?php echo $article->image;?>"></span>
                  <div class="img-move"></div>
                </div>
<?php endif;?>
              </div>
              <div class="img-pick">
                <input type="file" name="upload_image" id="upload_image" unselectable="on" />
                <input type="hidden" value="<?php echo $article->image;?>" name="image" id="image">
              </div>
              <div class="img-info">限2M.</div>
            </div>
          </div>
          <div class="item"><label class="item-title mark" for="tags">标签：</label><input type="text" class="input-txt long" name="tags" id="tags" value="<?php echo $article->tags;?>" /></div>
          <div class="item"><label class="item-title mark" for="summary">摘要：</label><div class="item-area"><textarea name="summary" id="summary" cols="45" rows="3"><?php echo $article->summary;?></textarea></div></div>
          <div class="item editor"><label class="item-title" for="contents">内容：</label><div class="item-area">
            <script name="contents" id="contents" type="text/plain" style="width:100%;height:300px;"><?php echo $article->contents;?></script>
          </div></div>
          <div class="item"><label class="item-title" for="author">作者：</label><input type="text" class="input-txt long" name="author" id="author" value="<?php echo $article->author;?>" /></div>
          <div class="item"><label class="item-title" for="origin">信息来源：</label><input type="text" class="input-txt long" name="origin" id="origin" value="<?php echo $article->origin;?>" /></div>
          <div class="item"><label class="item-title" for="level">推荐级别：</label>
            <select name="level" id="level">
              <option value="">推荐级别</option>
<?php foreach($level as $k => $v):?>
              <option<?php if($k == $article->level) echo ' selected="selected"';?> value="<?php echo $k;?>"><?php echo $v;?></option>
<?php endforeach;?>
            </select>
          </div>
          <div class="item"><label class="item-title mark" for="disabled">是否启用：</label><input type="checkbox" name="disabled" id="disabled" value="1"<?php if($article->disabled == 1) echo ' checked="checked"';?>/></div>
          <div class="item"><label class="item-title" for="btn">&nbsp;</label>
            <input type="submit" name="ok" id="ok" value="保存" /><a id="cancel" class="input-btn" href="<?php echo base_url('article')?>">取消</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
var base_url = '<?php echo base_url()?>';
$().ready(function() {

    $( "#catalog" ).catalog(<?php echo qd_format_catalog($catalog);?>);

    $("#upload_image").uploads({ctrl:'article',field:'image',preview:true});

    var contents = UE.getEditor('contents');

    $.validator.setDefaults({
        submitHandler: function(myform) {
            contents.sync();
            myform.submit(); 
        }
    });
    $("#myform").validate({
        rules: {
            title: {
                required: true,
                maxlength: 128
            },
            catalog_id: {
                required: true,
                min: 1
            },
            tags: {
                required: true,
                maxlength: 255
            },
            summary: {
                required: true,
                maxlength: 255
            },
            contents: {
            },
            author: {
                maxlength: 32
            },
            origin: {
                maxlength: 64
            }
        },
        messages: {
            title: {
                required: "标题不能为空。",
                maxlength: "长度不能超过128"
            },
            catalog_id: {
                required: "分类不能为空。",
                min: "请选择分类"
            },
            tags: {
                required: "标签不能为空。",
                maxlength: "长度不能超过255"
            },
            summary: {
                required: "摘要不能为空。",
                maxlength: "长度不能超过255"
            },
            contents: {
            },
            author: {
                maxlength: "长度不能超过32"
            },
            origin: {
                maxlength: "长度不能超过64"
            }
        },
        success: "checked",
        focusInvalid: true,
        onkeyup: false
    });
});
</script>
</body>
</html>