document.addEventListener("DOMContentLoaded", function () {
	'use strict';

	// Get the elements using vanilla JavaScript
	const htmlElement = document.querySelector('html');
	const fabAdminBtns = document.getElementById('fab-admin-btns');
	const adminBtnsWrapper = document.querySelectorAll('.admin-btns-wrapper a');
	const jdmFab = document.querySelector('.jdm-fab');
	const hasHoverLinks = document.querySelectorAll('.has-hover a');
	const adminBtnsWrapperDiv = document.querySelector('.admin-btns-wrapper');
	const hideAdminButtons = document.getElementById('hide-admin-buttons');

	// Can we use jQuery for cool animations? 
	const canUseJquery = false;
	if (typeof jQuery === "function") {
		const canUseJquery = true;
	}

	if (canUseJquery) {
		if (jQuery('html').hasClass('no-js')) {
			jQuery('html').removeClass('no-js').addClass('js');
		}
	} else {
		if (htmlElement.classList.contains('no-js')) {
			htmlElement.classList.remove('no-js');
			htmlElement.classList.add('js');
		}
	}

	// Function to handle touchstart on 'html'
	htmlElement.addEventListener("touchstart", function () {
		if (jdmFab.classList.contains('has-hover')) {
			jdmFab.classList.remove('has-hover');
		}
	});

	// Click event on 'fab-admin-btns'
	fabAdminBtns.addEventListener('click', function (evt) {
		evt.stopPropagation();
	});

	// Function to handle touchstart on 'admin-btns-wrapper a'
	adminBtnsWrapper.forEach(function (link) {
		link.addEventListener("touchstart", function (evt) {
			if (jdmFab.classList.contains('has-hover')) {
				return true;
			} else {
				jdmFab.classList.add('has-hover');
				//evt.preventDefault();
				return false; // consistent return points
			}
		}, { passive: true });
	});

	// Click event on links with class 'has-hover' inside 'admin-btns-wrapper'
	hasHoverLinks.forEach(function (link) {
		link.addEventListener('click', function (evt) {
			if (jdmFab.classList.contains('has-hover')) {
				return true;
			} else {
				jdmFab.classList.add('has-hover');
				evt.preventDefault();
				return false; // consistent return points
			}
		});
	});

	// Hover event on 'admin-btns-wrapper'
	adminBtnsWrapperDiv.addEventListener('mouseenter', function () {
		jdmFab.classList.add('has-hover');
	});
	adminBtnsWrapperDiv.addEventListener('mouseleave', function () {
		jdmFab.classList.remove('has-hover');
	});

	// Click event on 'hide-admin-buttons'
	hideAdminButtons.addEventListener('click', function () {
		if (jdmFab.classList.contains('has-hover')) {
			jdmFab.classList.remove('has-hover');
		}
		if (canUseJquery) {
			jQuery('#fab-admin-btns').fadeOut();
		} else {
			fabAdminBtns.remove();
		}
	});
});

// We all set? 
window.addEventListener('load', function () {
	const fabAdminBtns = document.getElementById('fab-admin-btns');
	fabAdminBtns.classList.remove('not-ready');
});