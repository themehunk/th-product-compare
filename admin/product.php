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
        print_r($_POST);
        if (isset($_POST['product_id']) && intval($_POST['product_id'])) {
            $productID = intval($_POST['product_id']);
            // echo "<br>";
            // echo $productID;
            $setID = $this->setId($productID);
            // echo "-cookie id-<br>";
            print_r($setID);
            // if (!empty($setID)) {
            //     foreach ($setID as $IDvalue) {
            //     }
            // }
        }
        die();
    }


    public function outHtml()
    {
        $html = '<table class="product-table-configure">
        <tr class="title">
            <td><span>title</span></td>
            <td><span>product 1</span></td>
            <td><span>product 2</span></td>
            <td><span>product 3</span></td>
            <td><span>product 4</span></td>
            <td><span>product 5</span></td>
            <td><span>product 6</span></td>
        </tr>
        <tr class="image">
            <td><span>image</span></td>
            <td><img src="' . TH_PRODUCT_URL . 'assets/img/image1.jpg' . '"></td>
            <td><img src="' . TH_PRODUCT_URL . 'assets/img/image2.jpg' . '"></td>
            <td><img src="' . TH_PRODUCT_URL . 'assets/img/image3.jpg' . '"></td>
            <td><img src="' . TH_PRODUCT_URL . 'assets/img/image4.jpg' . '"></td>
            <td><img src="' . TH_PRODUCT_URL . 'assets/img/image5.jpg' . '"></td>
            <td><img src="' . TH_PRODUCT_URL . 'assets/img/image1.jpg' . '"></td>
            
        </tr>
        <tr class="sku">
            <td><span>sku</span></td>
            <td><span>XS103</span></td>
            <td><span>XS1</span></td>
            <td><span>XS103</span></td>
            <td><span>XS104</span></td>
            <td><span>XS103</span></td>
            <td><span>XS103</span></td>
        </tr>
        <tr class="price">
            <td><span>Price</span></td>
            <td><span>$10</span></td>
            <td><span>$20</span></td>
            <td><span>$30</span></td>
            <td><span>$40</span></td>
            <td><span>$50</span></td>
            <td><span>$60</span></td>
        </tr>
    </table>';
    }

    // single product 
    public function get_product($productid, $options)
    {
    }
    // cookies

    public function getPrevId()
    {
        if (isset($_COOKIE[$this->cookiesName]) && $_COOKIE[$this->cookiesName] != '') {
            $getPRoductId = sanitize_text_field($_COOKIE[$this->cookiesName]);
            return explode(',', $getPRoductId);
        }
    }
    function setId($id)
    {
        $previousCookie = $this->getPrevId();
        $cookieValue = $id;
        $updateCookie = true;
        if (!empty($previousCookie)) {
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