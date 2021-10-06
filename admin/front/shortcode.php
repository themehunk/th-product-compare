<?php
if (!defined('ABSPATH')) exit;
class th_product_compare_shortcode
{
    private function __construct()
    {
        add_shortcode('th_product_compare', array($this, 'compare'));
    }
    public $cookiesName = 'th_compare_product';
    public $optionName = 'th_compare_option';
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
        if ($product_id) {
            return $this->btnBYoption($product_id);
        }
    }
    public function btnBYoption($product_id)
    {

        $compareText = __('Compare', 'th-product-compare');
        $btnClass = 'th-product-compare-btn';
        $compareBtnTypeClass = 'btn_type';
        $checkOption = get_option($this->optionName);
        // button type 
        if (is_array($checkOption) && !empty($checkOption)) {
            if (isset($checkOption['compare-btn-type'])) {
                if ($checkOption['compare-btn-type']) {
                    $compareBtnTypeClass = 'txt_type';
                }
            }
        }
        $btnClass .= ' '.$compareBtnTypeClass;
        // previous cookies class 
        $previousCookie = $this->getPrevId();
        if (!empty($previousCookie)) {
            $getExist = in_array($product_id, $previousCookie);
            if ($getExist) {
                $btnClass .= ' th-added-compare';
            }
        }

        $html = '';
        $html .= "<div class='th-product-compare-btn-wrap'>";
        $html .= '<a href="#" class="' . $btnClass . '" data-th-product-id="' . $product_id . '">';
        $html .= $compareText;
        $html .= '</a>';
        $html .= "</div>";
        return $html;
    }
    // class end
}
