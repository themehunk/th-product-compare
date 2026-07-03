<?php
if (!defined('ABSPATH')) exit;
$save_productsMode = get_post_meta($productID, 'tpcp_choose_product_auto_manual', true);
$save_productsIds = get_post_meta($productID, 'tpcp_auto_show_compare', true);
$checkAuto = $checkManual = $checkHide = '';
if ($save_productsMode == 'manual') {
    $checkManual = 'selected=selected';
} else if ($save_productsMode == 'hide') {
    $checkHide = 'selected=selected';
} else {
    $checkOption = get_option('th_compare_option');
    if (isset($checkOption['th-compare-exclude-product']) && $checkOption['th-compare-exclude-product'] != '') {
        $getExcludeID = $this->excludeIds($checkOption['th-compare-exclude-product'], $productID);
        if (!$getExcludeID) {
            $checkAuto = 'selected=selected';
        }
    }
}
?>
<div id="th_custom_tab_product_option" class="panel woocommerce_save_productsIds_panel th_custom_tab_product_option" style="display:none;">
    <div>
        <div class="row_">
            <div>
                <span class="bold-heading"><?php esc_html_e("Show Compare Product", 'th-product-compare-pro'); ?></span>
            </div>
            <div>
                <select class="tpcp_choose_product_auto_manual" name="tpcp_choose_product_auto_manual">
                    <option <?php echo esc_attr($checkAuto); ?> value='auto'><?php esc_html_e("Auto", 'th-product-compare-pro'); ?> </option>
                    <option <?php echo esc_attr($checkManual); ?> value='manual'><?php esc_html_e("Manual", 'th-product-compare-pro'); ?></option>
                    <option <?php echo esc_attr($checkHide); ?> value='hide'><?php esc_html_e("None", 'th-product-compare-pro'); ?> </option>
                </select>
                <i class='description'><?php esc_html_e("Auto settings are the Default settings of Compare products setting. If you want to set settings manually for this product, please select the manual option from the dropdown.", 'th-product-compare-pro'); ?></i>
            </div>
        </div>
        <!-- tab content  -->
        <?php
        $checkShow = $checkManual ? 'active' : '';
        ?>
        <div class="row_ hide_show_wrap <?php echo esc_attr($checkShow); ?>">
            <div>
                <span class="bold-heading"><?php esc_html_e("Include Compare Product", 'th-product-compare-pro'); ?></span>
            </div>
            <div>

                <div class="th-compare-add-shortcode">
                    <div class="add-product-wrap">
                        <div class="add-by-enter-product">
                            <div class="added-product-id">
                                <input class="short put-in-input-hidden" type="hidden" name="tpcp_auto_show_compare" id="tpcp_auto_show_compare" value="">
                                <?php
                                if ($save_productsIds != '') {
                                    $exp_ = explode('|', $save_productsIds);
                                    if (is_array($exp_) && !empty($exp_)) {
                                        foreach ($exp_ as $value_) :
                                            $valueWithDash = explode('-', $value_);
                                ?>
                                            <span class="added_id" data-id="<?php echo esc_attr($valueWithDash[0]); ?>">
                                                <span class="dashicons dashicons-no rm_"></span>
                                                <span class="p_title"><?php esc_html_e($valueWithDash[1], 'th-product-compare-pro'); ?></span>
                                            </span>
                                <?php endforeach;
                                    }
                                }
                                ?>
                            </div>
                            <div class="wrap-input-product">
                                <div class="input-placeholder"><span></span></div>
                                <input type="text" name="th-compare-add-id-shortcode" value="">
                                <div class="product-result"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <i class='description'><?php esc_html_e("Select products manually to show them on compare table.", 'th-product-compare-pro'); ?> </i>

            </div>
        </div>
        <!-- tab content  -->
    </div>
</div>