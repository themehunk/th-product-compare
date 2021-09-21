<?php
if (!defined('ABSPATH')) exit;
class th_product_compare_shortcode
{
    private function __construct()
    {
        add_shortcode('th_product_compare', array($this, 'compare'));
    }
    public $cookiesName = 'th_compare_product';
    public function getPrevId()
    {
        if (isset($_COOKIE[$this->cookiesName]) && $_COOKIE[$this->cookiesName] != '') {
            $getPRoductId = sanitize_text_field($_COOKIE[$this->cookiesName]);
            return explode(',', $getPRoductId);
        }
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
            // check already 
            $alreadyClass = '';
            $previousCookie = $this->getPrevId();
            if (!empty($previousCookie)) {
                $getExist = in_array($product_id, $previousCookie);
                if ($getExist) {
                    $alreadyClass = 'th-added-compare';
                }
            }
            // check already 
            $html .= "<div class='th-product-compare-btn-wrap'>";
            $html .= '<a href="#" class="th-product-compare-btn ' . $alreadyClass . '" data-th-product-id="' . $product_id . '">';
            $html .= 'compare';
            $html .= '</a>';
            $html .= "</div>";
        }
        return $html;
    }
    // class end
}
