// JavaScript Document
$().ready(function() {
	setLayout();
    $("#seachform").submit(function(){
        $("input[title]").each(function(){
            if($(this).attr("title") == $(this).val()){
                $(this).val("");
            }
        });
        if ($(this).children(".catalog").length > 0) {
            $(this).children(".catalog").each(function(i){
                $obj = $(this);
                if ($obj.val().length == 0) {
                    $("select[for='"+$obj.attr("id")+"']").each(function(){
                        if ($(this).children(":selected").val().length > 0) {
                            $obj.val($(this).children(":selected").val());
                        }
                    });
                }
            });
        }
        return true;
    });

    $("#checkAll").click(function(){
        if ($(this).attr("checked") == "checked") {
            $(".checkIt").attr("checked", true);
        } else {
            $(".checkIt").attr("checked", false);
        }
    });

    $(".checkIt").click(function(){
        if ($(this).attr("checked") == "checked") {
            var checked = true;
            $(".checkIt").each(function(i){
                if ($(this).attr("checked") != "checked") {
                    checked = false;
                }
            });
            $("#checkAll").attr("checked", checked);
        } else if ($("#checkAll").attr("checked") == "checked") {
            $("#checkAll").attr("checked", false);
        }
    });

    $(".switchIt").click(function(){
        var obj = $(this);
        var open = ['否','是'];
        var rev = (parseInt(obj.attr('status')) == 0) ? 1 : 0;
        $.get(base_url+"/open/"+obj.attr('id'), {field:obj.attr("name"),open:rev}, function(msg){
            if(msg == 'success'){
                obj.attr('status', rev);
                obj.text(open[rev]);
            } else {
                alert('更新失败');
            }
        });
    });

    $(".setEnabled").click(function(){
        var obj = $(this);
        var use = ['禁用','启用'];
        var rev = (parseInt(obj.attr('status')) == 0) ? 1 : 0;
        $.get(base_url+"/enabled/"+obj.attr('id'), {enabled:rev}, function(msg){
            if(msg == 'success'){
                obj.attr('status', rev);
                obj.text(use[rev]);
            } else {
                alert('更新失败');
            }
        });
    });

    $(".delIt").click(function(){
        var obj = $(this);
        if(confirm('确认删除'+obj.attr('title'))){
            $.get(base_url+"/del/"+obj.attr("id"), function(msg){
                if(msg == 'success'){
                    $("tr[id='"+obj.attr("id")+"']").remove();
                    if ($(".checkIt").length == 0) {
                        window.location.href=window.location.href;
                    }
                } else {
                    alert('删除失败');
                }
            });
        }
    });

    $("#delChecked").click(function(){
        var checked = $(".checkIt:checked");
        if (checked.length > 0) {
            if(confirm("确定要删除选中项吗？")) {
                $.post(base_url+"/batchdel", checked.serializeArray(), function(msg){
                    if(msg == 'success'){
                        checked.each(function(){
                            $("tr[id='"+$(this).val()+"']").remove();
                        });
                        if ($(".checkIt").length == 0) {
                            window.location.href=window.location.href;
                        }
                    } else {
                        alert('删除失败');
                    }
                });
            }
        } else {
            alert("请选择删除项。");
            return false;
        }
    });
});

function setLayout(){
    doLayout();
    $(window).resize(function() {
        doLayout();
    });
}

function doLayout(){
    $("#wrapper").width($(window).width() - 20);
    $("#main").width($("#wrapper").width() - 176);
    $("#wrapper").css("height", $(document).height() - 90);
}