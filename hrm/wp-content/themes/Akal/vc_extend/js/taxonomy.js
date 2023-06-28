// JavaScript Document
!function($) {
  _.extend(vc.atts, { 
	 taxonomy:{
		     
			  parse:function (param) {
				
				  var arr = [],
					  new_value = '';
				  $('input[name=' + param.param_name + ']', this.content()).each(function (index) {
					  var self = $(this);
					  if (self.is(':checked')) {
						  arr.push(self.attr("value"));
					  }
				  });
				  if (arr.length > 0) {
					  new_value = arr.join(',');
				  }
				  return new_value;
			  }
		  }
	 });
}(window.jQuery);