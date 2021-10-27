<?php
if (!defined('ABSPATH')) exit;
class th_product_compare_return
{
    public $cookiesName = 'th_compare_product';
    public static function get()
    {
        return new self();
    }
    private function __construct()
    {
        add_action('wp_ajax_th_get_compare_product', array($this, 'get_products'));
        add_action('wp_ajax_nopriv_th_get_compare_product', array($this, 'get_products'));
    }


    public function get_products()
    {
        // echo "hello";
        // print_r($_COOKIE);
        // echo "<br>";
        // print_r($_POST);
        if (isset($_POST['product_id']) && intval($_POST['product_id'])) {
            $productID = intval($_POST['product_id']);
            $addREmove = sanitize_text_field($_POST['add_remove']);
            // echo "<br>";
            // echo $productID;
            $setID = $this->setId($productID, $addREmove);
            // echo json_encode($setID);
            // die();
            // return;
            if (!empty($setID)) {
                $html = $this->productHtml($setID);
                if (isset($setID['product_limit'])) {
                    $html['product_limit'] = __('Product Limit Exceeded.');
                }
                echo json_encode($html);
            } else {
                echo json_encode(['no_product' => 1]);
            }
        }
        die();
    }
    private function productHtml($setID)
    {
        $chekBYoption = $this->compareOption();
        // 'field-weight' => true,
        // 'field-dimension' => true,
        // 'field-size' => true,
        $table = '';
        $table .= '<table class="product-table-configure woocommerce">';

        if ($chekBYoption['field-image'] || $chekBYoption['field-title'] || $chekBYoption['field-price'] || $chekBYoption['field-add-to-cart']) {
            $trImage = '<tr class="image">
                    <td class="left-title"><span>' . __('Image', 'th-product-compare') . '</span></td>';
        }
        if ($chekBYoption['field-sku']) {
            $trSku_ = '<tr class="sku">
                    <td class="left-title"><span>' . __('SKU', 'th-product-compare') . '</span></td>';
        }
        if ($chekBYoption['field-availability']) {
            $trAvailability_ = '<tr class="availability">
                    <td class="left-title"><span>' . __('Availability', 'th-product-compare') . '</span></td>';
        }
        if ($chekBYoption['field-rating']) {
            $trRating_ = '<tr class="rating">
                    <td class="left-title"><span>' . __('Rating', 'th-product-compare') . '</span></td>';
        }
        if ($chekBYoption['field-description']) {
            $trDescription_ = '<tr class="th-description">
                    <td class="left-title"><span>' . __('Description', 'th-product-compare') . '</span></td>';
        }
        if ($chekBYoption['field-dimension']) {
            $trDimension_ = '<tr class="th-dimension">
                    <td class="left-title"><span>' . __('Dimension', 'th-product-compare') . '</span></td>';
        }
        if ($chekBYoption['field-repeat-price']) {
            $trRepeatPrice_ = '<tr class="th-price">
                    <td class="left-title"><span>' . __('Price', 'th-product-compare') . '</span></td>';
        }
        if ($chekBYoption['field-repeat-add-to-cart']) {
            $trRepeatAddTocart = '<tr class="th-add-to-cart">
                    <td class="left-title"><span>' . __('Add To Cart', 'th-product-compare') . '</span></td>';
        }
        $trDelete_ = '<tr class="th-delete">
                    <td class="left-title"><span>' . __('Remove', 'th-product-compare') . '</span></td>';

        foreach ($setID as $IDvalue) {
            $ProductID = intval($IDvalue);
            if ($ProductID) {
                $product = wc_get_product($ProductID);
                $price_ = '<span class="price_">' . $product->get_price_html() . '</span>';
                $Add_to_cart_ = '<span class="th-add-to-cart_">' . $this->add_to_cart($product) . '</span>';
                if (isset($trImage)) {
                    $div_ = '<div class="image-and-addcart">';
                    //image 
                    if ($chekBYoption['field-image']) {
                        $div_ .= '<div class="img_">' . $product->get_image() . '</div>';
                    }
                    // title 
                    if ($chekBYoption['field-title']) {
                        $div_ .= '<span class="product-title_">' . $product->get_name() . '</span>';
                    }
                    // price
                    if ($chekBYoption['field-price']) {
                        $div_ .= $price_;
                    }
                    // add to cart
                    if ($chekBYoption['field-add-to-cart']) {
                        $div_ .= $Add_to_cart_;
                    }
                    $div_ .= '</div>';
                    $trImage .= '<td>' . $div_ . '</td>'; //image
                }
                //sku
                if (isset($trSku_)) {
                    $sku = $product->get_sku();
                    $sku = $sku ? $sku : "-";
                    $trSku_ .= '<td><span>' . $sku . '</span></td>';
                }
                // availability
                if (isset($trAvailability_)) {
                    $productNumber  = $product->is_in_stock();
                    $productAvailbulity = __('Out Of Stock', 'th-product-compare');
                    $StockClass = 'th-out-of-stoct';
                    if ($productNumber) {
                        $productAvailbulity = __('in stock', 'th-product-compare');
                        $StockClass = 'th-in-stoct';
                    }
                    $trAvailability_ .= '<td class="' . $StockClass . ' ">' . $productAvailbulity . '</td>';
                }
                //rating
                if (isset($trRating_)) {
                    $rating_ = $this->productRating($product);
                    $rating_ = $rating_ ? $rating_ : "-";
                    $trRating_ .= '<td><span class="th-compare-rating">' . $rating_ . '</span></td>';
                }
                if (isset($trDescription_)) {
                    $description_ = $product->get_short_description();
                    $description_ = $description_ ? $description_ : "-";
                    $trDescription_ .= '<td><span>' . $description_ . '</span></td>';
                }
                //dimension
                if (isset($trDimension_)) {
                    $trDimension_ .= '<td><span>' . esc_html(wc_format_dimensions($product->get_dimensions(false)))  . '</span></td>';
                }
                //repeat price 
                if (isset($trRepeatPrice_)) {
                    $trRepeatPrice_ .= '<td>' . $price_ . '</td>';
                }
                //repeat add to cart 
                if (isset($trRepeatAddTocart)) {
                    $trRepeatAddTocart .= '<td>' . $Add_to_cart_ . '</td>';
                }
                // delete button 
                $trDelete_ .= '<td><button class="th-compare-product-remove" data-th-product-id="' . $ProductID . '"><i class="dashicons dashicons-dismiss"></i>' . __('Remove', 'th-product-compare')  . '</button></td>'; //dimension
            }
        }
        if (isset($trImage)) {
            $trImage .= '</tr>';
            $table .= $trImage;
        }
        if (isset($trSku_)) {
            $trSku_ .= '</tr>';
            $table .= $trSku_;
        }
        if (isset($trAvailability_)) {
            $trAvailability_ .= '</tr>';
            $table .= $trAvailability_;
        }
        if (isset($trRating_)) {
            $trRating_ .= '</tr>';
            $table .= $trRating_;
        }
        if (isset($trDescription_)) {
            $trDescription_ .= '</tr>';
            $table .= $trDescription_;
        }
        if (isset($trDimension_)) {
            $trDimension_ .= '</tr>';
            $table .= $trDimension_;
        }
        if (isset($trRepeatPrice_)) {
            $trRepeatPrice_ .= '</tr>';
            $table .= $trRepeatPrice_;
        }
        if (isset($trRepeatAddTocart)) {
            $trRepeatAddTocart .= '</tr>';
            $table .= $trRepeatAddTocart;
        }


        $trDelete_ .= '</tr>';
        $table .= $trDelete_;

        $table .= '</table>';


        $return = [
            'html' => $table,
        ];

        return $return;
    }
    private function compareOption()
    {
        $checkChecked = [
            'field-image' => true,
            'field-title' => true,
            'field-price' => true,
            'field-add-to-cart' => true,
            'field-rating' => true,
            'field-description' => true,
            'field-sku' => true,
            'field-availability' => true,
            'field-weight' => true,
            'field-dimension' => true,
            'field-size' => true,
            'field-repeat-price' => true,
            'field-repeat-add-to-cart' => true,
        ];
        $th_compare_option = get_option('th_compare_option');
        if (is_array($th_compare_option)) {
            foreach ($checkChecked as $key => $value) {
                if (isset($th_compare_option[$key])) {
                    if ($th_compare_option[$key] == '1') {
                        $checkChecked[$key] = true;
                    } else {
                        $checkChecked[$key] = false;
                    }
                }
            }
        }
        return $checkChecked;
    }
    public function add_to_cart($product)
    {
        $args = [];
        $defaults = array(
            'quantity'   => 1,
            'class'      => implode(
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
                'data-product_id'  => $product->get_id(),
                'data-product_sku' => $product->get_sku(),
                'aria-label'       => $product->add_to_cart_description(),
                'rel'              => 'nofollow',
            ),
        );

        $args = apply_filters('woocommerce_loop_add_to_cart_args', wp_parse_args($args, $defaults), $product);

        if (isset($args['attributes']['aria-label'])) {
            $args['attributes']['aria-label'] = wp_strip_all_tags($args['attributes']['aria-label']);
        }

        $AddTocartTxt = '%s';
        // if ($layout == 'layout_2' || $layout == 'layout_3') {
        //     $AddTocartTxt = '<span class="dashicons dashicons-cart"></span>';
        // } else if ($layout == 'layout_4') {
        //     $AddTocartTxt = '<span class="dashicons dashicons-cart"></span> %s';
        // }
        return apply_filters(
            'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
            sprintf(
                '<a href="%s" data-quantity="%s" class="th-compare-add-to-cart-btn %s" %s>' . $AddTocartTxt . '</a>',
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
        return wc_review_ratings_enabled() ? wc_get_rating_html($product->get_average_rating()) : '';
    }
    // cookies
    public function getPrevId()
    {
        if (isset($_COOKIE[$this->cookiesName]) && $_COOKIE[$this->cookiesName] != '') {
            $getPRoductId = sanitize_text_field($_COOKIE[$this->cookiesName]);
            return explode(',', $getPRoductId);
        }
    }
    function setId($id, $addREmove)
    {
        $previousCookie = $this->getPrevId();
        $cookieValue = $id;
        $updateCookie = true;
        $chekBYoption = get_option('th_compare_option');
        if ($addREmove == 'add') {
            if (!empty($previousCookie)) {
                // check limit 
                $checkLimit = 8;
                // $chekBYoption
                if (is_array($chekBYoption) && isset($chekBYoption['compare-product-limit']) && intval($chekBYoption['compare-product-limit'])) {
                    $checkLimit = intval($chekBYoption['compare-product-limit']);
                }
                $countProduct = count($previousCookie);
                $checkProduct = true;
                if ($countProduct <= ($checkLimit - 1)) {
                    $checkProduct = false;
                }
                $getExist = in_array($id, $previousCookie);

                // echo $checkLimit;
                // echo "<br>";
                // echo $id;
                // echo "<br>";
                // print_r($getExist);
                // echo "<br>";
                // print_r($previousCookie);
                // echo "<br>";
                // print_r($countProduct);
                // echo "<br>";
                // print_r($checkProduct);
                // echo "<br>";

                if ($getExist || $checkProduct) {
                    $cookieValue = implode(",", $previousCookie);
                    $updateCookie = false;
                    if ($checkProduct) {
                        $previousCookie['product_limit'] = 'product_limit';
                    }
                } else {
                    $cookieValue = implode(",", $previousCookie) . "," . $id;
                    $previousCookie[] = $id;
                }
            } else {
                $previousCookie[] = $id;
            }
        } else {
            if (!empty($previousCookie)) {
                $getExist = in_array($id, $previousCookie);
                if ($getExist) {
                    $findID = array_search($id, $previousCookie);
                    unset($previousCookie[$findID]);
                    if (count($previousCookie) > 0) {
                        $cookieValue = implode(",", $previousCookie);
                    } else {
                        $cookieValue = "";
                        $previousCookie = false;
                    }
                }
            } else {
                $previousCookie = false;
                $cookieValue = "";
            }
        }
        //   update cookies
        if ($updateCookie) {
            setcookie($this->cookiesName, $cookieValue, time() + (86400), "/"); // 86400 = 1 day
        }
        return $previousCookie;
    }
    // class end
}


// setcookie("th_compare_product", '', time() + (86400), "/"); // 86400 = 1 day
// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day