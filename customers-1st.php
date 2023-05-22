<?php

/**
 * Customers 1st sane defaults for woocommerce integration
 *
 * @link              https://c1st.com
 * @since             1.0.0
 * @package           C1st
 *
 * @wordpress-plugin
 * Plugin Name:       Customers 1st
 * Description:       Customers 1st woocommerce integration
 * Version:           1.0.0
 * Author:            C1 ST ApS <info@c1st.com>
 * Author URI:        https://c1st.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       c1st
 * Domain Path:       /languages
 */


if ( ! defined( 'WPINC' ) ) {
	die;
}

// Never duplicate gtin/barcode when duplicating products. Deplucate barcodes are not allowed in C1ST
function c1st_exclude_barcode_meta_fields( $excluded_meta ) {
	$excluded_meta[] = "_gtin";
	$excluded_meta[] = "hwp_product_gtin";
	$excluded_meta[] = "hwp_var_gtin";

	return $excluded_meta;
}
add_filter( 'woocommerce_duplicate_product_exclude_meta', 'c1st_exclude_barcode_meta_fields', 1392035857, 1 );

// Suppress webhooks for REST api request where HTTP_HTTP_X_SUPPRESS_HOOKS header is present
// IT Stack <3
function c1st_rest_api_suppress_woo_webhook( $should_deliver, $webhookObject, $arg ) {
	// Is this a REST request?
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		//if suppress header exists
		if ( isset( $_SERVER['HTTP_HTTP_X_SUPPRESS_HOOKS'] ) || isset( $_SERVER['HTTP_X_SUPPRESS_HOOKS'] ) ) {
			$should_deliver = false;
		}
	}

	return $should_deliver;
}
add_filter( 'woocommerce_webhook_should_deliver', 'c1st_rest_api_suppress_woo_webhook', 10, 3 );


// Prevent duplicated from syncing by nulling sku
// Sync will happen when users specifies SKU after duplication
function c1st_nullify_duplicate_product_sku($duplicate, $product) {
	// Set the SKU of the duplicated product to empty string
	$duplicate->set_sku('');

	return $duplicate;
}
add_filter('woocommerce_product_duplicate_before_save', 'c1st_nullify_duplicate_product_sku', 1392035857, 2);
