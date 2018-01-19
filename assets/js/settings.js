jQuery(window).load(function(){

	// Multi-Subscription option
	if(jQuery('#wc_mailpoet_multi_subscription').val() == 'yes'){
		jQuery('#wc_mailpoet_checkout_label').closest('tr').hide();
	}else{
		jQuery('#wc_mailpoet_checkout_label').closest('tr').show();
	}

	// If the Multi-Subscription option was changed.
	jQuery('#wc_mailpoet_multi_subscription').on("change", function(){
		if(jQuery(this).val() == 'yes'){
			jQuery('#wc_mailpoet_checkout_label').closest('tr').hide();
		}else{
			jQuery('#wc_mailpoet_checkout_label').closest('tr').show();
		}
	});

});
