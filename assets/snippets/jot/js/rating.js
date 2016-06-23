(function($) {
	jQuery(document).ready(function() {
		$(document).delegate(".jot-vote a","click",function(event) {
			var $this=$(this);
			event.preventDefault();
			$.get($this.attr("href"),function(data){
				$this.parent().find(".jot-rating").text(data);
			});
		});
	});
})(jQuery);