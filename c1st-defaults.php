<?php

/**
 * Customers 1st sane defaults for woocommerce integration
 *
 * @link              https://c1st.com
 * @since             1.0.0
 * @package           C1st
 *
 * @wordpress-plugin
 * Plugin Name:       C1st Defaults
 * Description:       Customers 1st sane defaults for woocommerce integration
 * Version:           1.0.0
 * Author:            C1 ST ApS
 * Author URI:        https://c1st.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       c1st
 * Domain Path:       /languages
 */


if ( ! defined( 'WPINC' ) ) {
	die;
}

require __DIR__ . '/vendor/autoload.php';

// Never duplicate gtin/barcode when duplicating products
function c1st_exclude_barcode_meta_fields( $excluded_meta ) {
	$excluded_meta[] = "_gtin";
	$excluded_meta[] = "hwp_product_gtin";
	$excluded_meta[] = "hwp_var_gtin";

	return $excluded_meta;
}

// Supress webhooks for REST api request where HTTP_HTTP_X_SUPPRESS_HOOKS header is present
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
add_filter( 'woocommerce_duplicate_product_exclude_meta', 'c1st_exclude_barcode_meta_fields' );