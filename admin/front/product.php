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
            // echo "<pre>";
            // print_r($setID);
            // echo "</pre>";
            // return;

            if (!empty($setID)) {
                $table = '';

                $table .= '<table class="product-table-configure">';
                $trImage = '<tr class="image">
                        <td class="left-title"><span>Image</span></td>';
                $trSku_ = '<tr class="sku">
                        <td class="left-title"><span>SKU</span></td>';
                $trRating_ = '<tr class="rating">
                        <td class="left-title"><span>Rating</span></td>';
                $trDescription_ = '<tr class="th-description">
                        <td class="left-title"><span>Description</span></td>';
                $trDimension_ = '<tr class="th-dimension">
                        <td class="left-title"><span>Dimension</span></td>';
                $trDelete_ = '<tr class="th-delete">
                        <td class="left-title"><span>Remove</span></td>';

                foreach ($setID as $IDvalue) {
                    $ProductID = intval($IDvalue);
                    if ($ProductID) {
                        $product = wc_get_product($ProductID);

                        $rating_ = $this->productRating($product);
                        $rating_ = $rating_ ? $rating_ : "-";

                        $sku = $product->get_sku();
                        $sku = $sku ? $sku : "-";

                        $description_ = $product->get_short_description();
                        $description_ = $description_ ? $description_ : "-";

                        $div_ = '<div class="image-and-addcart">';
                        $div_ .= '<div class="img_">' . $product->get_image() . '</div>';
                        $div_ .= '<span class="product-title_">' . $product->get_name() . '</span>';
                        $div_ .= '<span class="price_">' . $product->get_price_html() . '</span>';
                        $div_ .= '<span class="th-add-to-cart_">' . $this->add_to_cart($product) . '</span>';
                        $div_ .= '</div>';
                        $trImage .= '<td>' . $div_ . '</td>'; //image
                        $trSku_ .= '<td><span>' . $sku . '</span></td>'; //sku
                        $trRating_ .= '<td><span class="th-compare-rating">' . $rating_ . '</span></td>'; //rating
                        $trDescription_ .= '<td><span>' . $description_ . '</span></td>'; //add to cart
                        $trDimension_ .= '<td><span>' . esc_html(wc_format_dimensions($product->get_dimensions(false)))  . '</span></td>'; //dimension
                        $trDelete_ .= '<td><button class="th-compare-product-remove" data-th-product-id="' . $ProductID . '"><i class="dashicons dashicons-dismiss"></i>' . __('Remove', 'th-product-compare')  . '</button></td>'; //dimension
                    }
                }

                $trImage .= '</tr>';
                $trSku_ .= '</tr>';
                $trRating_ .= '</tr>';
                $trDescription_ .= '</tr>';
                $trDimension_ .= '</tr>';
                $trDelete_ .= '</tr>';

                $table .= $trImage;
                $table .= $trSku_;
                $table .= $trRating_;
                $table .= $trDescription_;
                $table .= $trDimension_;
                $table .= $trDelete_;

                $table .= '</table>';

                echo $table;
            } else {
                echo 'no_product';
            }
        }
        die();
    }
    function add_to_cart($product)
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
        if ($addREmove == 'add') {
            if (!empty($previousCookie)) {
                // check limit 
                
                $getExist = in_array($id, $previousCookie);
                if ($getExist) {
                    $cookieValue = implode(",", $previousCookie);
                    $updateCookie = false;
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