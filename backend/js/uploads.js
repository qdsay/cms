// JavaScript Document
$().ready(function() {
	$(".pic-move").live('click', function(){
		var view = $(this).parent();
		$.get(base_url+$(this).attr('name')+'/remove/',{filename: $(this).attr('for')},function(data){
			if (data.status == 'fail') {
				alert(data.error);
			}
			view.remove();
		});
	});
	$(".pic-view").dragsort({
		dragSelector: "li",
		dragEnd: saveOrder,
		dragBetween: true,
		placeHolderTemplate: "<li class='pic-holder'></li>"
	});
});
function saveOrder() {
	$(".pic-view li").each(function(i){
		var input = $(this).children("input");
		var title = input.attr('title');
		input.attr('name', title+'['+(++i)+']');
	});
};
function ajaxFileUpload(file, ctrl, field)
{
	var holder = file.parent().prev();
	var view = $('<div class="pic-view"></div>');
	var move = $('<div class="pic-move"></div>');
	holder.append(view);
    view.ajaxComplete(function(){
        	$(this).css('background', '#FAFAFA');
    	}
    );
	$.ajaxFileUpload({
		url: base_url+ctrl+'/upload/'+field,
		secureuri: false,
		fileElementId: file.attr('id'),
		dataType: 'json',
		success: function (data, status) {
			if (data.status == 'success') {
				var img = $('<img src="/'+data.filename+'">');
				var input = $('<input type="hidden" title="'+field+'" name="'+field+'['+holder.children().length+']" value="'+data.filename+'" />');

				move.attr('name', ctrl);
				move.attr('for', data.filename);

				if (data.is_image) {
					var width = height = 80;
					if (data.image_width / data.image_height > 1) {
						height = Math.ceil(data.image_height * width / data.image_width);
					} else {
						width = Math.ceil(data.image_width * height / data.image_height);
					}
					img.width(width);
					img.height(height);
				}

				view.append(img.wrap('<span></span>')).append(move).append(input);
			} else {
				alert(data.error);
			}
		},
		error: function (data, status, e) {
			alert(e);
		}
	});
	return false;
}

// function ajaxFileUpload(ctrl, image)
// {
// 	$("#"+image).next().html('<img width="20" height="20" src="'+base_url+'/images/loading.gif" />');
// 	$.ajaxFileUpload({
// 		url: base_url+ctrl+'/upload/'+image,
// 		secureuri: false,
// 		fileElementId: 'upload_'+image,
// 		dataType: 'json',
// 		success: function (data, status) {
// 			console.log(data);
// 			console.log(status);
// 			if (data.status == 'success') {
// 				$('#'+image).next().html('<a href="/'+data.image+'" target="_blank">查看</a>');
// 				$('#'+image).val(data.image);
// 			} else {
// 				alert(data.error);
// 			}
// 		},
// 		error: function (data, status, e) {
// 			alert(e);
// 		}
// 	});
// 	return false;
// }