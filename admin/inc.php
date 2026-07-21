<?php if (!defined('ABSPATH')) exit;
// popup directory
class th_product_compare
{
    private static $instance;
    public $tpcp_localizeOption = [];
    private static $cached_option = null;
    private function __construct()
    {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_filter(
            'plugin_action_links_' . plugin_basename(TH_PRODUCT_PATH . '/' . basename(TH_PRODUCT_BASE_NAME)),
            array($this, 'add_menu_links')
        );
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_script'));
        if (isset($_GET['action']) && $_GET['action'] === 'edit') {
            add_action('admin_enqueue_scripts', array($this, 'enque_for_page_editing'));
        }
        add_action('wp_enqueue_scripts', array($this, 'enqueue_front_script'));
        $this->createPostForCustomPost();
        $this->tpcp_localizeOption = self::get_cached_option();

        if ( isset($_GET['page']) && $_GET['page'] === 'th-product-compare') {
                remove_all_actions('admin_notices');
                remove_all_actions('all_admin_notices');
            }
        
         add_filter('plugin_row_meta', array($this, 'docs_link'), 10, 2);
    }

    public static function get()
    {
        return self::$instance ? self::$instance : self::$instance = new self();
    }

    public static function get_cached_option()
    {
        if (self::$cached_option === null) {
            self::$cached_option = get_option('th_compare_option');
        }
        return self::$cached_option;
    }

    public static function clear_cached_option()
    {
        self::$cached_option = null;
    }

    public function admin_menu()
    {
        // add_menu_page(
        //     esc_html__('TH Compare Pro', 'th-product-compare'),
        //     esc_html__('TH Compare Pro', 'th-product-compare'),
        //     'manage_options',
        //     'th-product-compare',
        //     array($this, 'display_addons'),
        //     esc_url(TH_PRODUCT_URL . 'assets/img/th-nav-logo.png'),
        //     54,
        // );
        add_submenu_page('themehunk-plugins', __('Product Compare', 'th-product-compare'), __('Product Compare', 'th-product-compare'), 'manage_options', 'th-product-compare', array($this, 'display_addons'), 54);
    }

    public function add_menu_links($links)
    {
        $links[] = '<a href="' . esc_url(admin_url("admin.php?page=th-product-compare")) . '">' . esc_html__('Settings', 'th-product-compare') . '</a>';
        return $links;
    }
    public function display_addons()
    {
        if (isset($_GET['page']) && sanitize_text_field($_GET['page']) == 'th-product-compare') {
            $th_compare_option = $this->tpcp_localizeOption;
            include_once "page.php";
        }
    }

  public function docs_link($plugin_meta, $plugin_file)
    {
        if (strpos($plugin_file, 'th-product-compare-pro.php') !== false) {
            $new_links = array(
                'livedemo' => '<a href="' . esc_url('https://wpthemes.themehunk.com/th-product-compare-pro/') . '" target="_blank">' . __('Live Demo', 'th-product-compare') . '</a>',
                'documentation' => '<a href="' . esc_url('https://themehunk.com/docs/th-product-compare-pro/') . '" target="_blank">' . __('Documentation', 'th-product-compare') . '</a>',
                'support' => '<a href="' . esc_url('https://themehunk.com/contact-us/') . '" target="_blank">' . __('Support', 'th-product-compare') . '</a>',
                // 'premium_version' => '<a href="' . esc_url('https://themehunk.com/th-product-compare-plugin/') . '" target="_blank">' . __('Premium Version', 'th-product-compare') . '</a>',
                
                'rating'           => '<a href="' . esc_url('https://wordpress.org/support/plugin/th-product-compare/reviews/?filter=5') . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr__('Rate us on WordPress.org', 'th-product-compare') . '" style="color: #ffb900;">'
                                . str_repeat('<span class="dashicons dashicons-star-filled" style="font-size: 16px; width:16px; height: 16px;"></span>', 5)
                                . '</a>',
            );
            $plugin_meta = array_merge($plugin_meta, $new_links);
        }
        return $plugin_meta;
    }

    public function createPostForCustomPost()
    {
        if (!is_admin()) {
            return;
        }
        if (self::get_post_by_name() == null) {
            $postName = sanitize_text_field('th-product-compare-custom-post');
            $postTitle = sanitize_text_field('Product Compare');
            $my_post = array(
                'post_type' => 'page',
                'post_name' => $postName,
                'post_title'    => wp_strip_all_tags($postTitle),
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_author'   => 1,
            );
            wp_insert_post($my_post);
        }
    }

    public static function  get_post_by_name()
    {
        $check_page = get_option('th-product-compare-page5');
        if($check_page==null){
            add_option( 'th-product-compare-page5', true);            
        }

        return $check_page;
       

        // $query = new WP_Query([
        //     "name" => 'th-product-compare-custom-post'
        // ]);
        // return $query->have_posts() ? reset($query->posts) : null;
    }

    public function enqueue_admin_script()
    {

        if (isset($_GET['page']) && $_GET['page'] == 'th-product-compare') {
            wp_enqueue_style('tpcp-color-picker', TH_PRODUCT_URL . 'assets/color/nano.min.css', false, TH_PRODUCT_VERSION);
            wp_enqueue_style('th-product-compare-style', TH_PRODUCT_URL . 'assets/style.css', false, TH_PRODUCT_VERSION);
            wp_enqueue_style('th-product-compare-style-mobile', TH_PRODUCT_URL . 'assets/style-mobile.css', false, TH_PRODUCT_VERSION);
            wp_enqueue_script('tpcp-color-picker', TH_PRODUCT_URL . 'assets/color/pickr.es5.min.js', array('jquery'), TH_PRODUCT_VERSION, true);

            wp_enqueue_script('tpcp-product-js', TH_PRODUCT_URL . 'assets/js/script.js', array('jquery', 'jquery-ui-sortable'), TH_PRODUCT_VERSION, true);
            wp_localize_script(
                'tpcp-product-js',
                'th_product',
                array(
                    'tpcp_product_ajax_url' => esc_url(admin_url('admin-ajax.php')),
                    'th_compare_style' => $this->tpcp_localizeOption,
                    'tpcp_nonce' => wp_create_nonce('tpcp_plugin_nonce'),
                    'headingtext' => __('COMPARE PRODUCTS','th-product-compare')
                )
            );
        }
    }
    public function enque_for_page_editing()
    {
        wp_enqueue_style('th-product-compare-style-single-page', TH_PRODUCT_URL . 'assets/single-page-setting-back.css', false, TH_PRODUCT_VERSION);
        wp_enqueue_script('tpcp-product-js-single-page', TH_PRODUCT_URL . 'assets/js/single-page.js', [], TH_PRODUCT_VERSION, true);
        wp_localize_script(
            'tpcp-product-js-single-page',
            'th_product',
            array(
                'tpcp_product_ajax_url' => esc_url(admin_url('admin-ajax.php'))
            )
        );
    }
    public function enqueue_front_script()
    {
        if (!function_exists('is_woocommerce')) {
            return;
        }
        // Only load on WooCommerce pages (shop, product, cart, checkout, account) or pages with compare shortcode
        // global $post;
        // $has_shortcode = false;
        // if (isset($post->post_content)) {
        //     $has_shortcode = has_shortcode($post->post_content, 'th_compare')
        //         || has_shortcode($post->post_content, 'tpcp_product_list')
        //         || has_shortcode($post->post_content, 'th_product_compare_btn');
        // }
        // $is_compare_page = isset($post->post_name) && $post->post_name === 'th-product-compare-custom-post';

        // if (!is_woocommerce() && !is_cart() && !is_checkout() && !$has_shortcode && !$is_compare_page) {
        //     return;
        // }

        wp_enqueue_style('dashicons');
        wp_enqueue_style('th-product-compare-style-front', TH_PRODUCT_URL . 'assets/fstyle.css', false, TH_PRODUCT_VERSION);
        wp_enqueue_style('th-product-compare-style-front-mobile', TH_PRODUCT_URL . 'assets/fstyle-mobile.css', array('th-product-compare-style-front'), TH_PRODUCT_VERSION);



$excluded_themes = array(
    'top-store-pro',
    'open-shop',
    'open-shop-pro',
    'open-mart',
    'amaz-store',
    'jot-shop',
    'royal-shop',
    'royal-shop-pro',
    'big-store',
    'm-shop',
    'shopline',
    'shopline-pro',
    'almaira-shop',
    'almaira'
);

$current_theme = strtolower( wp_get_theme()->get_template() );

if ( ! in_array( $current_theme, $excluded_themes, true ) ) {

    $custom_css = '
    /* New Tooltip */
    .thunk-compare .th-product-compare-btn::after{
        content: attr(th-tooltip);
        position: absolute;
        left: 50%;
        bottom: calc(100% + 12px);
        transform: translateX(-50%) translateY(8px);
        background: #1f2937;
        color: #fff;
        font-size: 13px;
        font-weight: 500;
        line-height: 1;
        padding: 9px 14px;
        border-radius: 8px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: .25s ease;
        pointer-events: none;
        box-shadow: 0 8px 25px rgba(0,0,0,.18), 0 2px 6px rgba(0,0,0,.12);
        z-index: 9999;
    }

    /* Arrow */
    .thunk-compare .th-product-compare-btn::before{
        content: "";
        position: absolute;
        left: 50%;
        bottom: 100%;
        transform: translateX(-50%) translateY(8px);
        border-width: 6px;
        border-style: solid;
        border-color: #1f2937 transparent transparent transparent;
        opacity: 0;
        visibility: hidden;
        transition: .25s ease;
        pointer-events: none;
        z-index: 9999;
    }

    /* Hover */
    .thunk-compare .th-product-compare-btn:hover::after,
    .thunk-compare .th-product-compare-btn:hover::before{
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }
    ';

    wp_add_inline_style( 'th-product-compare-style-front', $custom_css );
}



        wp_enqueue_script('tpcp-product-js', TH_PRODUCT_URL . 'assets/js/fscript.js', array('jquery'), TH_PRODUCT_VERSION, true);
        wp_localize_script(
            'tpcp-product-js',
            'th_product',
            array(
                'tpcp_product_ajax_url' => esc_url(admin_url('admin-ajax.php')),
                'th_compare_style_local' => $this->tpcp_localizeOption,
                'headingtext' => __('COMPARE PRODUCTS','th-product-compare'),
                'view_cart_text' => __('View Cart','th-product-compare'),
            )
        );
    }
    public static function tpcp_decrypt($string, $key = 12345)
    {
        $result = '';
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
        return $result;
    }

    public static function tpcp_encrypt($string, $key = 12345)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    public static function cookieName()
    {
        $str = get_site_url();
        $getSlash = strrpos($str, "//") + 2;
        $removedSlash = substr($str, $getSlash);
        $removeSingleSlash = str_replace('/', "", $removedSlash);
        $removeColone = str_replace(':', "", $removeSingleSlash);
        $convertMd5 = md5($removeColone);
        $minLength = substr($convertMd5, -12);
        return 'th_compare_product_' . $minLength;
    }
    public static $allowKsesAttr = [
    'table' => [
        'class' => [], 'id' => [],
    ],
    'tbody' => [
        'class' => [], 'id' => [],
    ],
    'tr' => [
        'class' => [], 'id' => []
    ],
    'td' => [
        'class' => [], 'id' => [], 'colspan' => []
    ],
    'div' => [
        'class' => [], 'id' => [], 'data-product-id' => [], 'style' => [],
    ],
    'span' => [
        'class' => [], 'id' => [], 'style' => [], 'data-id' => [],
    ],
    'del' => [
        'class' => [], 'id' => [], 'style' => [],
    ],
    'bdi' => [
        'class' => [], 'id' => [], 'style' => [],
    ],
    'ins' => [
        'class' => [], 'id' => [], 'style' => [],
    ],
    'img' => [
        'class' => [],
        'id' => [],
        'width' => [],
        'height' => [],
        'src' => [],
        'alt' => [],
        'loading' => [],
        'srcset' => [],
        'sizes' => [],
        'data-th-output' => [],
        'data-th-save' => [],
        'data-th' => [],
    ],
    'a' => [
        'class' => [],
        'id' => [],
        'target' => [],
        'href' => [],
        'data-compare-category' => [],
        'data-product_id' => [],
        'data-product_sku' => [],
        'data-quantity' => [],
        'aria-label' => [],
        'rel' => [],
        'data-th-product-id' => [],
        'th-tooltip'=>[],
        'data-compare-limit' =>[]
    ],
    'p' => [
        'class' => [],
        'id' => [],
    ],
    'i' => [
        'class' => [], 'id' => [], 'data-th-product-id' => [],'data-compare-limit' =>[]
    ],
    'button' => [
        'class' => [], 'id' => [], 'data-th-product-id' => [], 'data-text' => []
    ],
    'svg' => [
        'class' => true,
        'xmlns' => true,
        'width' => true,
        'height' => true,
        'viewbox' => [],
        'fill' => true,
        'stroke' => true,
        'stroke-width' => true,
        'stroke-linecap' => true,
        'stroke-linejoin' => true,
        'aria-hidden' => true,
        'role' => true,
    ],
    'path' => [
        'd' => true,
        'fill' => true,
        'stroke' => true,
        'stroke-width' => true,
        'stroke-linecap' => true,
        'stroke-linejoin' => true,
    ],
    'input' => [
        'class' => [],
        'id' => [],
        'type' => [],
        'data-th-save' => [],
        'checked' => [],
        'data-custom-attr' => [],
        'value' => [],
        'name' => [],
        'data-th-product-id' => [], // Added to allow data-th-product-id
    ],
    'select' => [
        'class' => [],
    ],
    'option' => [
        'class' => [],
        'value' => [],
        'selected' => [],
    ],
    'label' => [
        'class' => [],
        'id' => [],
        'for' => [],
        'data-th-product-id' => [], // Added to allow data-th-product-id
    ]
];
    // class end 
}

if ( ! class_exists( 'th_product_compare_Compatibility' ) ):

    class th_product_compare_Compatibility {
         /**
         * Member Variable
         *
         * @var object instance
         */

       
       private static $instance;
       private $_settings_api;
  
       /**
         * Initiator
         */
        public static function instance() {
            if ( ! isset( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Constructor
         */
        public function __construct(){

    add_action( 'before_woocommerce_init', array( $this, 'hpos_compatibility') );

        }

              /**
     *  Declare the woo HPOS compatibility.
     */
    public function hpos_compatibility() {

            if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
                \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', TH_PRODUCT_BASE_NAME, true );
            }
    }

}

// Load Plugin
if ( ! function_exists( 'th_product_compare_compt' ) ) {
    
function th_product_compare_compt(){
        return th_product_compare_Compatibility::instance();
 }
add_action( 'plugins_loaded', 'th_product_compare_compt', 25 );

}

endif;
