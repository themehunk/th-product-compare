<?php
/*
* Plugin Name: TH Product Compare
* Version: 1.0.0
* Author: ThemeHunk
* Author URI: http://www.themehunk.com/
* Text Domain: th-product-compare
 */
if (!defined('ABSPATH')) exit;

define('TH_PRODUCT_URL', plugin_dir_url(__FILE__));
define('TH_PRODUCT_PATH', plugin_dir_path(__FILE__));
if (!function_exists('th_product_compare_loaded')) {
    include_once(TH_PRODUCT_PATH . 'admin/inc.php');
    include_once(TH_PRODUCT_PATH . 'admin/front/front.php');
    include_once(TH_PRODUCT_PATH . 'admin/front/product.php');
    include_once(TH_PRODUCT_PATH . 'admin/back/init.php');
    add_action('plugins_loaded', 'th_product_compare_loaded');
    function th_product_compare_loaded()
    {
        th_compare_admin::get();
        th_product_compare::get();
        th_product_compare_shortcode::get();
        th_product_compare_return::get();
    }
}
