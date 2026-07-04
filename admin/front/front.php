<?php
if (!defined('ABSPATH')) exit;

class th_product_compare_shortcode
{
    public $cookiesName;
    public $tpcp_optionName = 'th_compare_option';
    private $cachedPrevIds = null;

    function __construct()
    {
        $this->cookiesName = th_product_compare::cookieName();
        add_shortcode('th_product_compare_btn', array($this, 'th_product_compare_btn_shortcode'));
    }

    public function getPrevId()
    {
        if ($this->cachedPrevIds !== null) {
            return $this->cachedPrevIds;
        }
        if (isset($_COOKIE[$this->cookiesName]) && $_COOKIE[$this->cookiesName] != '') {
            $getPRoductId = sanitize_text_field($_COOKIE[$this->cookiesName]);
            if ($getPRoductId) {
                $removeSlace = stripslashes($getPRoductId);
                $removeSlace = json_decode($removeSlace);
                $decodeArray = [];
                foreach ($removeSlace as $array_value) {
                    $decodeArray[] = th_product_compare::tpcp_decrypt($array_value);
                }
                $this->cachedPrevIds = array_filter($decodeArray, function($value) { return $value !== false; });
                return $this->cachedPrevIds;
            }
        }
        $this->cachedPrevIds = [];
        return $this->cachedPrevIds;
    }

    public function get()
    {
        add_shortcode('th_compare', array($this, 'compare_shortcode'));
        add_shortcode('tpcp_product_list', array($this, 'show_compare_by_id'));
        add_shortcode('th_compare_icon', array($this, 'th_compare_icon_shortcode'));
        $this->showAndHideSingle();
    }

    public function th_compare_icon_shortcode( $atts = [], $content = null )
    {
        return thpc_compare_menu_icon( false );
    }

    public function showAndHideShopPage()
    {
        $checkOption = th_product_compare::get_cached_option();
        if ($checkOption && is_array($checkOption) && !empty($checkOption)) {
            if (isset($checkOption['field-product-page']) && $checkOption['field-product-page'] == '1' && (isset($checkOption['compare-at-shop-hook']) && $checkOption['compare-at-shop-hook'] == 'after')) {
                add_action('woocommerce_after_shop_loop_item', array($this, 'addCompareBtn'), 11);
            }
            elseif (isset($checkOption['field-product-page']) && $checkOption['field-product-page'] == '1' && (isset($checkOption['compare-at-shop-hook']) && $checkOption['compare-at-shop-hook'] == 'before')) {
                add_action('woocommerce_after_shop_loop_item', array($this, 'addCompareBtn'), 9);
            }
            elseif (isset($checkOption['field-product-page']) && $checkOption['field-product-page'] == '1' && (isset($checkOption['compare-at-shop-hook']) && ($checkOption['compare-at-shop-hook'] == 'onimageleft' || $checkOption['compare-at-shop-hook'] == 'onimageright'))) {
                add_action('woocommerce_before_shop_loop_item_title', array($this, 'addCompareBtn'), 9);
            }
            elseif (isset($checkOption['field-product-page']) && $checkOption['field-product-page'] == '1' && (isset($checkOption['compare-at-shop-hook']) && $checkOption['compare-at-shop-hook'] == 'oncart')) {
                add_action('woocommerce_before_shop_loop_item_title', array($this, 'addCompareBtn'), 9);
            }
        } else {
            add_action('woocommerce_after_shop_loop_item', array($this, 'addCompareBtn'), 11);
        }
    }

    public function showAndHideSingle()
    {
        $checkOption = th_product_compare::get_cached_option();
        if ($checkOption && is_array($checkOption) && !empty($checkOption)) {
            add_action('woocommerce_after_single_product_summary', [$this, 'appearAutoSinglePage']);
            if (isset($checkOption['field-product-single-page']) && $checkOption['field-product-single-page'] == '1') {
                add_action('woocommerce_after_add_to_cart_button', array($this, 'addCompareBtn'), 30);
            }
        } else {
            add_action('woocommerce_after_add_to_cart_button', array($this, 'addCompareBtn'), 30);
        }
    }

    public function excludeIds($arg, $productId)
    {
        $exp_ = explode('|', $arg);
        $returnArr = true;
        if (is_array($exp_) && !empty($exp_)) {
            foreach ($exp_ as $value_) {
                $valueWithDash = explode('-', $value_);
                if ($productId == $valueWithDash[0]) {
                    $returnArr = false;
                    break;
                }
            }
        }
        return $returnArr;
    }

    public function appearAutoSinglePage()
    {
        global $product;
        $productId = intval($product->get_id());
        if ($productId) {
            $save_productsMode = get_post_meta($productId, 'tpcp_choose_product_auto_manual', true);
            $getProductsIds = [];
            if ($save_productsMode && ($save_productsMode == 'manual' || $save_productsMode == 'hide')) {
                if ($save_productsMode == 'manual') {
                    $save_productsIds = get_post_meta($productId, 'tpcp_auto_show_compare', true);
                    if ($save_productsIds != '') {
                        $exp_ = explode('|', $save_productsIds);
                        if (is_array($exp_) && !empty($exp_)) {
                            foreach ($exp_ as $value_) {
                                $valueWithDash = explode('-', $value_);
                                $getProductsIds[] = $valueWithDash[0];
                            }
                        }
                    }
                }
            } else {
                $getProductsIds = $this->showIfAutoSinglePage($productId);
            }
            if (!empty($getProductsIds)) {
                $createIDSshortcode = '';
                array_unshift($getProductsIds, $productId);
                $getProductsIds = array_unique($getProductsIds);
                foreach ($getProductsIds as $Ids_value) {
                    $createIDSshortcode .= $createIDSshortcode == '' ? $Ids_value : ',' . $Ids_value;
                }
                echo wp_kses(do_shortcode('[tpcp_product_list compare-type="auto_add" pid="' . esc_attr($createIDSshortcode) . '"]'), th_product_compare::$allowKsesAttr);
            }
        }
    }

    public function showIfAutoSinglePage($productId)
    {
        $checkOption = th_product_compare::get_cached_option();
        if (isset($checkOption['field-auto-single-page']) && $checkOption['field-auto-single-page'] == '1' && $checkOption['auto-single-page-by'] != '') {
            if (isset($checkOption['th-compare-exclude-product']) && $checkOption['th-compare-exclude-product'] != '') {
                $getExcludeID = $this->excludeIds($checkOption['th-compare-exclude-product'], $productId);
                if (!$getExcludeID) {
                    return;
                }
            }
            $limit = isset($checkOption['automatic-page-limit']) && intval($checkOption['automatic-page-limit']) ? intval($checkOption['automatic-page-limit']) : 8;
            if ($checkOption['auto-single-page-by'] == 'cat') {
                $getProductsIds = $this->getProductsIDbyTerm($productId, 'cat', $limit);
            } else if ($checkOption['auto-single-page-by'] == 'tag') {
                $getProductsIds = $this->getProductsIDbyTerm($productId, 'tag', $limit);
            } else {
                $getProductsIds = wc_get_related_products($productId, $limit);
            }
            return $getProductsIds;
        }
    }

    public function getProductsIDbyTerm($productId, $option_, $limit)
    {
        $filter_type = $option_ == 'cat' ? 'product_cat' : 'product_tag';
        $getTerm = get_the_terms($productId, $filter_type);
        $termArray = [];
        if ($getTerm) {
            foreach ($getTerm as $getTerm_value) {
                $termArray[] = $getTerm_value->slug;
            }
            $args = ['return' => 'ids', 'limit' => $limit];
            if ($option_ == 'cat') {
                $args['category'] = $termArray;
            } else {
                $args['tag'] = $termArray;
            }
            $postId_ = new WC_Product_Query($args);
            return $postId_ = $postId_->get_products();
        }
    }

    public function addCompareBtn()
    {
        global $product;
        $productId = intval($product->get_id());
        if ($productId) {
            echo wp_kses($this->btnBYoption($productId), th_product_compare::$allowKsesAttr);
        }
    }

    public function compare_shortcode($atts, $content)
    {
        $a = shortcode_atts(['pid' => ''], $atts);
        $product_id = intval($a['pid']);
        if ($product_id) {
            return wp_kses($this->btnBYoption($product_id), th_product_compare::$allowKsesAttr);
        }
    }


public function btnBYoption($product_id)
{
    $compareText = '';
    $btnClass = 'th-product-compare-btn';
    $compareBtnTypeClass = 'btn_type';

    $checkOption = th_product_compare::get_cached_option();

        $defaultOptions = array(
            'compare-btn-type'     => 'icon',
            'compare-btn-text'     => esc_html__( 'Compare', 'th-product-compare' ),
            'compare-appear-type'  => '',
            'compare-at-shop-hook' => '',
        );

        $options = is_array( $checkOption )
            ? array_merge( $defaultOptions, $checkOption )
            : $defaultOptions;

        $shop_btntype = $options['compare-at-shop-hook'];

    if (isset($options['compare-btn-type'])) {
        if ($options['compare-btn-type'] == 'link') {
            $compareBtnTypeClass = 'txt_type';
            $compareText = '<span>' . esc_html($options['compare-btn-text']) . '</span>';
        } else if ($options['compare-btn-type'] == 'icon') {
            $compareBtnTypeClass = 'icon_type';
            $compareText = '<i class="icon">&#8646;</i><span class="text">' . esc_html($options['compare-btn-text']) . '</span>';
        } else if ($options['compare-btn-type'] == 'checkbox') {
            $compareBtnTypeClass = 'checkbox_type';
            $compareText = '<input type="checkbox" class="th-compare-checkbox" data-th-product-id="' . esc_attr($product_id) . '">';
            if (isset($options['compare-btn-text']) && $options['compare-btn-text']) {
                $compareText .= ' <span class="text">' . esc_html($options['compare-btn-text']) . '</span>';
            }
        } else {
            $compareText = '<span>' . esc_html($options['compare-btn-text']) . '</span>';
        }
    }

    if (isset($options['compare-appear-type']) && $options['compare-appear-type'] == 'page') {
        $btnClass .= ' th-single-page';
    }

    $btnClass .= ' ' . $compareBtnTypeClass;
    $previousCookie = $this->getPrevId();
    if (!empty($previousCookie) && in_array($product_id, $previousCookie)) {
        $btnClass .= ' th-added-compare';
        if ($options['compare-btn-type'] == 'checkbox') {
            $compareText = str_replace('type="checkbox"', 'type="checkbox" checked', $compareText);
        }
    }

    $html = '<div class="thunk-compare '.esc_attr($shop_btntype).'"><div class="th-product-compare-btn-wrap">';
    if ($options['compare-btn-type'] == 'checkbox') {
        $html .= '<label class="' . esc_attr($btnClass) . '" data-th-product-id="' . esc_attr($product_id) . '">' . $compareText . '</label>';
    } else {
        $html .= '<a href="#" class="' . esc_attr($btnClass) . '" data-th-product-id="' . esc_attr($product_id) . '" th-tooltip="' . esc_attr($options['compare-btn-text']) . '">' . $compareText . '</a>';
    }
    $html .= '</div></div>';
    return $html;
}

    public function show_compare_by_id($atts)
    {
        if (isset($atts['pid']) && $atts['pid'] != '') {
            $compareType = isset($atts['compare-type']) && $atts['compare-type'] != '' ? $atts['compare-type'] : '';
            $rmREmoveBTn['remove_btn'] = $compareType == 'single_page';
            $rmREmoveBTn['compare_type'] = $compareType;
            $addClassWrapClass = $compareType == 'auto_add' ? 'th_auto_single_page' : '';
            $productIds = esc_html($atts['pid']);
            $explode_ = explode(',', $productIds);
            if (!empty($explode_)) {
                $shortCodeClass = new th_product_compare_return();
                $productHtml = $shortCodeClass->productHtml($explode_, $rmREmoveBTn);
                $html = '<div class="th-compare-filter-shortcode ' . $addClassWrapClass . '">';
                $html .= '<div class="th-compare-output-wrap-inner">';
                $html .= '<div class="th-compare-heading">';
                $html .= '<span class="heading_">' . esc_html__('Compare Products', 'th-product-compare') . '</span>';
                if (isset($productHtml['category'])) {
                    $html .= $productHtml['category'];
                }
                if (isset($productHtml['add_highlights'])) {
                    $html .= $productHtml['add_highlights'];
                }
                $html .= '</div>';
                $html .= '<div class="th-compare-output-product">';
                $html .= $productHtml['html'];
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
                return wp_kses($html, th_product_compare::$allowKsesAttr);
            }
        }
    }

    public function th_product_compare_btn_shortcode($atts)
    {
        $atts = shortcode_atts(
            array(
                'pid' => '',
            ),
            $atts,
            'th_product_compare_btn'
        );
        $product_id = !empty($atts['pid']) ? intval($atts['pid']) : 0;
        if (empty($product_id) && is_singular('product')) {
            global $product;
            $product_id = $product->get_id();
        }
        if ($product_id) {
            return wp_kses($this->btnBYoption($product_id), th_product_compare::$allowKsesAttr);
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
 * Render the compare menu icon widget.
 * Same function signature as the free plugin's th_compare_menu_icon().
 *
 * @param bool $echo  Echo the output (true) or return it (false).
 * @return string
 */
if ( ! function_exists( 'thpc_compare_menu_icon' ) ) :
function thpc_compare_menu_icon( $echo = true ) {
    if ( ! class_exists( 'WooCommerce' ) ) {
        if ( $echo ) { return; }
        return '';
    }

    $option = th_product_compare::get_cached_option();

    if ( isset( $option['field-menu-icon'] ) && $option['field-menu-icon'] !== '1' ) {
        if ( $echo ) { return; }
        return '';
    }

    $bg    = isset( $option['icon-bg-color'] )    && $option['icon-bg-color']    ? sanitize_hex_color( $option['icon-bg-color'] )    : '#111827';
    $color = isset( $option['icon-svg-color'] )   && $option['icon-svg-color']   ? sanitize_hex_color( $option['icon-svg-color'] )   : '#ffffff';
    $badge = isset( $option['icon-badge-color'] ) && $option['icon-badge-color'] ? sanitize_hex_color( $option['icon-badge-color'] ) : '#ef4444';

    $count       = 0;
    $cookie_name = th_product_compare::cookieName();
    if ( ! empty( $_COOKIE[ $cookie_name ] ) ) {
        $raw     = sanitize_text_field( wp_unslash( $_COOKIE[ $cookie_name ] ) );
        $decoded = json_decode( stripslashes( $raw ), true );
        if ( is_array( $decoded ) ) {
            $count = count( $decoded );
        }
    }

    $badge_style = $count > 0 ? '' : ' style="display:none;"';
    $label       = esc_attr__( 'Compare Products', 'th-product-compare' );

    $html  = '<span class="th-compare-icon-widget" role="button" tabindex="0"';
    $html .= ' aria-label="' . $label . '"';
    $html .= ' style="background:' . esc_attr( $bg ) . ';color:' . esc_attr( $color ) . ';">';
    $html .= '<span class="th-compare-icon-widget-count"' . $badge_style . '>' . intval( $count ) . '</span>';
    $html .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">';
    $html .= '<path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path>';
    $html .= '<path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path>';
    $html .= '<path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>';
    $html .= '</svg>';
    $html .= '</span>';

    if ( $echo ) {
        echo wp_kses( $html, th_product_compare::$allowKsesAttr );
        return;
    }
    return wp_kses( $html, th_product_compare::$allowKsesAttr );
}
endif;

/* Output compare icon in WordPress navigation menu when enabled */
add_filter( 'wp_nav_menu_items', 'thpc_compare_icon_in_nav_menu', 10, 2 );
function thpc_compare_icon_in_nav_menu( $items, $args ) {
    if ( ! class_exists( 'WooCommerce' ) ) { return $items; }
    $option = th_product_compare::get_cached_option();
    if ( ! isset( $option['field-menu-icon-in-menu'] ) || $option['field-menu-icon-in-menu'] !== '1' ) { return $items; }
    $icon = thpc_compare_menu_icon( false );
    if ( $icon ) {
        $items .= '<li class="menu-item th-menu-compare-icon-item">' . $icon . '</li>';
    }
    return $items;
}

/* Output floating fixed icon via wp_footer when enabled */
add_action( 'wp_footer', 'thpc_compare_menu_icon_floating', 99 );
function thpc_compare_menu_icon_floating() {
    if ( ! class_exists( 'WooCommerce' ) ) { return; }
    $option = th_product_compare::get_cached_option();
    if ( ! isset( $option['field-menu-icon'] ) || $option['field-menu-icon'] !== '1' ) { return; }

    $bg    = isset( $option['icon-bg-color'] )    && $option['icon-bg-color']    ? sanitize_hex_color( $option['icon-bg-color'] )    : '#111827';
    $color = isset( $option['icon-svg-color'] )   && $option['icon-svg-color']   ? sanitize_hex_color( $option['icon-svg-color'] )   : '#ffffff';
    $badge = isset( $option['icon-badge-color'] ) && $option['icon-badge-color'] ? sanitize_hex_color( $option['icon-badge-color'] ) : '#ef4444';

    $count       = 0;
    $cookie_name = th_product_compare::cookieName();
    if ( ! empty( $_COOKIE[ $cookie_name ] ) ) {
        $raw     = sanitize_text_field( wp_unslash( $_COOKIE[ $cookie_name ] ) );
        $decoded = json_decode( stripslashes( $raw ), true );
        if ( is_array( $decoded ) ) {
            $count = count( $decoded );
        }
    }

    $badge_style = $count > 0 ? '' : ' style="display:none;"';
    $label       = esc_attr__( 'Compare Products', 'th-product-compare' );

    $float_pos = isset( $option['icon-float-position'] ) ? $option['icon-float-position'] : 'bottom-right';
    $pos_class = $float_pos === 'bottom-left' ? ' class="th-icon-bottom-left"' : '';
    echo '<div id="th-compare-icon-wrap"' . $pos_class . '>';
    echo '<span class="th-compare-icon-widget" role="button" tabindex="0"';
    echo ' aria-label="' . esc_attr( $label ) . '"';
    echo ' style="background:' . esc_attr( $bg ) . ';color:' . esc_attr( $color ) . ';">';
    echo '<span class="th-compare-icon-widget-count"' . wp_kses_post( $badge_style ) . '>' . intval( $count ) . '</span>';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">';
    echo '<path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path>';
    echo '<path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path>';
    echo '<path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>';
    echo '</svg>';
    echo '</span>';
    echo '</div>';
}
?>