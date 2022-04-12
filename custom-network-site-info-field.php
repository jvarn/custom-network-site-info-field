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

function jlv_custom_network_site_info_field() {
	
	submit_button( 'Save Changes', 'primary', 'primary-save', true, "" ); 
	echo "</form>"; // Close form in site-info.php

	$blogid = isset( $_REQUEST['id'] ) ? (int) $_REQUEST['id'] : 0;	
	$meta_key = 'blog_custom_field';
		
	$saved_custom_field = get_site_meta( $blogid, $meta_key, true );
	$posted_custom_field = $_POST[$meta_key];
	
	if ( isset( $_REQUEST['action'] ) && 'update-site-custom' === $_REQUEST['action'] ) {
		if ( isset( $posted_custom_field ) && isset( $saved_custom_field ) ) {
			update_site_meta( $blogid, $meta_key, $posted_custom_field, false );
		} else if ( isset( $_POST[$meta_key] ) ) {
			add_site_meta( $blogid, $meta_key, $posted_custom_field, false );
		}
			
		$url =	add_query_arg(
			array(
				'update' => 'updated',
				'id'     => $blogid,
			),
			'site-info.php'
		);
			
		echo("<script>location.href = '".$url."'</script>");
	}
	
	$blog_custom_field = get_site_meta( $blogid, $meta_key, true );
	
	?>
	 <hr><h3>Custom Fields</h3>
	 <form method="post" action="site-info.php?action=update-site-custom">
		 <table>
			 <tr>
				 <td>
					<?php wp_nonce_field( 'edit-site' ); ?>
					<input type="hidden" name="id" value="<?php echo esc_attr( $blogid ); ?>" />
					<table class="form-table" role="presentation"><tr class="form-field">
							<th scope="row"><label for="blog_custom_field"><?php _e( 'Custom Label' ); ?></label></th>
							<td><input name="blog_custom_field" type="text" id="blog_custom_field" value="<?php echo esc_attr( $blog_custom_field ); ?>"></td>
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
add_action( 'network_site_info_form', 'jlv_custom_network_site_info_field', 10, 0 ); 
