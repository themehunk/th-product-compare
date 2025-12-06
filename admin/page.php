<?php if (!defined('ABSPATH')) exit; ?>
<div class="th-product-compare-wrap th-plugin-common-wrap">
    <div class="th-product-compare-container">
        <nav class="th-nav_">
            <span class="logo-detail">
                <div class="img_">
                    <img src="<?php echo esc_url(TH_PRODUCT_URL . 'assets/img/th-logo.png'); ?>">
                </div>
                <span><?php esc_html_e('Compare', 'th-product-compare'); ?></span>
            </span>
            <a data-group-tabs="main" data-tab="general" href="#" class="active"><span class="dashicons dashicons-admin-generic"></span><?php esc_html_e('Basic Settings', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="setting" href="#"><span class="dashicons dashicons-hammer"></span><?php esc_html_e('Advance', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="pro-feature" href="#"><span class="dashicons dashicons-unlock"></span><?php esc_html_e('Premium', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="help" href="#"><span class="dashicons dashicons-editor-help"></span><?php esc_html_e('Help', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="themehunk-useful" href="#"><span class="dashicons dashicons-admin-plugins"></span><?php esc_html_e('Useful Plugins', 'th-product-compare'); ?></a>
            
        </nav>

        <div class="th-right">
        <div class="top-header">
                <h2 class="tabheading"><?php esc_html_e("Basic Settings", 'th-product-compare'); ?></h2>
                <div class="th-save-btn">
                    <button class="button th-compare-reset-style-btn"><?php esc_html_e("Reset Defaults", 'th-product-compare'); ?></button>
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
            <!-- help tab -->
            <div data-group-tabs="main" data-tab-container="help">
                <?php include_once 'pages/help.php'; ?>
            </div>
            <!-- pro feature tab -->
            <div data-group-tabs="main" data-tab-container="pro-feature">
                <?php include_once 'pages/pro-feature.php'; ?>
            </div>
            <!-- useful plugins tab -->
            <div data-group-tabs="main" data-tab-container="themehunk-useful">
                <?php include_once 'pages/themehunk-useful-plugins.php'; ?>
            </div>

        </div>

        </div>

    </div>

</div>