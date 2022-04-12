<?php
/*
Plugin Name: Custom Network Site Info Field
Plugin URI: https://github.com/jvarn/custom-network-site-info-field
Description: Adds a custom field to the network site info page wp-admin/network/site-info.php
Version: 1.0.0
Author: Jeremy Varnham
Author URI: https://abuyasmeen.com/
*/

// Prevent Direct Access
if ( ! defined( 'ABSPATH' ) ) { die; }

function jlv_custom_network_site_info_form() {
	
	submit_button( 'Save Changes', 'primary', 'primary-save', true, "" ); 
	echo "</form>"; // Close form in site-info.php

	$blogid = isset( $_REQUEST['id'] ) ? (int) $_REQUEST['id'] : 0;	
	$meta_key = 'blog_custom_label';
		
	$saved_custom_label = get_site_meta( $blogid, $meta_key, true );
	$posted_custom_label = $_POST[$meta_key];
	
	if ( isset( $_REQUEST['action'] ) && 'update-site-custom' === $_REQUEST['action'] ) {
		if ( isset( $posted_custom_label ) && isset( $saved_custom_label ) ) {
			update_site_meta( $blogid, $meta_key, $posted_custom_label, false );
		} else if ( isset( $_POST[$meta_key] ) ) {
			add_site_meta( $blogid, $meta_key, $posted_custom_label, false );
		}
			
		$url =	add_query_arg(
			array(
				'update' => 'updated',
				'id'     => $blogid,
			),
			'site-info.php'
		);
			
		if ( class_exists('Soderlind\Multisite\SuperAdminAllSitesMenu') ) {
			$super_admin_sites_menu = new Soderlind\Multisite\SuperAdminAllSitesMenu();
			$super_admin_sites_menu->refresh_local_storage();
		}
	
		echo("<script>location.href = '".$url."'</script>");

	}
	
	$blog_custom_label = get_site_meta( $blogid, $meta_key, true );
	
	?>
	 <hr><h3>Custom Fields</h3>
	 <form method="post" action="site-info.php?action=update-site-custom">
		 <table>
			 <tr>
				 <td>
					<?php wp_nonce_field( 'edit-site' ); ?>
					<input type="hidden" name="id" value="<?php echo esc_attr( $blogid ); ?>" />
					<table class="form-table" role="presentation"><tr class="form-field">
							<th scope="row"><label for="blog_custom_label"><?php _e( 'Site Label' ); ?></label></th>
							<td><input name="blog_custom_label" type="text" id="blog_custom_label" value="<?php echo esc_attr( $blog_custom_label ); ?>"></td>
						</tr></table>
			 	</td>
			 	<td><?php submit_button( 'Save Changes', 'secondary', 'custom-save', true, "" ); ?></td>
			 </tr>
		 </table>
		 
		 <style>
			 .submit .button { display: none; }
			 #custom-save, #primary-save { display: block; }
		 </style>
			
  <?php
}
add_action( 'network_site_info_form', 'jlv_custom_network_site_info_form', 10, 0 ); 
