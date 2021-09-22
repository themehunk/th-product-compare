<?php if (!defined('ABSPATH')) exit; ?>
<div class="th-product-compare-wrap">
    <div class="th-product-compare-container">
        <nav class="th-nav_">
            <a data-group-tabs="main" data-tab="general" href="#"><?php _e('General', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="style" href="#" class="active"><?php _e('Style', 'th-product-compare'); ?></a>
            <a data-group-tabs="main" data-tab="setting" href="#"><?php _e('Setting', 'th-product-compare'); ?></a>
        </nav>
        <div class="container-tabs">
            <!-- general tab -->
            <div data-group-tabs="main" data-tab-container="general">
                <?php include_once 'pages/general.php'; ?>
            </div>
            <!-- style tab -->
            <div data-group-tabs="main" data-tab-container="style" class="active">
                <?php include_once 'pages/style.php'; ?>
            </div>
            <!-- setting tab -->
            <div data-group-tabs="main" data-tab-container="setting">
                <div class="setting_">
                    <h1>shortcode Setting</h1>
                </div>
            </div>
            <!-- setting tab -->
        </div>
        <div class="th-save-btn">
            <button class="th-option-save-btn">Save</button>
        </div>
    </div>
</div>