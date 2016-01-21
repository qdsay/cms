<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CI - 脚手架</title>
<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/center.css')?>" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
html {font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666666;overflow:auto;}
}
-->
</style>
<script src="<?php echo base_url('js/jquery.min.js')?>" type="text/javascript"></script>
</head>

<body>
<div id="crumbs">当前位置：脚手架 > 生成</div>
<div id="panel">
<div id="headbar">
  <div  id="topsearch">
    <select name="tables" id="tables">
      <option value="0">选择数据库表</option>
<?php foreach($tables as $k=>$v):?>
<?php if (!in_array($v, array('qd_admin', 'qd_groups', 'qd_gallery', 'qd_catalog', 'qd_region'))): ?>
      <option value="<?php echo $v;?>"><?php echo $v;?></option>
<?php endif; ?>
<?php endforeach;?>
    </select>
  </div>
</div>
<?php if (isset($fields)): ?>
<div id="subpanel">
  <form id="myform" name="myform" method="post" action="scaffold">
    <table class="row-list" width="100%" border="0" cellspacing="2" cellpadding="1">
      <thead>
        <tr>
          <th width="8%" scope="col">列名</th>
          <th width="8%" scope="col">类型</th>
          <th width="8%" scope="col">默认</th>
          <th width="8%" scope="col">长度</th>
          <th width="8%" scope="col">主键</th>
          <th width="8%" scope="col">对象<input type="checkbox" name="getAll" id="getAll" /></th>
          <th width="8%" scope="col">列表<input type="checkbox" name="listAll" id="listAll" /></th>
          <th width="8%" scope="col">排序<input type="checkbox" name="sortAll" id="sortAll" /></th>
          <th width="8%" scope="col">选项<input type="checkbox" name="allAll" id="allAll" /></th>
          <th width="8%" scope="col">搜索<input type="checkbox" name="whereAll" id="whereAll" /></th>
          <th width="10%" scope="col">输入</th>
          <th width="10%" scope="col">SEO</th>
        </tr>
      </thead>
      <tbody>
<?php foreach($fields as $row):?>
        <tr>
          <td><?php echo $row['name'];?></td>
          <td><?php echo $row['type'];if ($row['type'] == 'enum') echo '<input class="items" id="items_'.$row['name'].'" type="hidden" value="'.$row['items'].'">';?></td>
          <td><?php echo empty($row['default']) ? 'null' : $row['default'];?></td>
          <td><?php echo $row['max_length'];?></td>
          <td><?php echo $key[$row['primary_key']];?></td>
          <td><input name="get[<?php echo $row['name'];?>]" type="checkbox" class="get" id="get_<?php echo $row['name'];?>" value="<?php echo $row['type'];?>"<?php if(array_key_exists($row['name'], $get)) echo ' checked="checked"';?> /></td>
          <td><input name="list[<?php echo $row['name'];?>]" type="checkbox" class="list" id="list_<?php echo $row['name'];?>" value="<?php echo $row['type'];?>"<?php if(array_key_exists($row['name'], $list)) echo ' checked="checked"';?> /></td>
          <td><input name="sort[<?php echo $row['name'];?>]" type="checkbox" class="sort" id="sort_<?php echo $row['name'];?>" value="<?php echo $row['type'];?>"<?php if(array_key_exists($row['name'], $sort)) echo ' checked="checked"';?> /></td>
          <td><input name="all[<?php echo $row['name'];?>]" type="checkbox" class="all" id="all_<?php echo $row['name'];?>" value="<?php echo $row['type'];?>"<?php if(array_key_exists($row['name'], $all)) echo ' checked="checked"';?> /></td>
          <td><input name="where[<?php echo $row['name'];?>]" type="checkbox" class="where" id="where_<?php echo $row['name'];?>" value="<?php echo $row['type'];?>"<?php if(array_key_exists($row['name'], $where)) echo ' checked="checked"';?> /></td>
          <td><select name="entry[<?php echo $row['name'];?>]" class="entry" id="entry_<?php echo $row['name'];?>" for="<?php echo $row['name'];?>">
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'null') echo ' selected="selected"';?> value="null">Null</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'text') echo ' selected="selected"';?> value="text">Text</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'password') echo ' selected="selected"';?> value="password">Password</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'textarea') echo ' selected="selected"';?> value="textarea">TextArea</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'catalog') echo ' selected="selected"';?> value="catalog">Catalog</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'select-from-db') echo ' selected="selected"';?> value="select-from-db">Select-From-DB</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'select-from-array') echo ' selected="selected"';?> value="select-from-array">Select-From-Array</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'radio-from-db') echo ' selected="selected"';?> value="radio-from-db">Radio-From-DB</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'radio-from-array') echo ' selected="selected"';?> value="radio-from-array">Radio-From-Array</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'checkbox-from-db') echo ' selected="selected"';?> value="checkbox-from-db">CheckBox-From-DB</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'checkbox-from-array') echo ' selected="selected"';?> value="checkbox-from-array">CheckBox-From-Array</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'switch') echo ' selected="selected"';?> value="switch">Switch</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'hidden') echo ' selected="selected"';?> value="hidden">Hidden</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'attach') echo ' selected="selected"';?> value="attach">Attach</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'image') echo ' selected="selected"';?> value="image">Image</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'gallery') echo ' selected="selected"';?> value="gallery">Gallery</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'editor') echo ' selected="selected"';?> value="editor">Editor</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'date') echo ' selected="selected"';?> value="date">Date</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'position-province') echo ' selected="selected"';?> value="position-province">Position-Province</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'position-city') echo ' selected="selected"';?> value="position-city">Position-City</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'position-district') echo ' selected="selected"';?> value="position-district">Position-District</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'enabled') echo ' selected="selected"';?> value="enabled">Enabled</option>
            <option<?php if(array_key_exists($row['name'], $entry) && $entry[$row['name']] == 'addtime') echo ' selected="selected"';?> value="addtime">AddTime</option>
          </select></td>
          <td><select name="seo[<?php echo $row['name'];?>]" class="seo" id="seo_<?php echo $row['name'];?>" for="<?php echo $row['name'];?>">
            <option value="">请选择</option>
            <option<?php if(array_key_exists($row['name'], $seo) && $seo[$row['name']] == 'title') echo ' selected="selected"';?> value="title">Title</option>
            <option<?php if(array_key_exists($row['name'], $seo) && $seo[$row['name']] == 'keywords') echo ' selected="selected"';?> value="keywords">Keywords</option>
            <option<?php if(array_key_exists($row['name'], $seo) && $seo[$row['name']] == 'description') echo ' selected="selected"';?> value="description">Description</option>
          </select></td>
        </tr>
<?php endforeach;?>
      </tbody>
    </table>
    <div class="clear"></div>
<?php if (isset($array)): ?>
<?php foreach($array as $k => $v):?>
<?php if (array_key_exists($k, $fields)): ?>
    <div class="item" for="<?php echo $k;?>">
      <label class="item-title"><?php echo ucfirst($k);?>：</label>
      <input class="input-txt larg" type="text" value="<?php echo $v;?>" name="array[<?php echo $k;?>]">
      <label>Integer Key ：</label>
      <input id="integer" type="checkbox" value="1"<?php if (isset($integer) && array_key_exists($k, $integer) && $integer[$k] == 1): ?> checked="checked"<?php endif; ?> name="integer[<?php echo $k;?>]">
    </div>
<?php endif; ?>
<?php endforeach;?>
<?php endif; ?>
  </form>
</div>
<div id="footbar">
  <div id="action">
    <input class="input-btn" type="submit" name="model" id="model" value="生成模型" />
    <input class="input-btn" type="submit" name="ctrl" id="ctrl" value="生成控制器" />
    <input class="input-btn" type="submit" name="view" id="view" value="生成视图" />
    <input class="input-btn" type="submit" name="sync" id="sync" value="部署到前端" />
    <a id="clear" href="javascript:void(0)">清除</a>
  </div>
</div>
<?php endif; ?>
<?php if (in_array(false, $writeable)): ?>
<div class="clear"></div>
<div id="writeable">
<?php foreach($writeable as $path => $val):?>
<?php if ($val === false): ?>
<p>Warning: <?php echo $path;?> is un writeable</p>
<?php endif; ?>
<?php endforeach;?>
</div>
<?php endif; ?>
<div class="clear"></div>
<div id="result"></div>
</div>
<script language="javascript" type="text/javascript">
var base_url ='<?php echo base_url()?>';
$().ready(function() {
    var table = "<?php echo $table;?>";
    $("#tables > option").each(function(){
        if($(this).val() == table){
            $(this).attr("selected", true);
        }
    });
    $("#tables").change(function(){
        document.location.href = "scaffold?table="+$(this).val();
    });
    $("#model").click(function(){
        //$("#myform").submit();
        $.post(base_url+"scaffold/model/"+table, $("#myform").serializeArray(), function(data){
            $("#result").append("make model:<a href=\"/"+table+"\" target=\"_blank\">"+data.file+"</a> " + data.msg + "<br />");
        }, "json");
    });
    $("#ctrl").click(function(){
        //$("#myform").submit();
        $.post(base_url+"scaffold/ctrl/"+table, $("#myform").serializeArray(), function(data){
            $("#result").append("make ctrl:<a href=\"/"+table+"\" target=\"_blank\">"+data.file+"</a> " + data.msg + "<br />");
        }, "json");
    });
    $("#view").click(function(){
        //$("#myform").submit();
        $.post(base_url+"scaffold/view/"+table, $("#myform").serializeArray(), function(data){
            $.each( data, function(i, n){
                if (typeof(n.file)=='undefined') {
                    $("#result").append("field "+i+":" + n.msg + "<br />");
                } else {
                    $("#result").append("make view:<a href=\"/"+table+"\" target=\"_blank\">"+n.file+"</a> " + n.msg + "<br />");
                }
            });
        }, "json");
    });
    $("#sync").click(function(){
        $.post(base_url+"scaffold/model/"+table+"?sync=frontend", $("#myform").serializeArray(), function(data){
            $("#result").append("make model:<a href=\"/"+table+"\" target=\"_blank\">"+data.file+"</a> " + data.msg + "<br />");
        }, "json");
        $.post(base_url+"scaffold/ctrl/"+table+"?sync=frontend", $("#myform").serializeArray(), function(data){
            $("#result").append("make ctrl:<a href=\"/"+table+"\" target=\"_blank\">"+data.file+"</a> " + data.msg + "<br />");
        }, "json");
        $.post(base_url+"scaffold/view/"+table+"?sync=frontend", $("#myform").serializeArray(), function(data){
            $.each( data, function(i, n){
                if (typeof(n.file)=='undefined') {
                    $("#result").append("field "+i+":" + n.msg + "<br />");
                } else {
                    $("#result").append("make view:<a href=\"/"+table+"\" target=\"_blank\">"+n.file+"</a> " + n.msg + "<br />");
                }
            });
        }, "json");
    });
    $(".entry").change(function(){
        var field = $(this).attr("for");
        if ($(this).val() == "select-from-array" || $(this).val() == "radio-from-array" || $(this).val() == "checkbox-from-array" || $(this).val() == "switch") {
            if ($(".item[for='"+field+"']").length == 0) {
                var value = '';
                if ($("#get_"+field).val() == 'enum') {
                    value = $("#items_"+field).val();
                }
                $("#myform").append('<div class="item" for="'+field+'"><label class="item-title">'+field+'：</label><input class="input-txt larg" type="text" value="'+value+'" name="array['+field+']"><label>Integer Key ：</label><input id="integer" type="checkbox" value="1" name="integer['+field+']"></div>');
            }
        } else {
            if ($(".item[for='"+field+"']").length > 0 ) {
                $(".item[for='"+field+"']").remove();
            }
        }
    });
    $("#getAll").click(function(){
        if($(this).attr("checked") == "checked"){
            $(".get").attr("checked", true);
        } else {
            $(".get").attr("checked", false);
        }
    });
    $("#listAll").click(function(){
        if($(this).attr("checked") == "checked"){
            $(".list").attr("checked", true);
        } else {
            $(".list").attr("checked", false);
        }
    });
    $("#allAll").click(function(){
        if($(this).attr("checked") == "checked"){
            $(".all").attr("checked", true);
        } else {
            $(".all").attr("checked", false);
        }
    });
    $("#whereAll").click(function(){
        if($(this).attr("checked") == "checked"){
            $(".where").attr("checked", true);
        } else {
            $(".where").attr("checked", false);
        }
    });
    $("#entryAll").click(function(){
        if($(this).attr("checked") == "checked"){
            $(".entry").attr("checked", true);
        } else {
            $(".entry").attr("checked", false);
        }
    });
    $("#clear").click(function(){
        $("#result").empty();
    });
});
</script>
</body>
</html>
