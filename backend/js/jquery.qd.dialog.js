(function($) {
	var top = 0;
	var left = 0;
	var defaults = {
		width: '240',
		height: '120',
		top: top,
		left: left,
		okTxt: '确定',
		cancelTxt: '取消',
		overlay: true
	};
	$.dailog = {
		open: function(options){
			var opts = $.extend({},defaults, options);
			var curs = ($(window).height() - opts.height)/2;
			top = curs + $(document).scrollTop();
			left = ($(window).width() - opts.width)/2;
			var overlay = $('<div class="qd_overlay"></div>');
			if (opts.overlay) {
				if ($(".qd_overlay").length > 0) {
					$(".qd_overlay").fadeTo("fast", 0.66);
				} else {
					$("body").append(overlay);
					overlay.css("height", $(document).height());
					overlay.fadeTo("fast", 0.66);
				}
			}

			var dialog = $('<div class="qd_dialog"></div>');
			if ($(".qd_dialog").length) $(".qd_dialog").remove();

			var head = $('<div class="qd_head"></div>');
			var foot = $('<div class="qd_foot"></div>');
			$.dom = {
				title: (opts.title == undefined) ? null : $('<div class="qd_title">'+opts.title+'</div>'),
				content: (typeof opts.content == 'string') ? $('<div class="qd_title">'+opts.content+'</div>') : opts.content,
				okBtn: (opts.ok == undefined) ? null : $('<button type="button">'+opts.okTxt+'</button>'),
				cancelBtn: (opts.cancel == undefined) ? null : $('<button type="button" class="cancel">'+opts.cancelTxt+'</button>'),
				closeBtn: $('<div class="qd_close"></div>')
			};
			dialog.append(head);
			if ($.dom.title) head.append($.dom.title);
			head.append($.dom.closeBtn);
			$.dom.closeBtn.click(function(){
				$.dailog.destroy();
			});
			if ($.dom.content) {
				dialog.append($.dom.content);
				$.dom.content.show();
			}
			if ($.dom.okBtn) {
				foot.append($.dom.okBtn);
				$.dom.okBtn.click(function(){
					if (opts.ok()) {
						$.dailog.destroy();
					}
				});
			}
			if ($.dom.cancelBtn) {
				foot.append($.dom.cancelBtn);
				$.dom.cancelBtn.click(function(){
					if (opts.cancel()) {
						$.dailog.destroy();
					}
				});
			}
			if (foot.has('button')) {
				dialog.append(foot);
			}
			$("body").append(dialog);
			$(".qd_dialog").css({
				width: opts.width,
				height: opts.height,
				top: top,
				left: left
			});
			$(".qd_dialog").show();
			$(window).scroll( function() {
				$(".qd_dialog").css("top", curs + $(document).scrollTop());
			} );
		},
		destroy: function(){
			$(".qd_dialog").hide();
			$(".qd_overlay").fadeOut("fast");
		}
	};
})(jQuery);