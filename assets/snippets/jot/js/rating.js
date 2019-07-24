(function($) {
	jQuery(document).ready(function() {
		$(document).delegate("[data-type=vote]","click",function(event) {
			var $this=$(this);
			event.preventDefault();
			$.get($this.attr("data-href"),function(data){
				$this.parent().find("[data-type=rating]").text(data);
			});
		});
	});
})(jQuery);