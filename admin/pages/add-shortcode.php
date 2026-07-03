<?php if (!defined('ABSPATH')) exit;
$compareShortCode = isset($th_compare_option['th-compare-shortcode-hidden']) ? $th_compare_option['th-compare-shortcode-hidden'] : '';
$shortCodeHtml = '';
if ($compareShortCode != '') {
    $exp_ = explode('|', $compareShortCode);
    if (is_array($exp_) && !empty($exp_)) {
        foreach ($exp_ as $value_) {
            $valueWithDash = explode('-', $value_);
            $shortCodeHtml .= '<span class="added_id" data-id="' . esc_attr($valueWithDash[0]) . '"><span class="dashicons dashicons-dismiss rm_"></span><span class="p_title">' . esc_html__($valueWithDash[1]) . '</span></span>';
        }
    }
}
?>
<div class="setting_ th-compare-add-shortcode">
    <div class="field-to-show">
        <div class="th-tab-heading">
            <span class="heading_"><?php esc_html_e('Generate Shortcode', 'th-product-compare-pro'); ?></span>
        </div>
<div>
    <div class="row_">
        <div>
            <span class="bold-heading"><?php esc_html_e('Choose Products', 'th-product-compare-pro'); ?></span>
             <span class="th-alt-title"><?php esc_html_e(' Create shortcode with the desired products. You can use this shortcode anywhere in the pages & post.', 'th-product-compare-pro'); ?></span>
        </div>
        <div class="add-product-wrap">
            <div class="add-product-wrap-keep">
                <span class="bold-heading"><?php esc_html_e('Copy Shortcode', 'th-product-compare-pro'); ?></span>
                <div class="add-product-shortcode-shortcode">

                <div class="th-shortcode-code">

                 <div id="th-copy-generate-shortcode" class="th_product_compare_id">[tpcp_product_list pid='']</div>
                <button type="button" class="th-copy-btn" data-copy-target="th-copy-generate-shortcode">
                    Copy
                </button>
            </div>
                </div>


            </div>
            
            <div class="add-by-enter-product">
                <div class="added-product-id">
                    <input class="put-in-input-hidden" type="hidden" data-th-save='th-compare-shortcode-hidden' name="th-compare-add-id-shortcode-hidden" value="<?php echo esc_attr($compareShortCode); ?>">
                    <?php echo wp_kses($shortCodeHtml, th_product_compare::$allowKsesAttr); ?>
                </div>
                <div class="wrap-input-product">
                    <div class="input-placeholder"><span></span></div>
                    <input type="text" name='th-compare-add-id-shortcode' value="">
                    <div class="product-result"></div>
                </div>
            </div>
        </div>

    </div>
</div>
    </div>
   
</div>

<div class="th-shortcode-box">
            
            <div class="th-shortcode-header">
                <span class="th-shortcode-icon">⧉</span>
                <strong><?php esc_html_e('Display via Shortcode', 'th-product-compare-pro'); ?></strong>
            </div>

            <p class="th-shortcode-text">
                <?php esc_html_e('To display the compare button for a specific product anywhere on your site, use the following shortcode:', 'th-product-compare-pro'); ?>
            </p>

           <div class="th-shortcode-code">
                <code id="th-copy-pl-shortcode">[th_compare pid="856"]</code>
                <button type="button" class="th-copy-btn" data-copy-target="th-copy-pl-shortcode">
                    Copy
                </button>
            </div>


            <p class="th-shortcode-note">
                <?php esc_html_e('* Replace "856" with the specific Product ID.', 'th-product-compare-pro'); ?>
            </p>

        </div>

         <div class="th-shortcode-box">
            
            <div class="th-shortcode-header">
                <span class="th-shortcode-icon">⧉</span>
                <strong><?php esc_html_e('Display  Compare Product List via Shortcode', 'th-product-compare-pro'); ?></strong>
            </div>

            <p class="th-shortcode-text">
                <?php esc_html_e('To display the compare button for a specific product anywhere on your site, use the following shortcode:', 'th-product-compare-pro'); ?>
            </p>

           <div class="th-shortcode-code">
                <code id="th-copy-shortcode">[tpcp_product_list pid="856,834,851,855,34,29,34,853"]</code>
                <button type="button" class="th-copy-btn" data-copy-target="th-copy-shortcode">
                    Copy
                </button>
            </div>


            <p class="th-shortcode-note">
                <?php esc_html_e('* Replace "856,29 etc" with the specific Product ID.', 'th-product-compare-pro'); ?>
            </p>

        </div>