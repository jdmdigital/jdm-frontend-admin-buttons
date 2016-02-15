<?php 
/**
 * Plugin Name: JDM Frontend Admin Buttons
 * Plugin URI: https://github.com/jdmdigital/jdm-frontend-admin-buttons/
 * Description: JDM Frontend Admin Buttons is a lightweight WordPress plugin that hides the default Admin Bar and replaces it with out of the way, contextually-aware, floating buttons for basic admin tasks.
 * Version: 0.5
 * Author: JDM Digital
 * Author URI: http://jdmdigital.co
 * License: GPLv2 or later
 * GitHub Plugin URI: https://github.com/jdmdigital/jdm-frontend-admin-buttons/
 * GitHub Branch: master
 */

define( 'FAB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

include( FAB_PLUGIN_PATH . 'fab-settings.php');
include( FAB_PLUGIN_PATH . 'fab-functions.php');



// == Enqueue Resources (CSS and JS) ==
if(!function_exists('jdmfab_enqueued_assets')) {
	add_action( 'wp_enqueue_scripts', 'jdmfab_enqueued_assets' );
	function jdmfab_enqueued_assets() {
		//wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' );
		wp_enqueue_style(  'jdm-fab', FAB_PLUGIN_PATH . 'css/jdm-fab.css' );
		wp_enqueue_script( 'jdm-fab', FAB_PLUGIN_PATH . '/js/jdm-fab.js', array( 'jquery' ), '', true );
	}
}

// == Display the HTML structure ==
if(!function_exists('jdmfab_show_admin_buttons')) {
	add_action( 'wp_footer', 'jdmfab_show_admin_buttons' );
	
	function jdmfab_show_admin_buttons() {
		if(is_user_logged_in() && current_user_can('edit_pages') ) { 
			$html  = '<div id="fab-admin-btns">';
			$html .= '	<div class="admin-btns-wrapper">';
			
			// Several If/else statements here to make sure these look good.
			$html .= '		<button id="hide-admin-buttons" type="button" class="btn btn-block btn-default"><span class="glyphicon glyphicon-eye-close"></span> Hide Btns</button>';
			
			if(is_page()) {
			$html .= '		<a href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="glyphicon glyphicon-edit"></span> Edit Page</a>';
			} elseif(is_front_page()) {
			$html .= '		<a href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="glyphicon glyphicon-edit"></span> Edit Home</a>';
			} elseif(is_single()) {
			$html .= '		<a href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="glyphicon glyphicon-edit"></span> Edit Post</a>';
			} elseif(is_category()) {
			$html .= '		<a href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="glyphicon glyphicon-edit"></span> Edit Category</a>';
			} else {
			$html .= '		<a href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="glyphicon glyphicon-edit"></span> Edit This</a>';
			}
			
			if(is_plugin_active('js_composer/js_composer.php')) {
			$html .= '		'.jdm_edit_with_vc();
			}
			
			$html .= '		<a href="'. network_admin_url().'" class="btn btn-block btn-primary"><span class="glyphicon glyphicon-cog"></span> WP Admin</a>';
			$html .= '		<a href="'. wp_logout_url( get_permalink() ).'" class="btn btn-block btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>';
			
			$html .= '	</div>';
			$html .= '</div>';
		}
	}
}

?>
