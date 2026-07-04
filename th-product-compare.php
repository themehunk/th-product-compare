<?php
/*
* Plugin Name: TH Product Compare
* Description: TH Product Compare plugin helps you to create interactive product comparison tables and allow customers to compare their products on their WooCommerce Store. It will also increases engagement and conversion rates. This plugin lets the customers to compare different product and display fields like Image, Title, Rating, Price, Add to cart, Description, Availability and SKU. You can display Compare button or link with your products and also add Number of Product to Compare in your comparison table. It is Woocommerce Compatible, fully Responsive, and user friendly plugin which make your buying decision more easy.
* Version: 1.4.1
* Requires at least:       5.0
* Tested up to:            7.0
* WC requires at least:    3.2
* WC tested up to:         10.9
* Author: ThemeHunk
* Author URI: http://www.themehunk.com/
* License:                 GPL-2.0+
* Text Domain: th-product-compare
 */

if (!defined('ABSPATH')) exit;
if (!function_exists('tpcp_loaded')) {

if (!defined('TH_PRODUCT_VERSION')) {
    define('TH_PRODUCT_VERSION', '1.4.1');
}
if (!defined('TH_PRODUCT_URL')) {
    define('TH_PRODUCT_URL', plugin_dir_url(__FILE__));
}
if (!defined('TH_PRODUCT_PATH')) {
    define('TH_PRODUCT_PATH', plugin_dir_path(__FILE__));
}
if (!defined('TH_PRODUCT_BASE_NAME')) {
    define('TH_PRODUCT_BASE_NAME', __FILE__);
}

add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( 'th-product-compare', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
} );

if (!function_exists('th_product_compare_loaded')) {
    include_once(TH_PRODUCT_PATH . 'admin/themehunk-menu/admin-menu.php');
    include_once(TH_PRODUCT_PATH . 'admin/inc.php');
    include_once(TH_PRODUCT_PATH . 'admin/front/front.php');
    include_once(TH_PRODUCT_PATH . 'admin/front/product.php');
    include_once(TH_PRODUCT_PATH . 'admin/back/init.php');
    include_once(TH_PRODUCT_PATH . 'admin/front/custom-page.php');

    add_action('wp_loaded', 'th_product_compare_loaded');
    function th_product_compare_loaded()
    {
        th_compare_admin::get();
        th_product_compare::get();
        if (class_exists('WooCommerce')) {
        $frontObj = new th_product_compare_shortcode();
        $frontObj->get();
        th_product_compare_return::get();
        Thpc_CustomPage::get();
        }
    }
}

}