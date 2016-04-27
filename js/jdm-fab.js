jQuery( document ).ready(function() {
	'use strict';
	jQuery('html').on("touchstart", function() {
		if(jQuery('.jdm-fab').hasClass('has-hover')) {
			jQuery('.jdm-fab').removeClass('has-hover');
		}
	});
	
	jQuery('#fab-admin-btns').click(function(evt){
		evt.stopPropagation();
	});
	
	jQuery('.admin-btns-wrapper a').on("touchstart", function (evt) {		
		if (jQuery('.jdm-fab').hasClass('has-hover')) {
			return true;
			jQuery('.jdm-fab').removeClass('has-hover');
		} else {
			jQuery('.jdm-fab').addClass('has-hover');
			evt.preventDefault();
			return false; //consistent return points
		}
	});
	
	jQuery('.has-hover a').click( function (evt) {		
		if (jQuery('.jdm-fab').hasClass('has-hover')) {
			return true;
		} else {
			jQuery('.jdm-fab').addClass('has-hover');
			evt.preventDefault();
			return false; //consistent return points
		}
	});
	
	jQuery('.admin-btns-wrapper').hover(function() {
			// mouseenter
			jQuery('.jdm-fab').addClass('has-hover');
		}, 
		function() {
			// mouseexit
			jQuery('.jdm-fab').removeClass('has-hover');
		}
	);
	
	jQuery('#hide-admin-buttons').click(function() {
		if (jQuery('.jdm-fab').hasClass('has-hover')) {
			jQuery('.jdm-fab').removeClass('has-hover');
			//jQuery('#fab-admin-btns').fadeOut();
		} else {
			jQuery('#fab-admin-btns').fadeOut();
		}
	});
	
	
});

jQuery( window ).load(function() {
	jQuery('#fab-admin-btns').removeClass('not-ready');
});