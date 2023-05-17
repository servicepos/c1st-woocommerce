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

require __DIR__.'/vendor/autoload.php';



function null_barcode_for_duplicated_product($newId, $oldproduct) {
    c1st_log(json_encode([$newId, $oldproduct]));
}

function c1st_log($message) {
    $log_file = WP_CONTENT_DIR . '/c1st-defaults.log';
    $formatted_message = '[' . date('Y-m-d H:i:s') . '] ' . $message . "\n";
    file_put_contents($log_file, $formatted_message, FILE_APPEND);
}


add_action('woocommerce_duplicate_product', 'null_barcode_for_duplicated_product', 10, 2);