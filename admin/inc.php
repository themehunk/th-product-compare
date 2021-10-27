<?php if (!defined('ABSPATH')) exit;

// popup directory
class th_product_compare
{
    private static $instance;
    public $localizeOption = [];
    private function __construct()
    {
        add_action('admin_init', array($this, 'create_roles'));
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_script'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_front_script'));
        add_filter('plugin_action_links_' . plugin_basename(TH_PRODUCT_PATH . '/' . basename(TH_PRODUCT_BASE_NAME)), array($this, 'add_menu_links'));
        $this->localizeOption = get_option('th_compare_option');
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
        add_menu_page(__('Th Product Compare', 'th-product-compare'), __('Th Product Compare', 'th-product-compare'), 'th_product_compare_manager', 'th-product-compare', array($this, 'display_addons'), TH_PRODUCT_URL . '/assets/img/th-nav-logo.png',59);
    }
    public function add_menu_links($links)
    {
        $links[] = '<a href="' . admin_url("admin.php?page=th-product-compare") . '">' . __('Settings', 'th-compare-product') . '</a>';
        $links['premium'] = '<a href="#"><b>' . __('Get Pro', 'th-compare-product') . '</b></a>';
        return $links;
    }
    public function display_addons()
    {
        if (isset($_GET['page']) && $_GET['page'] == 'th-product-compare') {

            $th_compare_option = $this->localizeOption; //appear in file pages/advance-setting.php, pages/general.php, pages/style.php
            // echo "<pre>";
            // print_r($th_compare_option);
            // echo "</pre>";
            include_once "page.php";
        }
    }
    public function enqueue_admin_script($hook)
    {
        // if ('check-plugin' != $hook) return;
        wp_enqueue_style('th-color-picker', TH_PRODUCT_URL . 'assets/color/nano.min.css', false);
        wp_enqueue_style('th-product-compare-style', TH_PRODUCT_URL . 'assets/style.css', false);
        wp_enqueue_script('th-color-picker', TH_PRODUCT_URL . 'assets/color/pickr.es5.min.js', array('jquery'), 1, true);
        wp_enqueue_script('th-product-js', TH_PRODUCT_URL . 'assets/js/script.js', [], 1, true);
        wp_localize_script('th-product-js', 'th_product', array('th_product_ajax_url' => admin_url('admin-ajax.php')));
    }

    public function enqueue_front_script()
    {
        wp_enqueue_style('th-product-compare-style-front', TH_PRODUCT_URL . 'assets/fstyle.css', false);
        wp_enqueue_script('th-product-js', TH_PRODUCT_URL . 'assets/js/fscript.js', array('jquery'), 1, true);
        wp_localize_script('th-product-js', 'th_product', array('th_product_ajax_url' => admin_url('admin-ajax.php')));
    }
}
