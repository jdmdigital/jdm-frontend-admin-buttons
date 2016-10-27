<?php 
/**
 * Plugin Name: JDM Frontend Admin Buttons
 * Plugin URI: http://jdmdig.it/jdm-fab
 * Description: JDM Frontend Admin Buttons is a lightweight WordPress plugin that hides the default Admin Bar and replaces it with out of the way, contextually-aware, floating buttons for basic admin tasks.
 * Version: 1.3
 * Author: JDM Digital
 * Author URI: http://jdmdigital.co
 * License: GPLv2 or later
 * GitHub Plugin URI: https://github.com/jdmdigital/jdm-frontend-admin-buttons
 * GitHub Branch: master
 */

// == Enqueue Resources (CSS and JS) ==
if(!function_exists('jdmfab_enqueued_assets')) {
	add_action( 'wp_enqueue_scripts', 'jdmfab_enqueued_assets' );
	function jdmfab_enqueued_assets() {
		// changed in Fix #10 - if(is_user_logged_in() && current_user_can('edit_pages') ) {
		if(is_user_logged_in()) {
			wp_enqueue_style(  'jdm-fab', plugin_dir_url( __FILE__ ) . 'css/jdm-fab.css', array(), null, 'screen' );
			wp_enqueue_script( 'jdm-fab', plugin_dir_url( __FILE__ ) . 'js/jdm-fab.js', array( 'jquery' ), null, true );
		}
	}
}

/* Disable the Admin Bar. */
add_filter( 'show_admin_bar', '__return_false' );
if(!function_exists('jdm_fab_hide_admin_bar_settings')) {
	function jdm_fab_hide_admin_bar_settings() {
?>
	<style type="text/css">
		.show-admin-bar {
			display: none;
		}
	</style>
<?php
	}
}

if(!function_exists('jdm_fab_disable_admin_bar')) {
	function jdm_fab_disable_admin_bar() {
		add_filter( 'show_admin_bar', '__return_false' );
		add_action( 'admin_print_scripts-profile.php', 'jdm_fab_hide_admin_bar_settings' );
	}
	add_action( 'init', 'jdm_fab_disable_admin_bar' , 9 );
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// If Visual Composer Plugin is active, return the edit front-page link.
if(!function_exists('jdm_edit_with_vc')) {
	function jdm_edit_with_vc($icon_prefix = 'glyphicon'){
		global $page, $post;
		$id = $post->ID;
		$adminURL = admin_url();
		if(is_page()) {
			$type = 'page';
			$vc = true;
		}
		else {
			$vc = false;
		}
		
		$vcEditlink = $adminURL.'post.php?vc_action=vc_inline&amp;post_id='.$id.'&amp;post_type='.$type;
		
		if($vc) {
			return '<a id="fab-vcedit" href="'.$vcEditlink.'" class="btn btn-block btn-warning"><span class="glyphicon glyphicon-fullscreen genericon genericon-maximize fab-icon fab-brush"></span> Visual Editor</a>';
		}
		
	}
}

// == Display the HTML structure ==
if(!function_exists('jdmfab_show_admin_buttons')) {
	add_action( 'wp_footer', 'jdmfab_show_admin_buttons', 5 );
	
	function jdmfab_show_admin_buttons() {
		$bootstrapclass = true;
		if(wp_style_is('bootstrap')) {
			$fabclass = 'jdm-fab bs';
		} elseif(wp_style_is('bootstrap-css')) {
			$fabclass = 'jdm-fab bs';
		} elseif(wp_style_is('bootstrap-style')) {
			$fabclass = 'jdm-fab bs';	
		} else {
			// Bootstrap CSS not enqueued (we don't think)
			$fabclass = 'jdm-fab no-bs';
			$bootstrapclass = false;	
		}
		
		if(wp_style_is('fontawesome')) {
			$icon_prefix 	= 'fa';
			$icon_edit 		= 'fa-pencil';
			$icon_customize	= 'fa-paint-brush';
			$icon_admin 	= 'fa-cog';
			$icon_profile 	= 'fa-user';
			$icon_close 	= 'fa-eye-slash';
			$icon_logout 	= 'fa-power-off';
			$fabclass 		.= ' fontawesome';
		} elseif (wp_style_is('genericons')) {
			$fabclass 		.= ' genericons';
			$icon_prefix 	= 'genericon';
			$icon_edit 		= 'genericon-edit';
			$icon_customize	= 'genericon-maximize';
			$icon_admin 	= 'genericon-cog';
			$icon_profile 	= 'genericon-user';
			$icon_close 	= 'genericon-close';
			$icon_logout 	= 'genericon-unapprove';
		} elseif($bootstrapclass) {
			$fabclass 		.= ' glyphicons';
			$icon_prefix 	= 'glyphicon';
			$icon_edit 		= 'glyphicon-edit';
			$icon_customize	= 'glyphicon-fullscreen bp-link';
			$icon_admin 	= 'glyphicon-cog';
			$icon_profile 	= 'glyphicon-user';
			$icon_close 	= 'glyphicon-eye-close';
			$icon_logout 	= 'glyphicon-log-out';
		} else {
			$fabclass 		.= ' fab-icons';
			$icon_prefix 	= 'fab-icon';
			$icon_edit 		= 'fab-pencil-neg';
			$icon_customize	= 'fab-equalizer';
			$icon_admin 	= 'fab-cog';
			$icon_profile 	= 'fab-user';
			$icon_close 	= 'fab-eye';
			$icon_logout 	= 'fab-cw';
		}
		
		if( current_user_can('edit_others_pages') ) { 
			$adminurl = get_admin_url();
			// Admin/Super-Admin Roles
			$html  = '<div id="fab-admin-btns" class="not-ready '.$fabclass.'">';
			$html .= '	<div class="admin-btns-wrapper">';
			
			$html .= '		<button id="hide-admin-buttons" type="button" class="btn btn-block btn-default"><span class="'.$icon_prefix.' '.$icon_close.'"></span> Hide Btns</button>';
			
			if(is_page()) {
			$html .= '		<a id="fab-page" href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="'.$icon_prefix.' '.$icon_edit.'"></span> Edit Page</a>';
			} elseif(is_front_page() && !is_home()) {
			$html .= '		<a id="fab-home" href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="'.$icon_prefix.' '.$icon_edit.'"></span> Edit Home</a>';
			} elseif(is_single()) {
			$html .= '		<a id="fab-post" href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="'.$icon_prefix.' '.$icon_edit.'"></span> Edit Post</a>';
			} elseif(is_category()) {
			$catid = get_query_var('cat');
			$html .= '		<a id="fab-cat" href="'.$adminurl.'edit-tags.php?action=edit&taxonomy=category&tag_ID='.$catid.'&post_type=post" class="btn btn-block btn-info"><span class="'.$icon_prefix.' '.$icon_edit.'"></span> Edit Category</a>';
			} else {
			$html .= '		<a id="fab-else" href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="'.$icon_prefix.' '.$icon_edit.'"></span> Edit This</a>';
			}
			
			if(is_plugin_active('js_composer/js_composer.php')) {
			$html .= '		'.jdm_edit_with_vc();
			} else {
				if ( current_user_can( 'customize' ) ) {
					$html .= '		<a id="fab-customize" href="'. get_admin_url().'customize.php?return='.get_permalink().'" class="btn btn-block btn-warning"><span class="'.$icon_prefix.' '.$icon_customize.'"></span> Customize</a>';
				}
			}
			
			$html .= '		<a id="fab-wpadmin" href="'. network_admin_url().'" class="btn btn-block btn-primary"><span class="'.$icon_prefix.' '.$icon_admin.'"></span> WP Admin</a>';
			$html .= '		<a id="fab-logout" href="'. wp_logout_url( get_permalink() ).'" class="btn btn-block btn-danger"><span class="'.$icon_prefix.' '.$icon_logout.'"></span> Logout</a>';
			
			$html .= '	</div>';
			$html .= '</div>';
			
			echo $html;
		
		} elseif (current_user_can('edit_posts')) {
			// "Author" Role
			$html  = '<div id="fab-admin-btns" class="not-ready '.$fabclass.'">';
			$html .= '	<div class="admin-btns-wrapper">';
			
			$html .= '		<button id="hide-admin-buttons" type="button" class="btn btn-block btn-default"><span class="'.$icon_prefix.' '.$icon_close.'"></span> Hide Btns</button>';
			
			if(is_single()) {
			$html .= '		<a id="fab-post" href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="'.$icon_prefix.' '.$icon_edit.'"></span> Edit Post</a>';
			} else {
			$html .= '		<a id="fab-else" href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="'.$icon_prefix.' '.$icon_edit.'"></span> Edit This</a>';
			}
			
			if(is_plugin_active('js_composer/js_composer.php')) {
			$html .= '		'.jdm_edit_with_vc();
			} else {
				if ( current_user_can( 'customize' ) ) {
					$html .= '		<a id="fab-customize" href="'. get_admin_url().'customize.php?return='.get_permalink().'" class="btn btn-block btn-warning"><span class="'.$icon_prefix.' '.$icon_customize.'"></span> Customize</a>';
				}
			}
			
			$html .= '		<a id="fab-wpadmin" href="'. get_edit_user_link().'" class="btn btn-block btn-primary"><span class="'.$icon_prefix.' '.$icon_profile.'"></span> Edit Profile</a>';
			$html .= '		<a id="fab-logout" href="'. wp_logout_url( get_permalink() ).'" class="btn btn-block btn-danger"><span class="'.$icon_prefix.' '.$icon_logout.'"></span> Logout</a>';
			
			$html .= '	</div>';
			$html .= '</div>';
			
			echo $html;
		
		} elseif (current_user_can('read')) {
			// Subscriber Role
			$html  = '<div id="fab-admin-btns" class="not-ready '.$fabclass.'">';
			$html .= '	<div class="admin-btns-wrapper">';
			
			$html .= '		<button id="hide-admin-buttons" type="button" class="btn btn-block btn-default"><span class="'.$icon_prefix.' '.$icon_close.'"></span> Hide Btns</button>';
			
			$html .= '		<a id="fab-wpadmin" href="'. get_edit_user_link().'" class="btn btn-block btn-primary"><span class="'.$icon_prefix.' '.$icon_profile.'"></span> Edit Profile</a>';
			$html .= '		<a id="fab-logout" href="'. wp_logout_url( get_permalink() ).'" class="btn btn-block btn-danger"><span class="'.$icon_prefix.' '.$icon_logout.'"></span> Logout</a>';
			
			$html .= '	</div>';
			$html .= '</div>';
			
			echo $html;
		}
		
	}
}
