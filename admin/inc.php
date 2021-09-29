<?php if (!defined('ABSPATH')) exit;

// popup directory
class th_product_compare
{
    private static $instance;
    public $localizeOption = [];
    private function __construct()
    {
        $this->localizeOption = get_option('th_compare_option');
        add_action('admin_init', array($this, 'create_roles'));
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_script'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_front_script'));
    }
    public static function get()
    {
        return self::$instance ? self::$instance : self::$instance = new self();
    }

    public function create_roles()
    {
        global $wp_roles;

        if (!class_exists('WP_Roles')) {
            return;
        }
        if (!isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }
        // Shop manager role
        add_role('th_product_compare_role', __('Product Compare Role', 'th-product-compare'), array(
            'level_9'        => true,
            'read'          => true,
        ));
        $wp_roles->add_cap('th_product_compare_role', 'th_product_compare_manager');
        $wp_roles->add_cap('administrator', 'th_product_compare_manager');
    }
    public function admin_menu()
    {
        add_menu_page(__('Product Compare', 'th-product-compare'), __('Product Compare', 'th-product-compare'), 'th_product_compare_manager', 'th-product-compare', array($this, 'display_addons'), "dashicons-update");
    }
    public function display_addons()
    {
        if (isset($_GET['page']) && $_GET['page'] == 'th-product-compare') {
            // echo "<pre>";
            // print_r($this->localizeOption);
            // // echo $this->thCompareAddonStyle();
            // echo "</pre>";
            $th_compare_option = $this->localizeOption;
            include_once "page.php";
        }
    }

    public function thCompareAddonStyle()
    {
        $th_compare_option = $this->localizeOption;
        $styleCSs = '';
        if (!empty($th_compare_option)) {
            foreach ($th_compare_option as $ckey => $cvalue) {
                if ($ckey == 'fore-ground-bgth-idbackground-color') {
                    $styleCSs .= '.th-compare-popup-dummy{background-color:' . $cvalue . ';}';
                } else if ($ckey == 'dummy-border-colorth-idborder-color') {
                    $styleCSs .= '.th-compare-popup-dummy .inner-wrap_{border-color:' . $cvalue . ';}';
                } else if ($ckey == 'heading-styleth-idbackground-color') {
                    $styleCSs .= '.th-compare-popup-dummy .inner-wrap_ .heading{background-color:' . $cvalue . ';}';
                } else if ($ckey == 'heading-styleth-idcolor') {
                    $styleCSs .= '.th-compare-popup-dummy .inner-wrap_ .heading{color:' . $cvalue . ';}';
                } else if ($ckey == 'row-odd-bgth-idbackground-color') {
                    $styleCSs .= '.th-compare-popup-dummy .inner-wrap_ .table_ table tr:nth-child(odd){background-color:' . $cvalue . ';}';
                } else if ($ckey == 'row-even-bgth-idbackground-color') {
                    $styleCSs .= '.th-compare-popup-dummy .inner-wrap_ .table_ table tr:nth-child(even){background-color:' . $cvalue . ';}';
                } else if ($ckey == 'rating-colorth-idcolor') {
                    $styleCSs .= '.th-compare-popup-dummy .inner-wrap_ .table_ .rating_{color:' . $cvalue . ';}';
                } else if ($ckey == 'remove-btn-colorth-idcolor') {
                    $styleCSs .= '.th-compare-popup-dummy .inner-wrap_ .table_ .rm-product{color:' . $cvalue . ';}';
                }
            }
        }
        return $styleCSs ? $styleCSs : '';
    }

    public function enqueue_admin_script($hook)
    {
        // if ('toplevel_page_business-popup' != $hook) return;
        wp_enqueue_style('th-color-picker', TH_PRODUCT_URL . 'assets/color/nano.min.css', false);
        wp_enqueue_style('th-product-compare-style', TH_PRODUCT_URL . 'assets/style.css', false);
        wp_enqueue_script('th-color-picker', TH_PRODUCT_URL . 'assets/color/pickr.es5.min.js', array('jquery'), 1, true);
        wp_enqueue_script('th-product-js', TH_PRODUCT_URL . 'assets/js/script.js', [], 1, true);
        wp_localize_script('th-product-js', 'th_product', array('th_product_ajax_url' => admin_url('admin-ajax.php'), 'th_compare_style_local' => $this->thCompareAddonStyle()));
    }

    public function enqueue_front_script()
    {
        wp_enqueue_style('th-product-compare-style-front', TH_PRODUCT_URL . 'assets/fstyle.css', false);
        wp_enqueue_script('th-product-js', TH_PRODUCT_URL . 'assets/js/fscript.js', array('jquery'), 1, true);
        wp_localize_script('th-product-js', 'th_product', array('th_product_ajax_url' => admin_url('admin-ajax.php'), 'th_compare_style_local' => $this->localizeOption));
    }
}
