<?php
if (!defined('ABSPATH')) exit;
class th_product_compare_return
{
    public static function get()
    {
        return new self();
    }
    private function __construct()
    {
        add_action('wp_ajax_th_get_compare_product', array($this, 'get_products'));
    }
    public function get_products()
    {
        // echo "hello";
        print_r($_COOKIE);
        echo "<br>";
        print_r($_COOKIE['th_compare_product']);
        // if (isset($_POST['product_id']) && $_POST['product_id'] != '') {
        //     $productID = sanitize_text_field($_POST['product_id']);
        //     echo $productID;
        // }
        die();
    }
    // single product 
    public function get_product($productid, $options)
    {
        
    }
    // class end
}
