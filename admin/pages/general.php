<?php
if (!defined('ABSPATH')) exit;

$th_product_compare_btn_txt = isset($th_compare_option['compare-btn-text']) ? sanitize_text_field($th_compare_option['compare-btn-text']) : __('Compare', 'th-product-compare');

$th_product_atleast_txt = isset($th_compare_option['compare-atleast-text']) ? sanitize_text_field($th_compare_option['compare-atleast-text']) : __('Select at least 2 products to compare', 'th-product-compare');

$th_product_limit = isset($th_compare_option['compare-product-limit']) ? sanitize_text_field($th_compare_option['compare-product-limit']) : 4;

$th_product_btn_type = isset($th_compare_option['compare-btn-type']) ? sanitize_text_field($th_compare_option['compare-btn-type']) : 'checkbox';

$th_product_shop_hook = isset($th_compare_option['compare-at-shop-hook']) ? sanitize_text_field($th_compare_option['compare-at-shop-hook']) : 'after';

$checkChecked = [
    'field-product-page' => 'checked="checked"',
    'field-product-single-page' => 'checked="checked"',
];

if (is_array($th_compare_option)) {
    foreach ($checkChecked as $key => $value) {
        if (isset($th_compare_option[$key])) {
            if ($th_compare_option[$key] == '1') {
                $checkChecked[$key] = 'checked="checked"';
            } else {
                $checkChecked[$key] = '';
            }
        }
    }
}
?>
<div class="th-general">
    <div class="th-option_">
        <span class="th-tab-heading"><?php esc_html_e('Appearance', 'th-product-compare'); ?></span>
        <table>
            <tr>
                <td><span class="th-color-title"><?php esc_html_e('Comapre Button Type', 'th-product-compare'); ?></span></td>
                <td>
                    <select data-th-save='compare-btn-type'>
                        <option value="checkbox" <?php echo esc_html($th_product_btn_type == 'checkbox' ? "selected" : ''); ?>><?php _e('checkbox', 'th-product-compare'); ?></option>
                        <option value="icon" <?php echo esc_html($th_product_btn_type == 'icon' ? "selected" : ''); ?>><?php _e('Link', 'th-product-compare'); ?></option>
                    </select>
                    <i class="description"><?php _e('How you want to display compare trigger.', 'th-product-compare'); ?></i>
                </td>
            </tr>

              <tr>
                <td><span class="th-color-title"><?php esc_html_e('Show Compare At Shop', 'th-product-compare'); ?></span></td>
                <td>
                    <select data-th-save='compare-at-shop-hook'>
                        <option value="before" <?php echo esc_html($th_product_shop_hook == 'before' ? "selected" : ''); ?>><?php _e('Before Cart', 'th-product-compare'); ?></option>
                        <option value="after" <?php echo esc_html($th_product_shop_hook == 'after' ? "selected" : ''); ?>><?php _e('After Cart', 'th-product-compare'); ?></option>
                    </select>
                    
                </td>
            </tr>

            <tr>
                <td><span class="th-color-title"><?php esc_html_e('Link / Button Text', 'th-product-compare'); ?></span></td>
                <td>
                    <input data-th-save='compare-btn-text' type="text" placeholder="Compare" value="<?php echo esc_html($th_product_compare_btn_txt); ?>">
                    <i class="description"><?php esc_html_e('This value define maximum number of products you want to add in the compare table.', 'th-product-compare'); ?></i>
                </td>
            </tr>
            <tr>
                <td><span class="th-color-title"><?php esc_html_e('Number of Product to Compare', 'th-product-compare') ?></span></td>
                <td>
                    <input data-th-save='compare-product-limit' type="number" placeholder="4" value="<?php echo esc_html($th_product_limit); ?>"  readonly>
                </td>
            </tr>
            <tr>
                <td><span class="th-color-title"><?php esc_html_e('Display Compare Button', 'th-product-compare') ?></span></td>
                <td>
                    <div class="th-compare-radio">
                        <!--title-->
                        <input type="checkbox" data-th-save='compare-field' id="field-show-product-page" <?php echo esc_html($checkChecked['field-product-single-page']); ?> value="product-single-page">
                        <label class="th-color-title" for="field-show-product-page"><?php esc_html_e('Product Single Page.', 'th-product-compare') ?></label>
                    </div>
                </td>
            </tr>

            <tr>
                <td><span class="th-atleast-title"><?php esc_html_e('Minimum products message', 'th-product-compare'); ?></span></td>
                <td>
                    <input data-th-save='compare-atleast-text' type="text" placeholder="Compare" value="<?php echo esc_html($th_product_atleast_txt); ?>">
                    <!-- <i class="description"><?php esc_html_e('This value define maximum number of products you want to add in the compare table.', 'th-product-compare'); ?></i> -->
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <div class="th-compare-radio">
                        <!--title-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-product-list" <?php echo esc_html($checkChecked['field-product-page']); ?> value="product-page">
                        <label class="th-color-title" for="compare-fields-product-list"><?php esc_html_e('Shop and Archive Pages.', 'th-product-compare') ?></label>
                    </div>
                </td>
            </tr>

             <tr>
            
                <td>
                    <h4>Using shortcode:     
                    </h4>
                </td>

                <td>
                    <h4 class="compare-th_compare">Just put this [th_compare pid="123"] 
                        to display compare at your desired location.
                    </h4>
                    <p>* pid="123" is the product ID. *</p>
                </td>
            </tr>

        </table>
    </div>
</div>