<?php
if (!defined('ABSPATH')) exit;

class th_product_compare_return
{
    public $cookiesName;

    function __construct()
    {
        $this->cookiesName = th_product_compare::cookieName();
    }

    public static function get()
    {
        (new self)->get_();
    }

    function custom_field_name(){
            return  apply_filters( 'th-product-compare-field', array());       
             }

    function custom_field($chekBYoption){   
                    
                    if(!empty($this->custom_field_name())){
                        foreach($this->custom_field_name() as $key=>$value){
                        $chekBYoption[$value['field_key']] = ["active" => 1];
                        }
                    }
                    
                return $chekBYoption;

    }

    public function get_()
    {
        add_action('wp_ajax_tpcp_get_compare_product', array($this, 'get_products'));
        add_action('wp_ajax_nopriv_tpcp_get_compare_product', array($this, 'get_products'));
    }

    public function all_cookie_id_remove()
    {
        $cookieId = $this->getPrevId();
        if (!empty($cookieId)) {
            setcookie($this->cookiesName, json_encode([]), time() + (86400), "/");
        }
    }

    public function get_products()
    {
        if (isset($_POST['product_id'])) {
            $productID = $_POST['product_id'] === 'refresh' ? 'refresh' : intval($_POST['product_id']);
            $addREmove = sanitize_text_field($_POST['add_remove']);
            $setID = $this->setId_cookie($productID, $addREmove);

            if (!empty($setID['ids'])) {
                if ($_POST['product_id'] === 'refresh' && $_POST['add_remove'] === 'removeall') {
                    $this->all_cookie_id_remove();
                    wp_send_json_success('all_removed');
                } else if ($addREmove == 'single_page' || isset($setID['single_page'])) {
                    if ($productID !== 'refresh') {
                        $buttonUrl = esc_url($this->getUrl());
                        wp_send_json_success(['url' => $buttonUrl, 'single_page' => 1]);
                    } else {
                        wp_send_json_success(['refresh' => 'single_page']);
                    }
                } else {
                    $setID_ = $setID['ids'];
                    $html = $this->productHtml($setID_);
                    if (isset($setID['product_limit'])) {
                        $html['product_limit'] = esc_html__('Product Limit Exceeded.', 'th-product-compare');
                    }
                     wp_send_json_success($html);
                }
            } else {
                $this->all_cookie_id_remove();
                $sendResponse = isset($setID['remove_all']) ? 'all_removed' : 'no_product';
                wp_send_json_success($sendResponse);
            }
        }
        die();
    }

    public function getUrl()
    {
        $query = new WP_Query([
            "name" => 'th-product-compare-custom-post',
            "post_type" => 'page',
            "post_status" => 'publish',
            "posts_per_page" => 1
        ]);
        if ($query->have_posts()) {
            $queryPost = reset($query->posts);
            return get_permalink($queryPost->ID);
        }
        return home_url();
    }

    public function productRowTitle($name_ = '')
    {
        $left_sidebar_title = '';
        if ('title' == $name_) {
            $left_sidebar_title = esc_html__("Title", 'th-product-compare');
        } elseif ('price' == $name_) {
            $left_sidebar_title = esc_html__("Price", 'th-product-compare');
        } else if ('rating' == $name_) {
            $left_sidebar_title = esc_html__("Rating", 'th-product-compare');
        } else if ('add-to-cart' == $name_) {
            $left_sidebar_title = esc_html__("Add To Cart", 'th-product-compare');
        } else if ('description' == $name_) {
            $left_sidebar_title = esc_html__("Description", 'th-product-compare');
        } else if ('availability' == $name_) {
            $left_sidebar_title = esc_html__("Availability", 'th-product-compare');
        }else if(isset($this->custom_field_name()[$name_]['title'])){
                 $left_sidebar_title = $this->custom_field_name()[$name_]['title']; // custom field
        }

        return $left_sidebar_title;
    }

    public function productHtml($setID, $type_ = [])
    {

        $product_details_keys = array(
    'image',
    'title',
    'SKU',
    'price',
    'add-to-cart',
);

        $removeBtn = true;
        if (isset($type_['remove_btn'])) {
            $removeBtn = $type_['remove_btn'];
        }
        $chekBYoption = $this->compareOption();
        $checkAddFooter = $chekBYoption['footer-bar'];
        $footerProduct = "";
        $footerClass = $checkAddFooter ? 'with-footer-bar' : 'without-footer-bar';
        $wp_is_mobile = wp_is_mobile();
        $tablestyle_responsive = $chekBYoption['tablestyle-in-mobile'];

        if ($wp_is_mobile) {
            $styleVariant = ($tablestyle_responsive === 'desktop') ? 'style-desktop' : 'style-mobile';
            $mobileClass = 'th-mobile-type-display mobile-flex ' . $styleVariant;
        } else {
            $mobileClass = 'th-desktop-type-displey';
        }

        $showRemoveIcon = !$wp_is_mobile || $chekBYoption['field-mobile-remove-icon'];

        $table = sprintf('<table class="product-table-configure woocommerce %s %s">', $mobileClass, $footerClass);
        $initTitleAndRow = [];

        $checkLimit = isset($chekBYoption['compare-product-limit']) && intval($chekBYoption['compare-product-limit']) ? intval($chekBYoption['compare-product-limit']) : 8;



        if (!empty($chekBYoption['attributes'])) {
foreach ($this->custom_field($chekBYoption['attributes']) as $title_key => $title_value) {

    // 🔒 Skip only merged fields
    if (in_array($title_key, $product_details_keys, true)) {
        continue;
    }

    if ($title_value['active'] == 1) {
        unset($title_value['active']);

        $checkCustomAttr = isset($title_value['custom']);
        $name_ = $checkCustomAttr ? $title_value['label'] : $title_key;

        $putHtml = '';
       
            $putHtml .= '<tr class="_' . esc_attr($title_key) . '_"><td class="left-title">';
            if ($name_ != 'image') {
                $left_sidebar_title = !$checkCustomAttr
                    ? $this->productRowTitle($name_)
                    : esc_html__($name_, 'th-product-compare');

                $putHtml .= '<span>' . esc_html($left_sidebar_title) . '</span>';
            }
            $putHtml .= '</td>';
        

        $title_value['html'] = $putHtml;
        $initTitleAndRow[$title_key] = $title_value;
    }
}
$pd_html = '';

if ($wp_is_mobile) {
   $pd_html .= '<tr class="_product_details_"><td class="left-title">';
    $pd_html .= '<span>' . esc_html__('Product Details', 'th-product-compare') . '</span>';
    $pd_html .= '</td>';
} else {
    $pd_html .= '<tr class="_product_details_"><td class="left-title">';
    $pd_html .= '<span>' . esc_html__('Product Details', 'th-product-compare') . '</span>';
    $pd_html .= '</td>';
}

// Add row at TOP (before others)
$initTitleAndRow = array_merge(
    array(
        'product_details' => array(
            'html' => $pd_html,
            'type' => 'product_details',
        ),
    ),
    $initTitleAndRow
);

        }


         if ($chekBYoption['field-repeat-price']) {
             $trRepeatPrice_ = '<tr class="th-price">
                    <td class="left-title"><span>' . esc_html__('Price', 'th-product-compare') . '</span></td>';
            
        }
        if ($chekBYoption['field-repeat-add-to-cart']) {
             $trRepeatAddTocart = '<tr class="th-add-to-cart">
                     <td class="left-title"><span>' . esc_html__('Add To Cart', 'th-product-compare') . '</span></td>';
            
        }
        if ($removeBtn) {
           $trDelete_ = '<tr class="th-delete">
                     <td class="left-title"><span>' . esc_html__('Remove', 'th-product-compare') . '</span></td>';
            
        }

        $categoryShow = [];
        $countProductsForFooter = 7;
        if ($chekBYoption['field-dynamic-attribute']) {
            $customAttr = [];
        }

        $add_TR_AT_last = 0;
        $count_length_last = count($setID);

        foreach ($setID as $IDvalue) {
            if ($IDvalue === false) continue;
            $ProductID = intval($IDvalue);
            if ($ProductID) {
                $product = wc_get_product($ProductID);
                if (!$product) continue;
                $countProductsForFooter++;
                $add_TR_AT_last++;
                $CheckLAstProduct = $count_length_last == $add_TR_AT_last;
                $categoryClassForHide = '';
                if ($chekBYoption['field-show-by-category']) {
                    $product_category = get_the_terms($ProductID, 'product_cat');
                    if (!empty($product_category)) {
                        $categoryClassForHide = 'thcpr-by-all';
                        foreach ($product_category as $term_category) {
                            $raw_slug   = $term_category->slug;        
                            $safe_slug  = sanitize_title($raw_slug);  

                            // fallback (100% safe)
                                $safe_slug = 'cat-' . $term_category->term_id;
                            // store
                            $categoryShow[$safe_slug] = $term_category->name;

                            // td class
                            $categoryClassForHide .= ' thcpr-by-' . $safe_slug;

                        }
                    }
                }

                $price_ = '<span class="price_">' . $product->get_price_html() . '</span>';
                $Add_to_cart_ = '<div class="th-add-to-cart_"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart" aria-hidden="true"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>' . $this->add_to_cart($product) . '</div>';
                $link_ = esc_html(get_permalink($ProductID));

                if (isset($customAttr)) {
                    $keepKeyPid = 'pid-' . $ProductID;
                    $customAttr[$keepKeyPid]['attr-value'] = [];
                    $customAttr[$keepKeyPid]['class'] = $categoryClassForHide;
                    $customAttr_ = get_post_meta($ProductID, '_product_attributes', true);
                    if (!empty($customAttr_)) {
                        foreach ($customAttr_ as $Fillkey => $Fillvalue) {
                            if (stripos($Fillkey, 'pa_') !== 0) {
                                $customAttr[$keepKeyPid]['attr-value'][$Fillvalue['name']] = $Fillvalue['value'];
                                $customAttr['has_custom_attr'] = ($customAttr['has_custom_attr'] ?? 0) + 1;
                            }
                        }
                    }
                }
                foreach ($initTitleAndRow as $initTitleAndRow_key => $initTitleAndRow_value) {
                    $addMoreHtml = '';
                    if ($initTitleAndRow_key === 'product_details') {

    $attrs = $chekBYoption['attributes'];
    $addMoreHtml  = '<div class="pc-product-details">';

    // IMAGE
    if ( isset( $attrs['image'] ) && $attrs['image']['active'] == 1 ) {
        $addMoreHtml .= '<div class="_image_"><div class="image-and-addcart"><div class="img_">';
        if ( $showRemoveIcon ) {
            $addMoreHtml .= '<button class="th-compare-product-remove th-img-remove-btn" data-th-product-id="' . esc_attr( $ProductID ) . '"><i class="dashicons dashicons-no-alt"></i></button>';
        }
        $addMoreHtml .= '<a target="_blank" href="' . $link_ . '">' . $product->get_image() . '</a>';
        $addMoreHtml .= '</div></div></div>';
    }

    // TITLE
    if ( isset( $attrs['title'] ) && $attrs['title']['active'] == 1 ) {
        $addMoreHtml .= '<div class="_title_"><div class="product-title_"><a target="_blank" href="' . $link_ . '">' . esc_html($product->get_name()) . '</a></div></div>';
    }

    // SKU
    if ( isset( $attrs['SKU'] ) && $attrs['SKU']['active'] == 1 ) {
        $sku = $product->get_sku();
        if ( ! empty( $sku ) ) {
            $addMoreHtml .= '<div class="_SKU_">' . esc_html( $sku ) . '</div>';
        } else {
            $addMoreHtml .= '<div class="_SKU_">-</div>';
        }
    }

    // PRICE
    if ( isset( $attrs['price'] ) && $attrs['price']['active'] == 1 ) {
        $addMoreHtml .= '<div class="_price_"><div class="price_">' . $price_ . '</div></div>';
    }

    // ADD TO CART
    if ( isset( $attrs['add-to-cart'] ) && $attrs['add-to-cart']['active'] == 1 ) {
        $addMoreHtml .= '<div class="_add-to-cart_">' . $Add_to_cart_ . '</div>';
    }

    $addMoreHtml .= '</div>';

    $addHtml = '<td class="' . $categoryClassForHide . '">' . $addMoreHtml . '</td>';
    if ($CheckLAstProduct) $addHtml .= '</tr>';

    $initTitleAndRow_value['html'] .= $addHtml;
    $initTitleAndRow[$initTitleAndRow_key] = $initTitleAndRow_value;

    continue;
}

                    $rowMobileTitle = ($initTitleAndRow_key != 'image') ? $this->productRowTitle($initTitleAndRow_key) : '';
                    if ($initTitleAndRow_key == 'image') {
                        $addMoreHtml .= '<div class="image-and-addcart"><div class="img_"><a target="_blank" href="' . $link_ . '">' . $product->get_image() . '</a></div></div>';
                    } elseif ($initTitleAndRow_key == 'title') {
                        $addMoreHtml .= '<div class="mobile-title">' . $rowMobileTitle . '</div><span class="product-title_"><a target="_blank" href="' . $link_ . '">' . esc_html($product->get_name()) . '</a></span>';
                    } elseif ($initTitleAndRow_key == 'price') {
                        $addMoreHtml .= '<div class="mobile-title">' . $rowMobileTitle . '</div>' . $price_;
                    } elseif ($initTitleAndRow_key == 'add-to-cart') {
                        $addMoreHtml .= $Add_to_cart_;
                    } elseif ($initTitleAndRow_key == 'SKU') {
                        $sku = $product->get_sku() ?: "-";
                        $addMoreHtml .= '<div class="mobile-title">' . $rowMobileTitle . '</div><span>' . $sku . '</span>';
                    } elseif ($initTitleAndRow_key == 'availability') {
                        $stockClass = $product->is_in_stock() ? 'th-in-stoct' : 'th-out-of-stoct';
                        $stockText = $product->is_in_stock() ? esc_html__('in stock', 'th-product-compare') : esc_html__('out of stock', 'th-product-compare');
                        $addMoreHtml .= '<div class="mobile-title">' . $rowMobileTitle . '</div><span class="' . $stockClass . '">' . $stockText . '</span>';
                    } elseif ($initTitleAndRow_key == 'rating') {
                        $rating_ = $this->productRating($product) ?: "-";
                        $addMoreHtml .= '<div class="mobile-title">' . $rowMobileTitle . '</div><span class="th-compare-rating">' . $rating_ . '</span>';
                    } elseif ($initTitleAndRow_key == 'description') {

                        $desc = $product->get_short_description();
                        $desc = $desc ? wp_strip_all_tags($desc) : '-';

                        $limit = 120;

                        if ($desc !== '-' && mb_strlen($desc) > $limit) {

                            $short = mb_substr($desc, 0, $limit);
                            $rest  = mb_substr($desc, $limit);

                            $descHtml  = '<div class="desc-short">' . esc_html($short) . '</div>';
                            $descHtml .= '<div class="desc-more" style="display:none;">' . esc_html($rest) . '</div>';
                            $descHtml .= ' <a href="#" class="th-read-more" data-state="collapsed">'
                                       . esc_html__('Read more', 'th-product-compare')
                                       . '</a>';

                        } else {
                            // OLD behavior preserved
                            $descHtml = esc_html($desc);
                        }

                        $addMoreHtml .= '<div class="mobile-title">' . $rowMobileTitle . '</div>
                                         <div class="description-text">' . $descHtml . '</div>';
                    }elseif (isset($initTitleAndRow_value['custom'])) {
                        $customAttrGlobal = $product->get_attribute($initTitleAndRow_key) ?: '-';
                        $addMoreHtml .= '<div class="mobile-title">' . $rowMobileTitle . '</div><span>' . $customAttrGlobal . '</span>';
                    }else{
                         $customValue = get_post_meta( $ProductID,$initTitleAndRow_key, true ) ?: '-';
                        $addMoreHtml .= '<div class="mobile-title">' . $rowMobileTitle . '</div><span>' . $customValue . '</span>';   
                    }
                    $addHtml = '<td class="' . $categoryClassForHide . '">' . $addMoreHtml . '</td>';
                    if ($CheckLAstProduct) $addHtml .= '</tr>';
                    $initTitleAndRow_value['html'] .= $addHtml;
                    $initTitleAndRow[$initTitleAndRow_key] = $initTitleAndRow_value;
                }

                if (isset($trRepeatPrice_)) {
                    $trRepeatPrice_ .= '<td class="' . $categoryClassForHide . '">' . $price_ . '</td>';
                    if ($CheckLAstProduct) $trRepeatPrice_ .= '</tr>';
                }
                if (isset($trRepeatAddTocart)) {
                    $trRepeatAddTocart .= '<td class="' . $categoryClassForHide . '">' . $Add_to_cart_ . '</td>';
                    if ($CheckLAstProduct) $trRepeatAddTocart .= '</tr>';
                }
                if (isset($trDelete_)) {
                    $trDelete_ .= '<td class="' . $categoryClassForHide . '"><button class="th-compare-product-remove" data-th-product-id="' . $ProductID . '"><i class="dashicons dashicons-dismiss"></i>' . esc_html__('Remove', 'th-product-compare') . '</button></td>';
                    if ($CheckLAstProduct) $trDelete_ .= '</tr>';
                }

                if ($checkAddFooter) {
                    $footerProduct .= '<div data-product-id="' . $ProductID . '" class="img_">';
                    $footerProduct .= '<i class="th-remove-product th-compare-product-remove" data-th-product-id="' . $ProductID . '"></i>';
                    $footerProduct .= '<a target="_blank" href="' . $link_ . '">' . $product->get_image() . '</a></div>';
                }
            }
        }

        $th_product_atleast_txt = $chekBYoption['compare-atleast-text'];
        // regex: {text}
        preg_match_all('/\{([^}]+)\}/', $th_product_atleast_txt, $matches);

        // Default fallback
        $first_text  = $matches[1][0] ?? '';
        $second_text = $matches[1][1] ?? '';
        

        $compare_product_limit = $chekBYoption['compare-product-limit'];
        if ($checkAddFooter) {
            $emptySlots = max(0, $compare_product_limit - $countProductsForFooter);
            for ($i = 0; $i < $emptySlots; $i++) {
                $footerProduct .= '<div class="img_ empty-slot"></div>';
            }
        }

        foreach ($initTitleAndRow as $row) {
            $table .= $row['html'];
        }
        if (isset($customAttr['has_custom_attr'])) {
            // Keep custom attr code unchanged
        }
        if (isset($trRepeatPrice_)) $table .= $trRepeatPrice_;
        if (isset($trRepeatAddTocart)) $table .= $trRepeatAddTocart;
        if (isset($trDelete_)) $table .= $trDelete_;
        $table .= '</table>';

        $return = ['html' => $table,'compare_limit' => $checkLimit];
        if ($checkAddFooter) {
            $return['footer_bar'] = wp_kses(
                "<div class='th-compare-footer-wrap active position-" . $chekBYoption['compare-popup-position'] . "'><div class='th-compare-footer-level2'><div class='th-compare-footer-level3'>" .
                "<div class='th-compare-left'><button class='th-footer-up-down' data-text='" . $chekBYoption['compare-opener-btn-text'] . "'>" .
                "<span class='text_'>" . $chekBYoption['compare-opener-btn-text'] . "</span>" .
                "<span class='icon_2 dashicons dashicons-arrow-up-alt2'></span></button>" . 
                "<p class='th-atleast'><span class='th-selected'>".$first_text."</span><span class='th-select-count'>" . $second_text . "</span></p>" .
                "<div class='product_image'>" . $footerProduct . "</div>" .
                 "<div class='th-addremove'><a href='#' class='th-add-product-bar'><i class='dashicons dashicons-plus'></i></a><span class='th-compare-limit-count' data-th-tooltip='" . $countProductsForFooter . " of " . $compare_product_limit . " products added'><span class='th-current-count'>" . $countProductsForFooter . "</span>/<span class='th-max-count'>" . $compare_product_limit . "</span></span></div></div>" .

                "<div class='th-compare-right'><a id='thpc-removeall'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-trash2 lucide-trash-2' aria-hidden='true'><path d='M10 11v6'></path><path d='M14 11v6'></path><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6'></path><path d='M3 6h18'></path><path d='M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path></svg></a>" .
                "<div class='th-compare-enable'><a href='#' class='th-compare-footer-product-opner'>" .
                "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-layers text-indigo-600' aria-hidden='true'><path d='M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z'></path><path d='M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12'></path><path d='M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17'></path></svg><span class='text_'>" . esc_html__('Compare', 'th-product-compare') . "</span></a></div></div></div></div></div>",
                th_product_compare::$allowKsesAttr
            );
        }

        if (isset($chekBYoption['compare-menu-tab']) && $chekBYoption['compare-menu-tab'] === '1') {
            $tab_position  = isset($chekBYoption['compare-menu-tab-position']) ? sanitize_html_class($chekBYoption['compare-menu-tab-position']) : 'left';
            $tab_text      = isset($chekBYoption['compare-menu-tab-text']) ? sanitize_text_field($chekBYoption['compare-menu-tab-text']) : esc_html__('Compare', 'th-product-compare');
            $tab_bg_color  = isset($chekBYoption['tab-bg-color'])   && $chekBYoption['tab-bg-color']   ? sanitize_hex_color($chekBYoption['tab-bg-color'])   : '#111827';
            $tab_txt_color = isset($chekBYoption['tab-text-color']) && $chekBYoption['tab-text-color'] ? sanitize_hex_color($chekBYoption['tab-text-color']) : '#ffffff';
            $tab_inline_style = "--tab-bg:" . esc_attr($tab_bg_color) . ";--tab-color:" . esc_attr($tab_txt_color) . ";";
            $return['menu_tab'] = wp_kses(
                "<div class='th-compare-menu-tab th-menu-tab-position-" . $tab_position . "' id='th-compare-menu-tab' style='" . $tab_inline_style . "'>" .
                "<button class='th-menu-tab-btn th-compare-footer-product-opner'>" .
                "<svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' aria-hidden='true'><path d='M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z'></path><path d='M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12'></path><path d='M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17'></path></svg>" .
                "<span class='th-menu-tab-text'>" . esc_html($tab_text) . "</span>" .
                "<span class='th-menu-tab-badge'>" . intval($add_TR_AT_last) . "</span>" .
                "</button></div>",
                th_product_compare::$allowKsesAttr
            );
        }

        if (!empty($chekBYoption['field-menu-icon'])) {
            $icon_bg    = isset($chekBYoption['icon-bg-color'])    && $chekBYoption['icon-bg-color']    ? sanitize_hex_color($chekBYoption['icon-bg-color'])    : '#111827';
            $icon_color = isset($chekBYoption['icon-svg-color'])   && $chekBYoption['icon-svg-color']   ? sanitize_hex_color($chekBYoption['icon-svg-color'])   : '#ffffff';
            $icon_badge = isset($chekBYoption['icon-badge-color']) && $chekBYoption['icon-badge-color'] ? sanitize_hex_color($chekBYoption['icon-badge-color']) : '#ef4444';
            $icon_badge_style = $add_TR_AT_last > 0 ? '' : ' style="display:none;"';
            $return['compare_icon'] = wp_kses(
                "<span class='th-compare-icon-widget' role='button' tabindex='0'" .
                " style='background:" . esc_attr($icon_bg) . ";color:" . esc_attr($icon_color) . ";'>" .
                "<span class='th-compare-icon-widget-count'" . $icon_badge_style . ">" . intval($add_TR_AT_last) . "</span>" .
                "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' aria-hidden='true'><path d='M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z'></path><path d='M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12'></path><path d='M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17'></path></svg>" .
                "</span>",
                th_product_compare::$allowKsesAttr
            );
        }

         if (isset($chekBYoption['field-highlight-btn']) && $chekBYoption['field-highlight-btn'] == '1' ) {
            $highlighTsProducts = '<div class="th-heighlights-products">';
            $highlighTsProducts .= '<div class="th-hide-similarities">' . esc_html__('Hide Similarities', 'th-product-compare') . '</div>';
            $highlighTsProducts .= '<div class="th-highlight-difference">' . esc_html__('Highlight Differences', 'th-product-compare') . '</div>';
            $highlighTsProducts .= '</div>';

            $return['add_highlights'] = wp_kses($highlighTsProducts, th_product_compare::$allowKsesAttr);
        }
        
        if (!empty($categoryShow))  {
            $return['category'] = wp_kses($this->navigationCate($categoryShow), th_product_compare::$allowKsesAttr);
        }
        return $return;
    }

    public function navigationCate($categoryShow)
    {
        $categoryShow_count = count($categoryShow);
        $returnCateHtml = '<div class="wrap-category_"><div class="wrap-category_inner">';
        if ($categoryShow_count > 1) {
            $returnCateHtml .= '<a href="#" data-compare-category="all" class="active">' . esc_html__('All', 'th-product-compare') . '</a>';
        }
        foreach ($categoryShow as $categoryShow_key => $categoryShow_value) {
            $returnCateHtml .= '<a href="#" data-compare-category="' . $categoryShow_key . '">' . esc_html($categoryShow_value) . '</a>';
        }
        $returnCateHtml .= '</div></div>';
        return $returnCateHtml;
    }

    private function compareOption()
    {
        $checkChecked = [
            'attributes' => [
                'image' => ["active" => 1],
                'title' => ["active" => 1],
                'rating' => ["active" => 1],
                'price' => ["active" => 1],
                'add-to-cart' => ["active" => 1],
                'description' => ["active" => 1],
                'availability' => ["active" => 1],
                'SKU' => ["active" => 1],
            ],
            'field-repeat-price' => false,
            'field-repeat-add-to-cart' => false,
            'field-show-by-category' => true,
            'field-dynamic-attribute' => false,
            'compare-popup-position' => 'bottom',
            'compare-opener-btn-text' => esc_html__('Product Compare', 'th-product-compare'),
            'compare-atleast-text' => '{Selected} {Products}',
            'compare-product-limit' => 8,
            'compare-limit-tooltip' => '',
            'footer-bar' => true,
            'tablestyle-in-mobile' => 'mobile-flex',
            'field-mobile-remove-icon' => true,
            'compare-menu-tab' => '0',
            'compare-menu-tab-position' => 'left',
            'compare-menu-tab-text' => esc_html__('Compare', 'th-product-compare'),
            'field-menu-icon' => '1',
            'icon-bg-color' => '#111827',
            'icon-svg-color' => '#ffffff',
            'icon-badge-color' => '#ef4444',
        ];
        $th_compare_option = th_product_compare::get_cached_option();
        if (is_array($th_compare_option)) {
            if (isset($th_compare_option['attributes'])) {
                $checkChecked['attributes'] = $th_compare_option['attributes'];
            }
            if (isset($th_compare_option['field-highlight-btn'])) {
                $checkChecked['field-highlight-btn'] = $th_compare_option['field-highlight-btn'];
            }

            if (isset($th_compare_option['tablestyle-in-mobile'])) {
                $checkChecked['tablestyle-in-mobile'] = $th_compare_option['tablestyle-in-mobile'];
            }
            
          foreach ($th_compare_option as $key => $val) {

    if ($key === 'attributes') {
        $checkChecked['attributes'] = $val;
        continue;
    }

    if ($key === 'compare-product-limit') {
        $checkChecked[$key] = intval($val);
        continue;
    }

    // checkbox / toggle fields
    if (in_array($key, [
        'field-repeat-price',
        'field-repeat-add-to-cart',
        'field-show-by-category',
        'field-dynamic-attribute',
        'footer-bar',
        'field-highlight-btn',
        'field-mobile-remove-icon',
        'field-menu-icon',
    ], true)) {
        $checkChecked[$key] = ($val === '1' || $val === 1 || $val === true);
        continue;
    }

    // ✅ tablestyle-in-mobile must stay STRING
    if ($key === 'tablestyle-in-mobile') {
        $checkChecked[$key] = sanitize_html_class($val);
        continue;
    }

    // text fields
    $checkChecked[$key] = $val;
}

        }
        return $checkChecked;
    }

    public function add_to_cart($product)
{
    // If product is already in the cart, show a "View Cart" button instead
    $in_cart = false;
    if ( function_exists('WC') && WC()->cart ) {
        foreach ( WC()->cart->get_cart() as $cart_item ) {
            if ( (int) $cart_item['product_id'] === (int) $product->get_id() ) {
                $in_cart = true;
                break;
            }
        }
    }

    if ( $in_cart ) {
        $cart_url = wc_get_cart_url();
        return '<a href="' . esc_url( $cart_url ) . '" class="th-compare-add-to-cart-btn th-in-cart button wc-forward">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart" aria-hidden="true"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                <span class="add-to-cart-text">' . esc_html__( 'View Cart', 'th-product-compare' ) . '</span>
            </a>';
    }

    $args = [];
    $defaults = array(
        'quantity' => 1,
        'class' => implode(
            ' ',
            array_filter(
                array(
                    'button',
                    'product_type_' . $product->get_type(),
                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                    $product->supports('ajax_add_to_cart') && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                )
            )
        ),
        'attributes' => array(
            'data-product_id' => $product->get_id(),
            'data-product_sku' => $product->get_sku(),
            'aria-label' => $product->add_to_cart_description(),
            'rel' => 'nofollow',
        ),
    );

    $args = apply_filters(
        'woocommerce_loop_add_to_cart_args',
        wp_parse_args($args, $defaults),
        $product
    );

    if (isset($args['attributes']['aria-label'])) {
        $args['attributes']['aria-label'] = wp_strip_all_tags($args['attributes']['aria-label']);
    }

    return apply_filters(
        'woocommerce_loop_add_to_cart_link',
        sprintf(
            '<a href="%s" data-quantity="%s" class="th-compare-add-to-cart-btn %s" %s>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart" aria-hidden="true"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                <span class="add-to-cart-text">%s</span>
            </a>',
            esc_url($product->add_to_cart_url()),
            esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
            esc_attr(isset($args['class']) ? $args['class'] : 'button'),
            isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
            esc_html($product->add_to_cart_text())
        ),
        $product,
        $args
    );
}


    public function productRating($product)
    {
        if (wc_review_ratings_enabled()) {
            $getRAtingHtml = wc_get_rating_html($product->get_average_rating());
            $count_rating = $product->get_rating_count();
            if ($getRAtingHtml && $count_rating > 0) {
                $rating_ = $getRAtingHtml;
                $rating_ .= "<div class='th-rating-count'>(" . $count_rating . esc_html__(' Review', 'th-product-compare') . ")</div>";
                return $rating_;
            }
        }
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
                    $decodeArray[] = th_product_compare::tpcp_decrypt($array_value);
                }
                return array_filter($decodeArray, function($value) { return $value !== false; });
            }
        }
        return [];
    }

    public function setId_cookie($id, $addREmove)
    {
        $previousCookie = $this->getPrevId();
        $updateCookie = true;
        $chekBYoption = th_product_compare::get_cached_option();
        $checkLimit = isset($chekBYoption['compare-product-limit']) && intval($chekBYoption['compare-product-limit']) ? intval($chekBYoption['compare-product-limit']) : 8;

        if ($addREmove == 'add' || $addREmove == 'single_page' || $id == 'refresh') {
            if (!empty($previousCookie)) {
                $countProduct = count($previousCookie);
                if ($countProduct >= $checkLimit && $id !== 'refresh') {
                    $previousCookie['product_limit'] = 'product_limit';
                    $updateCookie = false;
                } elseif (!in_array($id, $previousCookie) && $id !== 'refresh') {
                    array_unshift($previousCookie, $id);
                }
            } elseif ($id !== 'refresh') {
                $previousCookie[] = $id;
            }
        } else {
            if (!empty($previousCookie) && in_array($id, $previousCookie)) {
                $previousCookie = array_filter($previousCookie, function($value) use ($id) {
                    return $value != $id;
                });
                if (empty($previousCookie)) {
                    $previousCookie = [];
                }
            }
        }

        if ($updateCookie) {
            if (isset($previousCookie['product_limit'])) {
                unset($previousCookie['product_limit']);
            }
            $cookieValue = '';
            if (!empty($previousCookie)) {
                $arrayENcrypt = [];
                foreach ($previousCookie as $array_value) {
                    $arrayENcrypt[] = th_product_compare::tpcp_encrypt($array_value);
                }
                $cookieValue = json_encode($arrayENcrypt);
            }
            setcookie($this->cookiesName, $cookieValue, time() + (86400), "/");
        }

        $cloneIDS = $previousCookie;
        $previousCookie = ['ids' => $previousCookie];
        if (empty($cloneIDS) && $addREmove == 'remove') {
            $previousCookie['remove_all'] = true;
        }
        if (isset($chekBYoption['compare-appear-type']) && $chekBYoption['compare-appear-type'] == 'page') {
            $previousCookie['single_page'] = true;
        }
        return $previousCookie;
    }
}
?>