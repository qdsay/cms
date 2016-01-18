(function($) {
	// 插件的定义    
	$.fn.tips = function(options) {
		debug(this);
		var offset = $(this).offset();
		var defaults = {
			width: $(this).width(),
			height: $(this).height(),
			top: offset.top - 33,
			left: offset.left
		};
		// build main options before element iteration
		var opts = $.extend(defaults, options);
		window.console.log(opts.top);
		window.console.log(opts.left);
		var tips = $('<div class="qd-tips"><span class="qd-tips-arrow"></span></div>');
		$.dom = {
			title: $('<span class="qd-tips-title">'+opts.title+'</span>'),
			close: $('<a class="qd-tips-close">×</a>')
		};
		tips.prepend($.dom.close);
		if (opts.title) tips.prepend($.dom.title);

		if ($(".qd-tips").length) $(".qd-tips").remove();
		$("body").append(tips);

		$(".qd-tips").css({
			width: opts.width,
			height: opts.height,
			top: opts.top,
			left: opts.left
		});

		$(".qd-tips").show();

		$.dom.close.click(function(){
			$(".qd-tips").remove();
		});
	};
	// 私有函数：debugging
	function debug($obj) {
		if (window.console && window.console.log)
			window.console.log('tips selection count: ' + $obj.size());
	};
	// 闭包结束
})(jQuery);