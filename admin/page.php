<?php if (!defined('ABSPATH')) exit;
// $ThGetOption = get_option('th_compare_option');

?>
<div class="th-product-compare-wrap">
    <div class="th-product-compare-container">
        <nav class="th-nav_">
            <span class="logo-detail">
                <div class="img_">
                    <img src="<?php echo TH_PRODUCT_URL . 'assets/img/th-logo.png'; ?>">
                </div>
                <span><?php _e('Th Product Compare', 'th-product-compare'); ?></span>
            </span>
            <a data-group-tabs="main" data-tab="general" href="#"><?php _e('General', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="style" href="#"><?php _e('Style', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="setting" href="#" class="active"><?php _e('Advance Settings', 'th-product-compare'); ?></a>
            <div class="th-save-btn">
                <button class="button th-compare-reset-style-btn">Reset</button>
                <button class="button button-primary th-option-save-btn">Save</button>
            </div>
        </nav>
        <div class="container-tabs">
            <!-- general tab -->
            <div data-group-tabs="main" data-tab-container="general">
                <?php include_once 'pages/general.php'; ?>
            </div>
            <!-- style tab -->
            <div data-group-tabs="main" data-tab-container="style">
                <?php include_once 'pages/style.php'; ?>
            </div>
            <!-- setting tab -->
            <div data-group-tabs="main" data-tab-container="setting" class="active">
                <?php include_once 'pages/advance-setting.php'; ?>
            </div>
            <!-- setting tab -->
        </div>

    </div>
</div>