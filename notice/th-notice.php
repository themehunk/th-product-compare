<?php

if (!defined('ABSPATH')){
    exit;
}

if ( ! class_exists( 'Th_Product_Compare_Notice' ) ){

class Th_Product_Compare_Notice{

    function __construct(){

        add_action( 'admin_enqueue_scripts', array($this,'th_product_compare_admin_enqueue_style') );
        add_action( 'admin_notices', array($this,'th_product_compare_admin_notice' ));

        
    }

    function th_product_compare_admin_enqueue_style(){

         wp_enqueue_style( 'th-product-compare-notice-style', TH_PRODUCT_URL.'notice/css/th-notice.css', array(), '1.0.0' );

    } 

    function th_product_compare_admin_notice() { ?>

    <div class="th-product-compare-notice notice notice-success is-dismissible">
        <div class="th-product-compare-notice-wrap">
            <div class="th-product-compare-notice-image"><img src="<?php echo esc_url( TH_PRODUCT_URL.'notice/img/compare-pro.png' );?>" alt="<?php _e('TH Product Compare Pro','th-product-compare'); ?>"></div>
            <div class="th-product-compare-notice-content-wrap">
                <div class="th-product-compare-notice-content">
                <p class="th-product-compare-heading"><?php _e('Let\'s remove users confusion & help them to choose the correct product. Make product selection easy & advanced, using Compare Pro.','th-product-compare'); ?></p>
                <p><?php _e('Filter Similarities and Differences in Compare table for fast and easy comparison. You can show Custom and Global Attributes in the Compare table and order them in your desired order.','th-product-compare'); ?></p>
                </div>
                <a target="_blank" href="<?php echo esc_url('https://themehunk.com/th-product-compare-plugin/');?>" class="upgradetopro-btn"><?php _e('Upgrade To Pro','th-product-compare');?> </a>
            </div>
        </div>
    </div>

    <?php }

    
}

$obj = New Th_Product_Compare_Notice();

 }
