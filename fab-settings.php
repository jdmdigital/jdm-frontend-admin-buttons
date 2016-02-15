<?php
// == Plugin Settings ==
add_action('admin_menu', 'jdmfab_plugin_menu');
function jdmfab_plugin_menu() {
	add_menu_page('Admin Button Settings', 'FAB Settings', 'administrator', 'jdmfab-settings', 'jdmfab_plugin_settings_page', 'dashicons-admin-generic');
}


function jdmfab_plugin_settings_page() {
	// Settings Page
	?>
	<div id="fab-settings" class="wrap">
		<h2>Frontend Admin Button (FAB) Settings <a class="add-new-h2" href="https://github.com/jdmdigital/jdm-frontend-admin-buttons/" target="_blank">View Help Wiki</a></h2>
		<form id="fab-settings-form" method="post" action="options.php">
			<?php settings_fields( 'jdmfab-plugin-settings-group' ); ?>
			<?php do_settings_sections( 'jdmfab-plugin-settings-group' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Display Option</th>
        			<td><input type="text" class="regular-text" name="display_option" value="<?php echo esc_attr( get_option('display_option') ); ?>" /></td>
        		</tr>

				<tr valign="top">
					<th scope="row">Optimization Option</th>
					<td><input type="text" class="regular-text" name="optimization_option" value="<?php echo esc_attr( get_option('optimization_option') ); ?>" /></td>
				</tr>

				<tr valign="top">
					<th scope="row">Other Option</th>
					<td><input type="text" class="regular-text" name="other_option" value="<?php echo esc_attr( get_option('other_option') ); ?>" /></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
 <?php
}

add_action( 'admin_init', 'jdmfab_plugin_settings' );
function jdmfab_plugin_settings() {
	register_setting( 'jdmfab-plugin-settings-group', 'display_option' );
	register_setting( 'jdmfab-plugin-settings-group', 'optimization_option' );
	register_setting( 'jdmfab-plugin-settings-group', 'other_option' );
}
?>
