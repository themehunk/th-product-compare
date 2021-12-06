<?php
if (!defined('ABSPATH')) exit;
class th_product_compare_shortcode
{
    private function __construct()
    {
        add_shortcode('th_compare', array($this, 'compare'));
        $this->showAndHide();
    }
    public $cookiesName = 'th_compare_product';
    public $optionName = 'th_compare_option';
    public function getPrevId()
    {
        if (isset($_COOKIE[$this->cookiesName]) && $_COOKIE[$this->cookiesName] != '') {
            $getPRoductId = sanitize_text_field($_COOKIE[$this->cookiesName]);
            if ($getPRoductId) {
                $removeSlace = stripslashes($getPRoductId);
                $removeSlace = json_decode($removeSlace);
                $decodeArray = [];
                foreach ($removeSlace as $array_value) {
                    $decodeArray[] = th_product_compare::th_decrypt($array_value);
                }
                return $decodeArray;
            }
        }
    }
    public static function get()
    {
        return new self();
    }
    public function showAndHide()
    {

        $checkOption = get_option($this->optionName);
        // button type 
        if ($checkOption && is_array($checkOption) && !empty($checkOption)) {
            // single product content 
            if (isset($checkOption['field-product-single-page'])) {
                if ($checkOption['field-product-single-page'] == '1') {
                    add_action('woocommerce_single_product_summary', array($this, 'addCompareBtn'), 30);
                }
            } else {
                add_action('woocommerce_single_product_summary', array($this, 'addCompareBtn'), 30);
            }
            // list product content 
            if (isset($checkOption['field-product-page'])) {
                if ($checkOption['field-product-page'] == '1') {
                    add_action('woocommerce_after_shop_loop_item', array($this, 'addCompareBtn'), 15);
                }
            } else {
                add_action('woocommerce_after_shop_loop_item', array($this, 'addCompareBtn'), 15);
            }
        }
    }
    public function addCompareBtn()
    {
        global $product;
        $productId = intval($product->get_id());
        if ($productId) {
            echo $this->btnBYoption($productId);
        }
    }
    // show compare by shortcode 
    public function compare($atts, $content)
    {
        $a = shortcode_atts(['pid' => ''], $atts);
        $product_id = intval($a['pid']);
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
            if (isset($checkOption['compare-btn-type']) && $checkOption['compare-btn-type'] == 'link') {
                $compareBtnTypeClass = 'txt_type';
            }
        }
        $btnClass .= ' ' . $compareBtnTypeClass;
        // previous cookies class 
        $previousCookie = $this->getPrevId();
        if (!empty($previousCookie)) {
            $getExist = in_array($product_id, $previousCookie);
            if ($getExist) {
                $btnClass .= ' th-added-compare';
                // added text 
                // $compareText = __('Added', 'th-product-compare');
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
