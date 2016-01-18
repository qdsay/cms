(function($) {
	// 插件的定义    
	$.fn.gallery = function(opts) {
		debug(this);

		// build main options before element iteration
		var show = $("#gallery");

		$(this).live('change', function(){
			$.ajaxFileUpload({
				url: base_url+opts.ctrl+'/upload/'+opts.field,
				secureuri: false,
				fileElementId: $(this).attr('name'),
				dataType: 'json',
				success: function (data, status) {
					if (data.status == 'success') {
						show.append('<li><div class="gallery-view"><span><img class="temp" src="/'+data.filename+'"></span></div><div class="gallery-info"><input type="hidden" ref="images" name="images['+show.children().length+']" value="'+data.filename+'" /><textarea name="info['+show.children().length+']" rows="3" cols="45">'+data.origname+'</textarea></div><div class="gallery-move"></div></li>');
						$("#wrapper").css("height", $(document).height() - 90);
					} else {
						alert(data.error);
					}
				},
				error: function (data, status, e) {
					alert(e);
				}
			});
		});

		$(".gallery-move").live('click', function(){
			var img = $(this).prevAll(".gallery-view").find("img");
			if (img.hasClass("temp")) {
				removeImg(opts.ctrl, img.attr("src"));
			}
			$(this).parent().remove();
			saveOrder();
		});

		$("#gallery").dragsort({
			dragSelector: "li",
			dragEnd: saveOrder,
			dragBetween: true,
			placeHolderTemplate: "<li class='gallery-holder'></li>"
		});
	};
	// 私有函数：debugging
	function debug($obj) {
		if (window.console && window.console.log)
			window.console.log('uploads count: ' + $obj.size());
	};
	//删除图片
	function removeImg(ctrl, src) {
		$.get(base_url+ctrl+'/remove',{filename: src},function(data){
			if (data.status == 'fail') alert(data.error);
		});
	};
	//保存排序
	function saveOrder() {
		$("#gallery li").each(function(i){
			$(this).find("input[ref='ids']").attr('name', 'ids['+i+']');
			$(this).find("input[ref='images']").attr('name', 'images['+i+']');
			$(this).find("textarea").attr('name', 'info['+i+']');
		});
	};
	// 闭包结束
})(jQuery);