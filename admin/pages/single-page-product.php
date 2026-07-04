<?php
if (!defined('ABSPATH')) exit;
$checkChecked = [
    'field-auto-single-page' => '',
];

if (isset($th_compare_option['field-auto-single-page'])) {
    if ($th_compare_option['field-auto-single-page'] == '1') {
        $checkChecked['field-auto-single-page'] = 'checked=checked';
    } else {
        $checkChecked['field-auto-single-page'] = '';
    }
}
$th_single_product_limit = isset($th_compare_option['automatic-page-limit']) ? $th_compare_option['automatic-page-limit'] : 6;
$th_auto_singlePageBy = isset($th_compare_option['auto-single-page-by']) ? $th_compare_option['auto-single-page-by'] : '';
// exclude product 
$excludeProduct = isset($th_compare_option['th-compare-exclude-product']) ? $th_compare_option['th-compare-exclude-product'] : '';
$excludeHtml = '';
if ($excludeProduct != '') {
    $exp_ = explode('|', $excludeProduct);
    if (is_array($exp_) && !empty($exp_)) {
        foreach ($exp_ as $value_) {
            $valueWithDash = explode('-', $value_);
            $excludeHtml .= '<span class="added_id" data-id="' . esc_attr($valueWithDash[0]) . '"><span class="dashicons dashicons-dismiss rm_"></span><span class="p_title">' . esc_html($valueWithDash[1]) . '</span></span>';
        }
    }
}
?>
<div class="setting_">
    <div class="field-to-show automatically-add-compare <?php echo $checkChecked['field-auto-single-page'] ? esc_attr('active') : ''; ?>">
        <div class="th-tab-heading">
            <span class="heading_"><?php esc_html_e('Single Product Page Settings', 'th-product-compare'); ?></span>
        </div>
        <div>
            <!-- single product  -->
            <div class="row_ th-compare-radio-on">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Automated Comparison Table', 'th-product-compare'); ?></span>
                    <span class='th-alt-title'><?php esc_html_e('Check to Enable Comparison Table at Single Pages of All Products.', 'th-product-compare'); ?></span>
                </div>
                <div>
                    <div class="th-compare-radio">
                        <!--image-->
                        <input type="checkbox" <?php echo esc_attr($checkChecked['field-auto-single-page']); ?> data-th-save='compare-field' id="compare-fields-auto-single-page" value="auto-single-page">
                        <label class="th-color-title" for="compare-fields-auto-single-page"><?php esc_html_e('Comparison Table', 'th-product-compare'); ?></label>
                    </div>
                </div>
            </div>
            <!-- row  -->
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Product Compare By', 'th-product-compare'); ?></span>
                     <span class='th-alt-title'><?php esc_html_e('Select the filter to compare the products by', 'th-product-compare'); ?></span>
                </div>
                <div>
                    <div>
                        <select data-th-save='auto-single-page-by'>
                            <option <?php echo $th_auto_singlePageBy == 'cat' ? esc_attr('selected') : ''; ?> value="cat"><?php esc_html_e('Category', 'th-product-compare'); ?></option>
                            <option <?php echo $th_auto_singlePageBy == 'tag' ? esc_attr('selected') : ''; ?> value="tag"><?php esc_html_e('Tag', 'th-product-compare'); ?></option>
                            <option <?php echo $th_auto_singlePageBy == 'related' ? esc_attr('selected') : ''; ?> value="related"><?php esc_html_e('Related Product', 'th-product-compare'); ?></option>
                        </select>
                    </div>

                </div>
            </div>
            <!-- row  -->
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Number Of Product', 'th-product-compare'); ?></span>
                    <span class='th-alt-title'><?php esc_html_e('Max products allowed in a single product comparison page.', 'th-product-compare'); ?></span>
                </div>
                <div>
                    <input data-th-save='automatic-page-limit' type="number" placeholder="8" value="<?php echo esc_attr($th_single_product_limit); ?>">
                    <i class='description'><?php esc_html_e('Number of products limit to show on a single product comparison page.', 'th-product-compare'); ?></i>
                </div>
            </div>
            <!-- row  -->
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Exclude Product', 'th-product-compare'); ?></span>
                    <span class='th-alt-title'><?php esc_html_e('Select the products to exclude.', 'th-product-compare'); ?></span>
                </div>
                <div>
                    <div class="th-compare-add-shortcode">
                        <div class="add-product-wrap">
                            <div class="add-by-enter-product">
                                <div class="added-product-id">
                                    <input class="put-in-input-hidden" type="hidden" data-th-save='th-compare-exclude-product' name="th-compare-add-id-exclude-product" value="<?php echo esc_attr($excludeProduct); ?>">
                                    <?php echo wp_kses($excludeHtml, th_product_compare::$allowKsesAttr); ?>
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
            <!-- row  -->
            <div class="row_ th-compare-radio-on">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Manual Setup', 'th-product-compare'); ?></span>
                </div>
                <div>
                    
                    <i class='description'><?php esc_html_e('Check this doc to add Comparison Table Manually for Each Product.', 'th-product-compare'); ?><a target="_blank" href="<?php echo esc_url('https://themehunk.com/docs/th-product-compare-pro/#single-page'); ?>"><?php esc_html_e('Docs', 'th-product-compare'); ?></a></i>
                </div>
            </div>
            <!-- row  -->
            <!-- single product  -->
        </div>
    </div>
   
</div>