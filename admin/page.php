<?php if (!defined('ABSPATH')) exit; 
if ( ! function_exists( 'thpc_get_svg_icon' ) ) {
    function thpc_get_svg_icon( $name ) {

        $icons = [

            // ⚙️ Basic Settings Icon (Gear)
            'settings' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.1a2 2 0 0 1-1-1.72v-.51a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
            ',

            // 🔧 Advance Icon
            'advance' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" x2="4" y1="21" y2="14"></line>
                <line x1="4" x2="4" y1="10" y2="3"></line>
                <line x1="12" x2="12" y1="21" y2="12"></line>
                <line x1="12" x2="12" y1="8" y2="3"></line>
                <line x1="20" x2="20" y1="21" y2="16"></line>
                <line x1="20" x2="20" y1="12" y2="3"></line>
                <line x1="1" x2="7" y1="14" y2="14"></line>
                <line x1="9" x2="15" y1="8" y2="8"></line>
                <line x1="17" x2="23" y1="16" y2="16"></line>
            </svg>
            ',

            // 🔐 Premium Icon
            'premium' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            ',

            // ❓ Help Icon
            'help' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                <path d="M12 17h.01"></path>
            </svg>
            ',

            // 🔌 Useful Plugins Icon
            'plugins' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22v-5"></path>
                <path d="M9 8V2"></path>
                <path d="M15 8V2"></path>
                <path d="M18 8v5a4 4 0 0 1-4 4h-4a4 4 0 0 1-4-4V8Z"></path>
            </svg>
            ',

            // 🔌 Style Icon
            'style' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5"></circle><circle cx="17.5" cy="10.5" r=".5"></circle><circle cx="8.5" cy="7.5" r=".5"></circle><circle cx="6.5" cy="12.5" r=".5"></circle><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path></svg>
            ',


              // 🔌 Single Page Icon
            'singlepage' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><path d="M3 9h18"></path><path d="M9 21V9"></path></svg>
            ',

              // 🔌 Shortcode Icon
            'shortcode' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
            ',

            // 🔌 hooks Icon
            'hooks' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h3a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5"></path><path d="M19 4h-3a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3"></path><path d="m10 19 4-14"></path></svg>
            ',

            // 📱 Mobile Icon
            'mobile' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect><path d="M12 18h.01"></path></svg>
            ',

            // 🔵 Compare Icon
            'compare-icon' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path></svg>
            ',

            // 🔌 Reset Icon
            'reset' => '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-ccw"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path><path d="M16 16h5v5"></path></svg>
            ',
        ];

        return $icons[ $name ] ?? '';
    }
}

?>
<div class="th-product-compare-wrap th-plugin-common-wrap">
    <div class="th-product-compare-container">
    <div class="th-left">    
    <nav class="th-nav_">
            <span class="logo-detail">
                <div class="img_">
                    <img src="<?php echo esc_url(TH_PRODUCT_URL . 'assets/img/th-logo.png'); ?>">
                </div>
                <span><?php esc_html_e('Product Compare', 'th-product-compare'); ?></span>
            </span>
            <a data-group-tabs="main" data-tab="general" href="#" class="active"><span ><?php echo thpc_get_svg_icon('settings'); ?></span><?php esc_html_e('Basic Settings', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="setting" href="#" class="pro-tabs"><span><?php echo thpc_get_svg_icon('advance'); ?></span><?php esc_html_e('Advanced (Pro)', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="single-page-product" href="#"><span><?php echo thpc_get_svg_icon('singlepage'); ?></span><?php esc_html_e('Single Product Page', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="add-shortcode" href="#" class="pro-tabs"><span><?php echo thpc_get_svg_icon('shortcode'); ?></span><?php esc_html_e('Shortcode Generator (Pro)', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="add-hook" href="#"><span><?php echo thpc_get_svg_icon('hooks'); ?></span><?php esc_html_e('Custom Hook', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="style" href="#"><span><?php echo thpc_get_svg_icon('style'); ?></span><?php esc_html_e('Style', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="mobile" href="#" class="pro-tabs"><span><?php echo thpc_get_svg_icon('mobile'); ?></span><?php esc_html_e('Mobile Style (Pro)', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="compare-icon" href="#"><span><?php echo thpc_get_svg_icon('compare-icon'); ?></span><?php esc_html_e('Compare Icon', 'th-product-compare'); ?></a>

            <a data-group-tabs="main" data-tab="help" href="#"><span><?php echo thpc_get_svg_icon('help'); ?></span><?php esc_html_e('Help', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="reset" href="#"><span><?php echo thpc_get_svg_icon('reset'); ?></span><?php esc_html_e('Reset', 'th-product-compare'); ?></a>

        </nav>

         <div class="th-subscribe-btn">
                    <h4><?php esc_html_e('Pro Plan', 'th-product-compare'); ?></h4>
                    <h5><?php esc_html_e('Upgrade for more features', 'th-product-compare'); ?></h5>
                    <a href="<?php echo esc_url('https://themehunk.com/th-product-compare-plugin/'); ?>" target="_blank" class="th-support-btn button button-primary"><?php esc_html_e('Upgrade Now', 'th-product-compare'); ?></a>  
        </div>
        
    </div>
    <div class="th-right">
        <div class="top-header">
                <h2 class="tabheading"><?php esc_html_e("Basic Settings", 'th-product-compare'); ?></h2>
                <a href="<?php echo esc_url( 'https://themehunk.com/product-compare-plugin/' ); ?>"
               title="<?php esc_attr_e( 'Get Premium Version', 'th-all-in-one-woo-cart' ); ?>"
               target="_blank">
                <?php esc_html_e( 'Get Premium Version', 'th-all-in-one-woo-cart' ); ?>
                </a>
                <div class="th-save-btn">
                <button class="button button-primary th-option-save-btn"><?php esc_html_e("Save Changes", 'th-product-compare'); ?></button>
                </div>
            </div>

        <div class="container-tabs">
            
            <!-- general tab -->
            <div data-group-tabs="main" data-tab-container="general" class="active">
                <?php include_once 'pages/general.php'; ?>
            </div>
            <!-- setting tab -->
            <div data-group-tabs="main" data-tab-container="setting">
                <?php include_once 'pages/advance-setting.php'; ?>
            </div>

              <!-- shortcode tab -->
            <div data-group-tabs="main" data-tab-container="add-hook">
                <?php include_once 'pages/custom-hook.php'; ?>
            </div>

            <!-- shortcode tab -->
            <div data-group-tabs="main" data-tab-container="add-shortcode">
                <?php include_once 'pages/add-shortcode.php'; ?>
            </div>
            <!-- single page Product -->
            <div data-group-tabs="main" data-tab-container="single-page-product">
                <?php include_once 'pages/single-page-product.php'; ?>
            </div>
                        <!-- style tab -->
            <div data-group-tabs="main" data-tab-container="style">
                <?php include_once 'pages/style.php'; ?>
            </div>
            <!-- mobile tab -->
            <div data-group-tabs="main" data-tab-container="mobile">
                <?php include_once 'pages/mobile.php'; ?>
            </div>
            <!-- compare icon tab -->
            <div data-group-tabs="main" data-tab-container="compare-icon">
                <?php include_once 'pages/compare-icon.php'; ?>
            </div>
            <!-- help tab -->
            <div data-group-tabs="main" data-tab-container="help">
                <?php include_once 'pages/help.php'; ?>
            </div>
             <!-- reset tab -->
            <div data-group-tabs="main" data-tab-container="reset">
                <?php include_once 'pages/reset.php'; ?>
            </div>
        </div>
    </div>

    </div>
</div>