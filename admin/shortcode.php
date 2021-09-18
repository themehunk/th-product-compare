<?php
if (!defined('ABSPATH')) exit;
class th_product_compare_shortcode
{
    private function __construct()
    {
        add_shortcode('th_product_compare', array($this, 'compare'));
    }
    public static function get()
    {
        return new self();
    }
    public function compare($atts, $content)
    {
        $a = shortcode_atts(['product_id' => ''], $atts);
        $product_id = intval($a['product_id']);
        $html = '';
        if ($product_id) {
            $html .= "<div class='th-product-compare-btn-wrap'>";
            $html .= '<a href="#" class="th-product-compare-btn" data-th-product-id="' . $product_id . '">';
            $html .= 'compare';
            $html .= '</a>';
            $html .= "</div>";
        }
        return $html;
    }
    // class end
}
