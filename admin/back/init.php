<?php
if (!defined('ABSPATH')) exit;
class th_compare_admin
{
    public $tpcp_optionName = 'th_compare_option';
    private static $instance;
    private function __construct()
    {
        add_action('wp_ajax_tpcp_compare_save_data', array($this, 'save'));
        add_action('wp_ajax_tpcp_compare_reset_data', array($this, 'reset'));
        add_action('wp_ajax_tpcp_filter_product', array($this, 'filter_product'));
        add_action('wp_ajax_nopriv_tpcp_filter_product', array($this, 'filter_product'));
        // product tab
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            add_filter('woocommerce_product_data_tabs', [$this, 'tpcp_tab_custom']);
            add_action('woocommerce_product_data_panels', [$this, 'tpcp_custom_template']);
        }
        add_action('woocommerce_process_product_meta', [$this, 'tpcp_save_input'], 10, 2);
        // product tab
    }
    public function check_user_permission()
    {
        $user = wp_get_current_user();
        $allowed_roles = array('editor', 'administrator');
        return array_intersect($allowed_roles, $user->roles) ? true : false;
    }
    public static function get()
    {
        return self::$instance ? self::$instance : self::$instance = new self();
    }
    public function filter_product()
    {
        if (isset($_POST['inputs'])) {
            $text_ = sanitize_text_field($_POST['inputs']);
            $arrArg = array(
                'post_type'     => 'product',
                'post_status'   => 'publish',
                'posts_per_page' => 20,
            );
            if ($text_ != '') {
                $arrArg['s'] = $text_;
            }
            $results = new WP_Query($arrArg);
            $items = array();
            if (!empty($results->posts)) {
                foreach ($results->posts as $result) {
                    $productId = $result->ID;
                    $imageUrl = wp_get_attachment_image_src(get_post_thumbnail_id($productId), 'single-post-thumbnail');
                    $imageUrl = isset($imageUrl[0]) ? $imageUrl[0] : wc_placeholder_img_src();

                    $items[] = array(
                        'image_url' => esc_url($imageUrl),
                        'label' => $result->post_title,
                        'id' => $productId,
                    );
                }
            } else {
                $items['no_product'] = esc_html__('No Product Found', 'th-product-compare-pro');
            }
            wp_send_json_success($items);
        }
    }

    public function save()
    {
        if ($this->check_user_permission() && isset($_POST['inputs']) && is_array($_POST['inputs']) && !empty($_POST['inputs'])) {
            check_ajax_referer('tpcp_plugin_nonce', 'tpcp_nonce_created');
            $result = $this->setOption($_POST['inputs']);
            th_product_compare::clear_cached_option();
            $send = $result ? true : false;
            wp_send_json_success($send);
        }
        die();
    }
    // cookies
    public function setOption($inputs)
    {
        $checkOption = get_option($this->tpcp_optionName);
        $saveOption = $this->sanitizeOptions($inputs);
        $saveOption = $this->apply_locked_settings( $saveOption );
        if ($checkOption) {
            $result = update_option($this->tpcp_optionName, $saveOption);
        } else {
            $result = add_option($this->tpcp_optionName, $saveOption);
        }
        return $result;
    }

    function sanitizeOptions($array)
    {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = $this->sanitizeOptions($value);
            } else {
                $value = sanitize_text_field($value);
            }
        }
        return $array;
    }

    private function get_locked_settings() {

        return [

            'compare-product-limit' => 4,

            'compare-at-shop-hook' => 'after',

            'close-popup-on-addtocart' => '0',

            'field-product-single-page' => '1',

            'field-product-single-page' => '1',

            'field-show-by-category' => '1',

            'field-highlight-btn' => '1',

            'field-dynamic-attribute' => '',

            'field-repeat-price' => '',

            'field-repeat-add-to-cart' => '',

            'product-image-width' => 168,

            'product-image-height' => 168,

            'compare-menu-tab' => '0',

            'tablestyle-in-mobile' => 'mobile-flex',

            'field-mobile-remove-icon' => '',

           

        ];
    }

    private function apply_locked_settings( $options ) {

        $locked = $this->get_locked_settings();

        foreach ( $locked as $key => $value ) {

            $options[ $key ] = $value;

        }

        return $options;

    }

    public function reset()
    {
        if ($this->check_user_permission() && isset($_POST['inputs']) && $_POST['inputs'] == 'reset') {
            $checkOption = th_product_compare::get_cached_option();
            if ($checkOption) {
                delete_option($this->tpcp_optionName);
                th_product_compare::clear_cached_option();
                wp_send_json_success(true);
            }
        }
        die();
    }
    //////////////////////////////////
    // add product editing page  tabs 
    //////////////////////////////////

    function tpcp_save_input($product_id)
    {
        if (isset($_POST['tpcp_choose_product_auto_manual']) && $_POST['tpcp_choose_product_auto_manual'] != '') {
            // sanitize_text_field
            update_post_meta($product_id, 'tpcp_choose_product_auto_manual', sanitize_text_field($_POST['tpcp_choose_product_auto_manual']));
        }
        if (isset($_POST['tpcp_auto_show_compare']) && $_POST['tpcp_auto_show_compare'] != '') {
            update_post_meta($product_id, 'tpcp_auto_show_compare', sanitize_text_field($_POST['tpcp_auto_show_compare']));
        }
    }

    function tpcp_tab_custom($tabs)
    {
        $tabs['th-compare-custom'] = array(
            'label' => esc_html__('Compare Option', 'th-product-compare-pro'),
            'target' => 'th_custom_tab_product_option',
            'priority' => 51,
        );
        return $tabs;
    }
    public function excludeIds($arg, $productId)
    {
        return $arg;
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
    function tpcp_custom_template()
    {
        global $post;
        $productID = get_the_ID();
        include_once 'template/add-custom-tab-woocommerce.php';
    }

    // class end
}
