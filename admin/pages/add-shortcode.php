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
$product_image  = TH_PRODUCT_URL . 'assets/img/shirt.png';
$product_image2 = TH_PRODUCT_URL . 'assets/img/shirt2.png';
?>
<div class="setting_ th-compare-add-shortcode">
    <div class="field-to-show">
        <div class="th-tab-heading">
            <span class="heading_"><?php esc_html_e('Generate Shortcode', 'th-product-compare'); ?></span>
        </div>
<div>
    <div class="row_">
        <div>
            <span class="bold-heading"><?php esc_html_e('Choose Products', 'th-product-compare'); ?></span>
             <span class="th-alt-title"><?php esc_html_e(' Create shortcode with the desired products. You can use this shortcode anywhere in the pages & post.', 'th-product-compare'); ?></span>
        </div>
        <div class="add-product-wrap">
            <div class="add-product-wrap-keep">
                <span class="bold-heading"><?php esc_html_e('Copy Shortcode', 'th-product-compare'); ?></span>
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
                    
                </div>
                <div class="wrap-input-product">
                    <div class="product-result-example">
                        <span class="checked"><input type="checkbox" class="product-check"><div class="img_"><img src="<?php echo esc_url($product_image); ?>"></div><span><?php esc_html_e('Shirt', 'th-product-compare'); ?></span></span>
                        <span class="checked"><input type="checkbox" class="product-check"><div class="img_"><img src="<?php echo esc_url($product_image2); ?>"></div><span><?php esc_html_e('Blazer', 'th-product-compare'); ?></span></span>
                        <span class="checked"><input type="checkbox" class="product-check"><div class="img_"><img src="<?php echo esc_url($product_image); ?>"></div><span><?php esc_html_e('Shirt', 'th-product-compare'); ?></span></span>
                        <span class="checked"><input type="checkbox" class="product-check"><div class="img_"><img src="<?php echo esc_url($product_image2); ?>"></div><span><?php esc_html_e('Blazer', 'th-product-compare'); ?></span></span>
                        <span class="checked"><input type="checkbox" class="product-check"><div class="img_"><img src="<?php echo esc_url($product_image); ?>"></div><span><?php esc_html_e('Shirt', 'th-product-compare'); ?></span></span>
                    </div>
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
                <strong><?php esc_html_e('Display via Shortcode', 'th-product-compare'); ?></strong>
            </div>

            <p class="th-shortcode-text">
                <?php esc_html_e('To display the compare button for a specific product anywhere on your site, use the following shortcode:', 'th-product-compare'); ?>
            </p>

           <div class="th-shortcode-code">
                <code id="th-copy-pl-shortcode">[th_compare pid="856"]</code>
                <button type="button" class="th-copy-btn" data-copy-target="th-copy-pl-shortcode">
                    Copy
                </button>
            </div>


            <p class="th-shortcode-note">
                <?php esc_html_e('* Replace "856" with the specific Product ID.', 'th-product-compare'); ?>
            </p>

        </div>

         <div class="th-shortcode-box">
            
            <div class="th-shortcode-header">
                <span class="th-shortcode-icon">⧉</span>
                <strong><?php esc_html_e('Display  Compare Product List via Shortcode', 'th-product-compare'); ?></strong>
            </div>

            <p class="th-shortcode-text">
                <?php esc_html_e('To display the compare button for a specific product anywhere on your site, use the following shortcode:', 'th-product-compare'); ?>
            </p>

           <div class="th-shortcode-code">
                <code id="th-copy-shortcode">[tpcp_product_list pid="856,834,851,855,34,29,34,853"]</code>
                <button type="button" class="th-copy-btn" data-copy-target="th-copy-shortcode">
                    Copy
                </button>
            </div>


            <p class="th-shortcode-note">
                <?php esc_html_e('* Replace "856,29 etc" with the specific Product ID.', 'th-product-compare'); ?>
            </p>

        </div>