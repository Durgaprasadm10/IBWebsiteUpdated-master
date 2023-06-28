// JavaScript Document
!function($) {

$('.vc-icon-option i').on('click',function(){
		 $value = $(this).data('icon');
		if( $(this).hasClass('selected')){
         $(this).removeClass('selected');
		  $(this).parent().parent().find('input.vc-icon-picker').attr('value','').trigger('change');
		}
		else {
		 $(this).parent().find(' > i').removeClass('selected');	
         $(this).addClass('selected');
         $(this).parent().parent().find('input.vc-icon-picker').attr('value',$value).trigger('change');
		}
	 });
}(window.jQuery);