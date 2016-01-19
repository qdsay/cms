(function($) {
	// 插件的定义    
	$.fn.uploads = function(opts) {
		//debug(this);

		// build main options before element iteration
		if (opts.preview) {
			preview($(this), opts);
		} else {
			attach($(this), opts);
		}
	};
	// 私有函数：debugging
	function debug($obj) {
		if (window.console && window.console.log)
			window.console.log('uploads count: ' + $obj.size());
	};
	function preview($obj, opts) {
		var show = $obj.parent().prev();
		$obj.change(function(){
			var src = show.find(".temp").attr("src");
			var view = $('<div class="img-view"></div>');
			show.empty().append(view);
			$.ajaxFileUpload({
				url: base_url+opts.ctrl+'/upload/'+opts.field,
				secureuri: false,
				fileElementId: $obj.attr('name'),
				dataType: 'json',
				success: function (data, status) {
					if (data.status == 'success') {
						$("#"+opts.field).val(data.filename);
						$("#"+opts.field).next("label").remove();
						if (typeof(src) != 'undefined' && src.length > 0) {
							removeSrc(opts.ctrl, src);
						}
						view.html('<span><img class="temp" for="'+opts.field+'" src="/'+data.filename+'"></span><div id="move-'+opts.field+'" class="img-move"></div>');
					} else {
						alert(data.error);
					}
				},
				error: function (data, status, e) {
					alert(e);
				}
			});
		});

		show.on("click", "#move-"+opts.field, function(){
			var img = $(this).prev().children("img");
			$("#"+img.attr("for")).val("");
			if (img.hasClass("temp")) {
				removeSrc(opts.ctrl, img.attr("src"));
			}
			$(this).parent().remove();
		});
	};
	function attach($obj, opts) {
		$obj.change(function(){
			$.ajaxFileUpload({
				url: base_url+opts.ctrl+'/upload/'+opts.field,
				secureuri: false,
				fileElementId: $obj.attr('name'),
				dataType: 'json',
				success: function (data, status) {
					if (data.status == 'success') {
						$("#"+opts.field).val(data.filename);
						$("#"+opts.field).next("label").remove();
						if (typeof(src) != 'undefined' && src.length > 0) {
							removeSrc(opts.ctrl, src);
						}
					} else {
						alert(data.error);
					}
				},
				error: function (data, status, e) {
					alert(e);
				}
			});
		});
	};
	function removeSrc(ctrl, src) {
		$.get(base_url+ctrl+'/remove',{filename: src},function(data){
			if (data.status == 'fail') {
				alert(data.error);
			}
		});
	};
	// 闭包结束
})(jQuery);