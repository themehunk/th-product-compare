<?php
if (!defined('ABSPATH')) exit;

class th_product_compare_shortcode
{
    public $cookiesName;
    public $optionName = 'th_compare_option';

    function __construct()
    {
        $this->cookiesName = th_product_compare::cookieName();
    }

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
        return [];
    }

    public function get()
    {
        add_shortcode('th_compare', array($this, 'compare'));
        $this->showAndHideSingle();
    }

    public function showAndHideShopPage()
    {
        $checkOption = get_option($this->optionName);
        if ($checkOption && is_array($checkOption) && !empty($checkOption)) {
            if (isset($checkOption['field-product-page']) && $checkOption['field-product-page'] == '1') {
                add_action('woocommerce_after_shop_loop_item_title', array($this, 'addCompareBtn'), 11);
            }
        } else {
            add_action('woocommerce_after_shop_loop_item', array($this, 'addCompareBtn'), 11);
        }
    }

    public function showAndHideSingle()
    {
        $checkOption = get_option($this->optionName);
        if ($checkOption && is_array($checkOption) && !empty($checkOption)) {
            if (isset($checkOption['field-product-single-page']) && $checkOption['field-product-single-page'] == '1') {
                add_action('woocommerce_after_add_to_cart_form', array($this, 'addCompareBtn'), 30);
            }
        } else {
            add_action('woocommerce_after_add_to_cart_form', array($this, 'addCompareBtn'), 30);
        }
    }

    public function addCompareBtn()
    {
        global $product;
        $productId = intval($product->get_id());
        if ($productId) {
            $this->btnBYoption($productId);
        }
    }

    public function compare($atts, $content = null)
    {
        $a = shortcode_atts(['pid' => ''], $atts);
        $product_id = intval($a['pid']);
        
        // Validate product ID and check if it's a valid WooCommerce product
        if (!$product_id || !wc_get_product($product_id)) {
            return '<span class="th-compare-error">' . __('Invalid product ID.', 'th-product-compare') . '</span>';
        }

        // Start output buffering to capture the checkbox HTML
        ob_start();
        $this->btnBYoption($product_id);
        return ob_get_clean();
    }

    public function btnBYoption($product_id)
    {
        $compareText = __('Compare', 'th-product-compare');
        $checkOption = get_option($this->optionName);

        // Button text from options
        if (is_array($checkOption) && !empty($checkOption)) {
            if (isset($checkOption['compare-btn-text']) && $checkOption['compare-btn-text']) {
                $compareText = $checkOption['compare-btn-text'];
            }
        }

        // Check if product is already in comparison
        $previousCookie = $this->getPrevId();
        $isChecked = (!empty($previousCookie) && in_array($product_id, $previousCookie)) ? ' checked' : '';

        // Checkbox class
        $checkboxClass = 'th-product-compare-checkbox';
        if ($isChecked) {
            $checkboxClass .= ' th-added-compare';
        }
?>
        <div class='th-product-compare-checkbox-wrap'>
            <label class="th-compare-label">
                <input type="checkbox" class="<?php echo esc_attr($checkboxClass); ?>" data-th-product-id="<?php echo esc_attr($product_id); ?>"<?php echo $isChecked; ?> aria-label="<?php echo esc_attr($compareText); ?>">
                <?php echo esc_html($compareText); ?>
            </label>
        </div>
<?php
    }
}

function th_compare_add_action_shop_list()
{
    $obj = new th_product_compare_shortcode();
    $obj->showAndHideShopPage();
}

add_action('woocommerce_init', 'th_compare_add_action_shop_list');
?>