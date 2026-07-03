<?php
if (!defined('ABSPATH')) exit;
class Thpc_CustomPage
{
    private function __construct()
    {
        add_filter('the_content', array($this, 'custom_page'));
    }
    public static function get()
    {
        return new self();
    }
    public function custom_page($content)
    {
        global $post;
        if (!isset($post->post_name) || $post->post_name !== 'th-product-compare-custom-post') {
            return $content;
        }

        $cookieName = th_product_compare::cookieName();
        if (isset($_COOKIE[$cookieName]) && $_COOKIE[$cookieName] != '') {
            $getPRoductId = sanitize_text_field($_COOKIE[$cookieName]);
            if ($getPRoductId) {
                $removeSlace = stripslashes($getPRoductId);
                $removeSlace = json_decode($removeSlace);
                $decodeArray = '';
                foreach ($removeSlace as $array_value) {
                    $decodeArray .= $decodeArray == '' ? th_product_compare::tpcp_decrypt($array_value) : ',' . th_product_compare::tpcp_decrypt($array_value);
                }
                $sanitizeContent = wp_kses(
                    do_shortcode('[tpcp_product_list compare-type="auto_add" pid="' . $decodeArray . '"]'),
                    th_product_compare::$allowKsesAttr
                );
                $content .= $sanitizeContent;
            }
        }
        return $content;
    }
}
