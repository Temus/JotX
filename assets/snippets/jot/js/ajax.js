(function($) {
	setData = function(data,id) {
		var array = data.split("|!|~|!|");
		$('#form-'+id).html(array[0]);
		$('#comments-'+id).html(array[1]);
		$('#moderate-'+id).html(array[2]);
		$('.navigation-'+id).html(array[3]);
		$('#subscribe-'+id).html(array[4]);
		$('#count-'+id).html(array[5]);
	}
	jotAjax = function(id) {
		var hist;
		$(document).delegate('.navigation-'+id+' a','click',function(event) {
			hist = $(this).attr('href');
			$.get($(this).attr('href'),'aj'+id, function(data) {setData(data,id);});
			return false;
		});
		$(document).delegate('#moderate-'+id+' a,#comments-'+id+' [data-type=mod] a','click',function(event) {
			$.get($(this).attr('href'),'aj'+id, function(data) {setData(data,id);});
			return false;
		});
		$(document).delegate('#respond-'+id+' form','submit',function(event) {
			event.preventDefault();
			//var parent = $('#comment-parent-'+id).val();
			$.post($(this).attr('action'), $(this).serialize(), function(data) {
				setData(data,id);
				//if (parent && addComment) {addComment.moveForm(id,parent);}
			});
		});
		$(document).delegate('#form-'+id+' [data-type=cancel]','click',function(event) {
			event.preventDefault();
			$.get(hist,'aj'+id, function(data) {setData(data,id);});
		});
	}
})(jQuery);