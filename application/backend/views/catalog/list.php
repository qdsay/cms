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
var base_url ='<?php echo base_url('catalog')?>';
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
    <div id="crumbs">当前位置：分类目录管理</div>
    <div id="panel">
      <div id="headbar">
        <div id="topitems">
          <ul>
<?php if(!empty($type)):?>
<?php foreach($type as $k=>$v):?>
            <li<?php if (isset($where['type']) && $where['type'] == $k) echo ' class="on"';?>>
              <a href="<?php echo base_url('catalog/pages')?>/<?php echo $k;?>"><?php echo $v;?></a>
            </li>
<?php endforeach;?>
<?php endif;?>
          </ul>
        </div>
      </div>
      <div id="subpanel">
        <form action="<?php echo base_url('catalog/save/'.$where['type'])?>" method="post" name="myform" id="myform">
<?php if (! empty($list)): ?>
<?php foreach($list as $k=>$row):?>
          <div id="<?php echo $row['id']?>" class="item data" fid="<?php echo $row['father_id']?>" grade="<?php echo $row['grade']?>">
<?php if ($row['grade'] > 0): ?>
            <span class="child grade_<?php echo $row['grade']?>"></span>
<?php endif;?>
            <input type="text" class="input-txt mini sort" name="sort[<?php echo $row['id']?>]" value="<?php echo $row['sort']?>" />
            <span class="with"><?php echo $row['name'];?></span>
            <div class="do">
              <a href="<?php echo base_url('catalog/edit/'.$where['type'].'/'.$row['id'])?>">编辑</a>
            </div>
          </div>
<?php endforeach;?>
<?php endif;?>
          <div class="item" grade="0">
            <input type="submit" name="ok" id="ok" value="保存" />
            <a class="plus new" href="javascript:void(0)">添加分类</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var base_url ='<?php echo base_url()?>';
$().ready(function() {

    $(".data").live('mouseenter', function(){
        var obj = $(this);
        var plus = $('<a class="plus" href="javascript:void(0)">添加子分类</a>');
        var minus = $('<a class="minus" href="javascript:void(0)">移除</a>');
        if ($(this).find(".with").length > 0 && parseInt(obj.attr("grade")) < 2) {
            obj.append(plus);
        }
        if ($("div[fid="+$(this).attr("id")+"]").length == 0) {
            obj.append(minus);
        }
    }).live('mouseleave', function(){
        if ($(this).children(".plus").length > 0) $(this).children(".plus").remove();
        if ($(this).children(".minus").length > 0) $(this).children(".minus").remove();
    });

    var i = 0;
    $(".plus").live("click", function(){
        var sort = 0;
        var item = $(this).parent();
        var grade = parseInt(item.attr("grade"));
        if ($(this).hasClass("new")) { //新建一级分类
            item.prevAll().each(function(){
                if (parseInt($(this).attr("grade")) == grade) {
                    sort = parseInt($(this).children(".sort").val()) + 1;
                    return false;
                }
            });
            item.before('<div class="item data" grade="0"><input type="hidden" name="grade[k'+i+']" value="0"><input type="hidden" name="fid[k'+i+']" value="0"><input type="text" class="input-txt mini sort" name="sort[k'+i+']" value="'+sort+'" /> <input type="text" class="input-txt normal" name="name[k'+i+']" /></div>');
        } else { //新建子类
            grade = grade + 1;
            var fid = item.attr("id");
            item.nextAll().each(function(){
                var cur = parseInt($(this).attr("grade"));
                if (cur < grade) {
                    if (item.children(".minus").length > 0) item.children(".minus").remove();
                    var prev = parseInt($(this).prev().attr("grade"));
                    sort = (prev == grade) ? parseInt($(this).prev().children(".sort").val()) + 1 : 0;
                    $(this).before('<div class="item data" grade="'+grade+'"><span class="child grade_'+grade+'"></span><input type="hidden" name="grade[k'+i+']" value="'+grade+'"><input type="hidden" name="fid[k'+i+']" value="'+fid+'"><input type="text" class="input-txt mini sort" name="sort[k'+i+']" value="'+sort+'" /> <input type="text" class="input-txt normal" name="name[k'+i+']" /></div>');
                    return false;
                }
            });
        }
        i++;
    });

    $(".minus").live("click", function(){
        var item = $(this).parent();
        if (item.find(".with").length > 0) {
            $.post("<?php echo base_url('catalog/del/'.$where['type'])?>", {id: item.attr("id")}, function(data){
                if (data.status == "success") {
                    item.remove();
                } else {
                    alert(data.error)
                }
            });
        } else {
            item.remove();
        }
    });

});
</script>
</body>
</html>