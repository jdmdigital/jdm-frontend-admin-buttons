<?php 
/**
 * Plugin Name: JDM Frontend Admin Buttons
 * Plugin URI: https://github.com/jdmdigital/jdm-frontend-admin-buttons/
 * Description: JDM Frontend Admin Buttons is a lightweight WordPress plugin that hides the default Admin Bar and replaces it with out of the way, contextually-aware, floating buttons for basic admin tasks.
 * Version: 0.6
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
		//wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' );
		if(is_user_logged_in() && current_user_can('edit_pages') ) {
			wp_enqueue_style(  'jdm-fab', plugin_dir_url( __FILE__ ) . 'css/jdm-fab.css' );
			wp_enqueue_script( 'jdm-fab', plugin_dir_url( __FILE__ ) . 'js/jdm-fab.js', array( 'jquery' ), '', true );
		}
	}
}

/* Disable the Admin Bar. */
add_filter( 'show_admin_bar', '__return_false' );
function yoast_hide_admin_bar_settings() {
?>
	<style type="text/css">
		.show-admin-bar {
			display: none;
		}
	</style>
<?php
}
function yoast_disable_admin_bar() {
    add_filter( 'show_admin_bar', '__return_false' );
    add_action( 'admin_print_scripts-profile.php', 'yoast_hide_admin_bar_settings' );
}
add_action( 'init', 'yoast_disable_admin_bar' , 9 );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// If Visual Composer Plugin is active, return the edit front-page link.
if(!function_exists('jdm_edit_with_vc')) {
	function jdm_edit_with_vc(){
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
			return '<a href="'.$vcEditlink.'" class="btn btn-block btn-primary"><span class="glyphicon glyphicon-fullscreen"></span> Visual Editor</a>';
		}
		
	}
}

// == Display the HTML structure ==
if(!function_exists('jdmfab_show_admin_buttons')) {
	add_action( 'wp_footer', 'jdmfab_show_admin_buttons', 5 );
	
	function jdmfab_show_admin_buttons() {
		if( current_user_can('edit_others_pages') ) { 
			$adminurl = get_admin_url();
			
			$html  = '<div id="fab-admin-btns" class="jdm-fab">';
			$html .= '	<div class="admin-btns-wrapper">';
			
			// Several If/else statements here to make sure these look good.
			$html .= '		<button id="hide-admin-buttons" type="button" class="btn btn-block btn-default"><span class="glyphicon glyphicon-eye-close"></span> Hide Btns</button>';
			
			if(is_page()) {
			$html .= '		<a href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="glyphicon glyphicon-edit"></span> Edit Page</a>';
			} elseif(is_front_page() || is_home()) {
			$html .= '		<a href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="glyphicon glyphicon-edit"></span> Edit Home</a>';
			} elseif(is_single()) {
			$html .= '		<a href="'. get_edit_post_link().'" class="btn btn-block btn-info"><span class="glyphicon glyphicon-edit"></span> Edit Post</a>';
			} elseif(is_category()) {
			$catid = get_query_var('cat');
			$html .= '		<a href="'.$adminurl.'edit-tags.php?action=edit&taxonomy=category&tag_ID='.$catid.'&post_type=post" class="btn btn-block btn-info"><span class="glyphicon glyphicon-edit"></span> Edit Category</a>';
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
			
			echo $html;
		}
	}
}


