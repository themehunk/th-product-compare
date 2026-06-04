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
            $getPRoductId = sanitize_text_field(wp_unslash($_COOKIE[$this->cookiesName]));
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
        add_shortcode('th_compare_icon', array($this, 'compare_icon_shortcode'));
        $this->showAndHideSingle();
    }

    public function compare_icon_shortcode( $atts, $content = null ) {
        return th_compare_menu_icon( false );
    }

    public function showAndHideShopPage()
    {
        $checkOption = get_option($this->optionName);
        if ($checkOption && is_array($checkOption) && !empty($checkOption)) {
            if (isset($checkOption['field-product-page']) && $checkOption['field-product-page'] == '1' && (isset($checkOption['compare-at-shop-hook']) && $checkOption['compare-at-shop-hook'] == 'after')) {
                add_action('woocommerce_after_shop_loop_item', array($this, 'addCompareBtn'), 11);
            }
            elseif (isset($checkOption['field-product-page']) && $checkOption['field-product-page'] == '1' && (isset($checkOption['compare-at-shop-hook']) && $checkOption['compare-at-shop-hook'] == 'before')) {
                add_action('woocommerce_after_shop_loop_item', array($this, 'addCompareBtn'), 9);
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
                add_action('woocommerce_after_add_to_cart_button', array($this, 'addCompareBtn'), 30);
            }
        } else {
            add_action('woocommerce_after_add_to_cart_button', array($this, 'addCompareBtn'), 30);
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

        // Start output buffering to capture the button HTML
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
       $isChecked = (!empty($previousCookie) && in_array($product_id, $previousCookie));

        $isAdded = (!empty($previousCookie) && in_array($product_id, $previousCookie)) ? ' th-added-compare' : '';

        // Determine button style
        $buttonStyle = (is_array($checkOption) && isset($checkOption['compare-btn-type']) && $checkOption['compare-btn-type'] === 'checkbox') ? 'checkbox' : 'icon';

        if ($buttonStyle === 'checkbox') {
            // Checkbox class
            $checkboxClass = 'th-product-compare-checkbox' . $isAdded;
?>
            <div class='th-product-compare-checkbox-wrap'>
                <label class="th-compare-label">
                    <input type="checkbox" class="<?php echo esc_attr($checkboxClass); ?>" data-th-product-id="<?php echo esc_attr($product_id); ?>"<?php echo checked($isChecked); ?> aria-label="<?php echo esc_attr($compareText); ?>">
                    <?php echo esc_html($compareText); ?>
                </label>
            </div>
<?php
        } else {
            // Icon class
            $iconClass = 'th-product-compare-btn compare' . $isAdded;
?>
            <div class="thunk-compare">
                <div th-tooltip="<?php echo esc_attr($compareText); ?>" class="compare-tooltip th-product-compare-btn-wrap">
                    <a class="<?php echo esc_attr($iconClass); ?>" data-th-product-id="<?php echo esc_attr($product_id); ?>" aria-label="<?php echo esc_attr($compareText); ?>">
                        <span class="icon">&#8646;</span>
                        <span class="text"><?php echo esc_html($compareText); ?></span>
                    </a>
                </div>
            </div>
<?php
        }
    }
}

function th_compare_add_action_shop_list()
{
    $obj = new th_product_compare_shortcode();
    $obj->showAndHideShopPage();
}

add_action('woocommerce_init', 'th_compare_add_action_shop_list');

/**
 * Template function — use in any theme file or child theme.
 *
 * Usage:
 *   <?php th_compare_menu_icon(); ?>
 *
 * To capture as a string:
 *   <?php $icon = th_compare_menu_icon( false ); ?>
 *
 * @param bool $echo  Echo the output (true) or return it (false).
 * @return string
 */
if ( ! function_exists( 'th_compare_menu_icon' ) ) :
function th_compare_menu_icon( $echo = true ) {
    if ( ! class_exists( 'WooCommerce' ) ) {
        if ( $echo ) { return; }
        return '';
    }

    // Respect the backend "Enable Floating Compare Icon" toggle
    $option = get_option( 'th_compare_option' );
    if ( isset( $option['field-menu-icon'] ) && $option['field-menu-icon'] !== '1' ) {
        if ( $echo ) { return; }
        return '';
    }

    // Read count from cookie so badge is correct on first render
    $count       = 0;
    $cookie_name = th_product_compare::cookieName();
    if ( ! empty( $_COOKIE[ $cookie_name ] ) ) {
        $raw     = sanitize_text_field( wp_unslash( $_COOKIE[ $cookie_name ] ) );
        $decoded = json_decode( $raw, true );
        if ( is_array( $decoded ) ) {
            $count = count( $decoded );
        }
    }

    $label       = esc_attr__( 'Compare Products', 'th-product-compare' );
    // Outer widget is ALWAYS visible — same as a nav cart icon
    // Only the count badge is hidden when 0 products
    $badge_style = $count > 0 ? '' : ' style="display:none;"';

    $html  = '<span class="th-compare-icon-widget" role="button" tabindex="0" aria-label="' . $label . '">';
    $html .= '<span class="th-compare-icon-widget-count"' . $badge_style . '>' . esc_html( $count ) . '</span>';
    $html .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">';
    $html .= '<path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path>';
    $html .= '<path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path>';
    $html .= '<path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>';
    $html .= '</svg>';
    $html .= '</span>';

    if ( $echo ) {
        echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        return;
    }
    return $html;
}
endif;
?>