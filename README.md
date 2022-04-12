# Custom Network Site Info Field

* __Note:__ This is a private branch for integration with [my branch of super-admin-all-sites-menu](https://github.com/jvarn/super-admin-all-sites-menu/tree/get_site_meta-option-for-blogname).

This Wordpress plugin allows you to add a custom field to the network site info page [wp-admin\network\site-info.php](https://github.com/WordPress/WordPress/blob/master/wp-admin/network/site-info.php) by using the [network_site_info_form](https://developer.wordpress.org/reference/hooks/network_site_info_form/) hook.

## Usage
The sample provided here adds a single field called `Custom Field` with a label `Custom Label`. You will need to adjust these to suit your requirements.
